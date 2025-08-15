<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailData['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.custom-email',
            with: [
                'data' => $this->emailData,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}