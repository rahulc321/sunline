<?php
use Illuminate\Support\Facades\Mail;
use App\Models\Email;
use App\Models\Lead;
use Carbon\Carbon;
use App\Models\Tier;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;


if (! function_exists('testFunction')) {
	function testFunction()
	{
		dd('test fun');
	}
}


if (! function_exists('sendGlobalEmail')) {

  

    function sendGlobalEmail(
        $to,
        $subject,
        $body,
        $templateId = null,
        $category = null,
        $leadId = null,
        $type = null,
        $data = [],
        $threadId = null,     // optional
        $messageId = null     // optional (for reply)
    ) {
        //try {

            /* ===============================
            | 1️⃣ Replace placeholders
            =============================== */
            foreach ($data as $key => $value) {
                $body    = str_replace('{'.$key.'}', $value, $body);
                $subject = str_replace('{'.$key.'}', $value, $subject);
            }

            /* ===============================
            | 2️⃣ Render Blade template
            =============================== */
            $htmlBody = view('admin.emails.custom-email', [
                'subject' => $subject,
                'body'    => $body,
            ])->render();

            /* ===============================
            | 3️⃣ Gmail OAuth Client
            =============================== */
            $user = auth()->user(); // connected gmail user

            $client = new Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setAccessType('offline');

            $client->setAccessToken([
                'access_token'  => $user->google_access_token,
                'refresh_token' => $user->google_refresh_token,
            ]);

            if ($client->isAccessTokenExpired()) {
                $token = $client->fetchAccessTokenWithRefreshToken(
                    $user->google_refresh_token
                );

                $user->update([
                    'google_access_token' => $token['access_token']
                ]);

                $client->setAccessToken($token);
            }

            /* ===============================
            | 4️⃣ Gmail Service
            =============================== */
            $service = new Gmail($client);

            /* ===============================
            | 5️⃣ Build RAW HTML Email
            =============================== */
            $boundary = uniqid();

            $raw =
                "From: {$user->connected_email}\r\n" .
                "To: {$to}\r\n" .
                "Subject: {$subject}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n";

            // threading headers (optional)
            if ($messageId) {
                $raw .=
                    "In-Reply-To: {$messageId}\r\n" .
                    "References: {$messageId}\r\n";
            }

            $raw .= "\r\n" .
                "--$boundary\r\n" .
                "Content-Type: text/html; charset=UTF-8\r\n\r\n" .
                $htmlBody . "\r\n\r\n" .
                "--$boundary--";

            $encoded = rtrim(
                strtr(base64_encode($raw), '+/', '-_'),
                '='
            );

            $gmailMessage = new Message();
            $gmailMessage->setRaw($encoded);

            if ($threadId) {
                $gmailMessage->setThreadId($threadId);
            }

            /* ===============================
            | 6️⃣ Send Email
            =============================== */
            $service->users_messages->send('me', $gmailMessage);

            /* ===============================
            | 7️⃣ Save to DB (unchanged)
            =============================== */
            Email::create([
                'template_id'     => $templateId,
                'category'        => $category,
                'subject'         => $subject,
                'body'            => $body,
                'type'            => $type,
                'recipient_email' => $to,
                'lead_id'         => $leadId,
            ]);

            return true;

        // } catch (\Exception $e) {
        //     \Log::error('Gmail send failed: '.$e->getMessage());
        //     return false;
        // }
    }




    function sendGlobalEmail_old($to, $subject, $body, $templateId = null, $category = null, $leadId = null,$type = null,$data=[])
    {
		//try {
            # replace placeholders
            foreach ($data as $key => $value) {
                $body = str_replace('{'.$key.'}', $value, $body);
                $subject = str_replace('{'.$key.'}', $value, $subject);
            }

            # render blade view into HTML
            $htmlBody = view('admin.emails.custom-email', [
                'subject' => $subject,
                'body'    => $body,
            ])->render();

            # send email
            Mail::html($htmlBody, function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });

			 # save to db
			 Email::create([
                'template_id'     => $templateId,
                'category'        => $category,
                'subject'         => $subject,
                'body'            => $body,
				'type'            => $type,
                'recipient_email' => $to,
                'lead_id'         => $leadId,
            ]);

            return true;
        // } catch (\Exception $e) {
        //     \Log::error('Email send failed: '.$e->getMessage());
        //     return false;
        // }
    }

    
}


if (! function_exists('isSalesRep')) {
    /**
     * Check if the current authenticated user has the Sales Rep role
     *
     * @return int 1 if Sales Rep, 0 otherwise
     */
    function isSalesRep()
    {
        $user = Auth::user();
        if (!$user) {
            return 0;
        }

        // assuming your role title is stored in 'title'
        return $user->roles->contains('title', 'Sales Rep') ? 1 : 0;
    }
}

if (! function_exists('getCommision')) {
    /**
     * Check if the current authenticated user has the Sales Rep role
     *
     * @return int 1 if Sales Rep, 0 otherwise
     */
    function getCommision($userId)
    {   
        $user = Auth::user();
        $isSalesRep = $user->roles->contains('title', 'Sales Rep');

        # if sales rep, use current user ID, otherwise use provided user ID
        $finalUserId = $isSalesRep ? $user->id : $userId;

        $user->id = $finalUserId;

        
        if (!$user) {
            return 0;
        }
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        # get all sold leads of this month
        $quantity = Lead::where('status', 'sold')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('assign_rep', $user->id)
            ->count();

        $solarCommision = Tier::where('category', 'solar')
        ->where('min_value', '<=', $quantity)
        ->where('max_value', '>=', $quantity)
        ->first();

        $batteryCommision = Tier::where('category', 'battery')
        ->where('min_value', '<=', $quantity)
        ->where('max_value', '>=', $quantity)
        ->first();

        return [
                'solarTier'=> @$solarCommision->commission,
                'batteryCommision'=>@$batteryCommision->commission
                ];
    }
}

if (! function_exists('sendGlobalEmail1')) {
    function sendGlobalEmail1($to, $subject, $body, $templateId = null, $category = null, $leadId = null,$type = null,$data=[])
    {
		//try {
            # replace placeholders
            foreach ($data as $key => $value) {
                $body = str_replace('{'.$key.'}', $value, $body);
                $subject = str_replace('{'.$key.'}', $value, $subject);
            }

            # render blade view into HTML
            $htmlBody = view('admin.emails.custom-email', [
                'subject' => $subject,
                'body'    => $body,
            ])->render();

            # send email
            Mail::html($htmlBody, function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });

			 

            return true;
         
    }

    
}