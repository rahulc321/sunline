<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Google\Service\Gmail;

class SyncGmailEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::where('is_email_connected', true)
            ->where('email_provider', 'gmail')
            ->chunk(50, function ($users) {
                foreach ($users as $user) {
                    $this->syncUserEmails($user);
                }
            });
    }

    private function syncUserEmails(User $user)
    {
        $client = app()->call(
            [app(\App\Http\Controllers\Admin\GmailController::class), 'googleClient'],
            ['user' => $user]
        );

        $gmail = new Gmail($client);

        // INBOX + SENT
        $labels = ['INBOX', 'SENT'];

        foreach ($labels as $label) {
            $messages = $gmail->users_messages->listUsersMessages('me', [
                'labelIds' => [$label],
                'maxResults' => 20,
            ]);

            if (!$messages->getMessages()) {
                continue;
            }

            foreach ($messages->getMessages() as $message) {
                $this->storeMessage($gmail, $user, $message->getId(), $label);
            }
        }
    }

    private function storeMessage(Gmail $gmail, User $user, $messageId, $label)
    {
        // prevent duplicates
        if (\DB::table('gmails')->where('message_id', $messageId)->exists()) {
            return;
        }

        $message = $gmail->users_messages->get('me', $messageId, [
            'format' => 'full'
        ]);



        $rawBody = $message->getPayload()->getBody()->getData();

        $rawBody = str_replace(['-', '_'], ['+', '/'], $rawBody);

        // fix missing padding
        $padding = strlen($rawBody) % 4;
        if ($padding) {
            $rawBody .= str_repeat('=', 4 - $padding);
        }

        $body = base64_decode($rawBody);

        //echo '<pre>';print_r($body);die;

        $headers = collect($message->getPayload()->getHeaders())
            ->pluck('value', 'name');

        \DB::table('gmails')->insert([
            'user_id'    => $user->id,
            'message_id' => $messageId,
            'thread_id'  => $message->getThreadId(),
            'from'       => $headers['From'] ?? null,
            'to'         => $headers['To'] ?? null,
            'subject'    => $headers['Subject'] ?? null,
            'body'       => $body,
            'folder'     => strtolower($label),
            'created_at' => now(),
        ]);
    }
}