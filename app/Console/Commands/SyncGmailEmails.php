<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Google\Service\Gmail;
use Illuminate\Support\Facades\DB;

class SyncGmailEmails extends Command
{
    protected $signature = 'gmail:sync';
    protected $description = 'Sync Gmail emails (read, unread, sent)';

    
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

        $folders = [
            'unread' => [
                'labelIds' => ['INBOX'],
                'q' => 'newer_than:1d is:unread',
            ],
            'read' => [
                'labelIds' => ['INBOX'],
                'q' => 'newer_than:1d is:read',
            ],
            'sent' => [
                'labelIds' => ['SENT'],
                'q' => 'newer_than:1d',
            ],
        ];

        foreach ($folders as $folder => $params) {
            $this->syncFolder($gmail, $user, $folder, $params);
        }
    }

    private function syncFolder(Gmail $gmail, User $user, string $folder, array $params)
    {
        $options = array_merge([
            'maxResults' => 10,
        ], $params);

        $messages = $gmail->users_messages->listUsersMessages('me', $options);

        if (!$messages->getMessages()) {
            return;
        }

        foreach ($messages->getMessages() as $message) {
            $this->storeMessage($gmail, $user, $message->getId(), $folder);
        }
    }

    private function storeMessage(Gmail $gmail, User $user, $messageId, $folder)
    {
        if (DB::table('gmails')->where('message_id', $messageId)->exists()) {
            return;
        }

        $message = $gmail->users_messages->get('me', $messageId, [
            'format' => 'full',
        ]);

        $headers = collect($message->getPayload()->getHeaders())
            ->pluck('value', 'name');

        $rawBody = $this->getMessageBody($message->getPayload());
        $body    = $this->cleanEmailBody($rawBody);

        DB::table('gmails')->insert([
            'user_id'    => $user->id,
            'message_id' => $messageId,
            'thread_id'  => $message->getThreadId(),
            'from'       => $headers['From'] ?? null,
            'to'         => $headers['To'] ?? null,
            'subject'    => $headers['Subject'] ?? null,
            'body'       => $body,
            'folder'     => $folder,
            'created_at' => now(),
        ]);
    }

    /**
     * Extract full email body (HTML preferred, text fallback)
     */
    private function getMessageBody($payload)
    {
        if ($payload->getBody() && $payload->getBody()->getData()) {
            return $this->decodeBody($payload->getBody()->getData());
        }

        if ($payload->getParts()) {
            foreach ($payload->getParts() as $part) {

                if ($part->getMimeType() === 'text/html' && $part->getBody()->getData()) {
                    return $this->decodeBody($part->getBody()->getData());
                }

                if ($part->getMimeType() === 'text/plain' && $part->getBody()->getData()) {
                    return nl2br(e($this->decodeBody($part->getBody()->getData())));
                }

                if ($part->getParts()) {
                    $nested = $this->getMessageBody($part);
                    if ($nested) {
                        return $nested;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Decode Gmail base64url
     */
    private function decodeBody($data)
    {
        $data = str_replace(['-', '_'], ['+', '/'], $data);
        return base64_decode($data);
    }

    /**
     * Clean email HTML and keep only readable content
     */
    private function cleanEmailBody(?string $html)
    {
        if (!$html) {
            return null;
        }

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        $xpath = new \DOMXPath($dom);

        // remove junk
        $remove = [
            '//head',
            '//style',
            '//script',
            '//meta',
            '//link',
            '//img',
            '//footer',
            '//header',
        ];

        foreach ($remove as $query) {
            foreach ($xpath->query($query) as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        // prefer common content containers
        $selectors = [
            '//*[@id="message"]',
            '//*[@class="email-body"]',
            '//*[@class="content"]',
            '//body',
        ];

        foreach ($selectors as $selector) {
            $nodes = $xpath->query($selector);
            if ($nodes->length > 0) {
                return trim($this->innerHTML($nodes->item(0)));
            }
        }

        return trim(strip_tags(
            $dom->saveHTML(),
            '<p><br><b><strong><a><ul><ol><li>'
        ));
    }

    private function innerHTML(\DOMNode $node)
    {
        $html = '';
        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument->saveHTML($child);
        }
        return $html;
    }
}
