<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Email;
use Google\Client;
use Google\Service\Gmail;

class GmailController extends Controller
{
    /**
     * create google client using env directly
     */
    private function googleClient(Lead $lead)
    {
        $clientId     = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri  = env('GOOGLE_REDIRECT_URI');

        abort_if(
            !$clientId || !$clientSecret || !$redirectUri,
            500,
            'Google OAuth ENV variables are missing'
        );

        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            'https://www.googleapis.com/auth/gmail.readonly'
        ]);

        // set token if exists
        if ($lead->google_access_token) {
            $client->setAccessToken($lead->google_access_token);

            if ($client->isAccessTokenExpired() && $lead->google_refresh_token) {
                $newToken = $client->fetchAccessTokenWithRefreshToken(
                    $lead->google_refresh_token
                );

                $lead->update([
                    'google_access_token' => $newToken['access_token']
                ]);
            }
        }

        return $client;
    }

    /**
     * redirect lead to google oauth
     */
    public function gmailConnect(Lead $lead)
    {
        session(['gmail_lead_id' => $lead->id]);

        return redirect(
            $this->googleClient($lead)->createAuthUrl()
        );
    }

    /**
     * google oauth callback
     */
    public function gmailCallback(Request $request)
    {
        $leadId = session('gmail_lead_id');
        abort_if(!$leadId, 403);

        $lead = Lead::findOrFail($leadId);

        $client = $this->googleClient($lead);
        $token  = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect()->back()->with('error', $token['error_description'] ?? 'Google auth failed');
        }

        $client->setAccessToken($token);
        $gmail = new Gmail($client);

        // get connected email
        $profile = $gmail->users->getProfile('me');

        $lead->update([
            'email_provider'       => 'gmail',
            'connected_email'      => $profile->getEmailAddress(),
            'google_access_token'  => $token['access_token'],
            'google_refresh_token' => $token['refresh_token'] ?? $lead->google_refresh_token,
            'is_email_connected'   => true,
            'email_connected_at'   => now(),
        ]);

        return redirect()
            ->route('admin.timeline', $lead->id)
            ->with('success', 'Gmail connected successfully');
    }

    /**
     * manual sync inbox + sent emails
     */
    public function sync(Lead $lead)
    {
        abort_if(!$lead->is_email_connected, 403);

        $gmail = new Gmail($this->googleClient($lead));
        $user  = 'me';

        foreach (['INBOX', 'SENT'] as $label) {

            $messages = $gmail->users_messages->listUsersMessages($user, [
                'labelIds'   => [$label],
                'maxResults' => 50
            ]);

            if (!$messages->getMessages()) {
                continue;
            }

            foreach ($messages->getMessages() as $msg) {

                if (Email::where('message_id', $msg->getId())->exists()) {
                    continue;
                }

                $message = $gmail->users_messages->get(
                    $user,
                    $msg->getId(),
                    ['format' => 'full']
                );

                $headers = collect($message->getPayload()->getHeaders());

                Email::create([
                    'lead_id'    => $lead->id,
                    'message_id' => $message->getId(),
                    'thread_id'  => $message->getThreadId(),
                    'from'       => optional($headers->firstWhere('name','From'))->value,
                    'to'         => optional($headers->firstWhere('name','To'))->value,
                    'subject'    => optional($headers->firstWhere('name','Subject'))->value,
                    'body'       => $this->getBody($message),
                    'label'      => $label,
                    'email_date' => now(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Emails synced successfully'
        ]);
    }

    /**
     * extract email body
     */
    private function getBody($message)
    {
        $payload = $message->getPayload();

        if ($payload->getBody()->getData()) {
            return base64_decode(
                str_replace(['-','_'], ['+','/'], $payload->getBody()->getData())
            );
        }

        foreach ((array) $payload->getParts() as $part) {
            if ($part->getMimeType() === 'text/plain' && $part->getBody()->getData()) {
                return base64_decode(
                    str_replace(['-','_'], ['+','/'], $part->getBody()->getData())
                );
            }
        }

        return null;
    }

    public function gmailDisconnect(Lead $lead)
    {
        $lead->update([
            'google_access_token'  => null,
            'google_refresh_token' => null,
            'email_provider'       => null,
            'connected_email'      => null,
            'is_email_connected'   => false,
            'email_connected_at'   => null,
        ]);

        return back()->with('success', 'Gmail disconnected successfully');
    }
}
