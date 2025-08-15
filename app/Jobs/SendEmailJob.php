<?php

namespace App\Jobs;

use App\Mail\CustomEmail;
use App\Models\LeadCommunicationEmail;
use App\Models\EmailStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailQueueId;

    public function __construct($emailQueueId)
    {
        $this->emailQueueId = $emailQueueId;
    }

    public function handle(): void
    {
        try {
            $emailQueue = LeadCommunicationEmail::findOrFail($this->emailQueueId);
            
            // Skip if already sent
            if (strtolower($emailQueue->email_status->title) === 'sent') {
                return;
            }

            // Update status to processing
			$email_status_id = EmailStatus::where('title', 'Processing')->value('id');
            $emailQueue->update(['email_status_id' => $email_status_id]);
			$recipient_name = 'Test';

            // Prepare email data
            $emailData = [
                'subject' => $emailQueue->subject,
                'message' => $emailQueue->message,
                'recipient_name' => $recipient_name,
            ];

            // Send email
            Mail::to($emailQueue->to_email)
                ->send(new CustomEmail($emailData));

            // Update status to sent
			$email_status_id = EmailStatus::where('title', 'Sent')->value('id');
            $emailQueue->update([
                'email_status_id' => $email_status_id,
                'sent_at' => now(),
            ]);

            Log::info('Email sent successfully', ['email_id' => $this->emailQueueId]);

        } catch (\Exception $e) {
            // Update status to failed
			$email_status_id = EmailStatus::where('title', 'Failed')->value('id');
            LeadCommunicationEmail::where('id', $this->emailQueueId)->update([
                'email_status_id' => $email_status_id,
                'error_message' => $e->getMessage(),
            ]);

            Log::error('Email sending failed', [
                'email_id' => $this->emailQueueId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
		$email_status_id = EmailStatus::where('title', 'Failed')->value('id');
        LeadCommunicationEmail::where('id', $this->emailQueueId)->update([
            'email_status_id' => $email_status_id,
            'error_message' => $exception->getMessage(),
        ]);
    }
}