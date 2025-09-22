<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ReRequestedService;

class ReRequestedServiceRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $reRequestedService;
    public $recipientType;

    /**
     * Create a new message instance.
     */
    public function __construct(ReRequestedService $reRequestedService, $recipientType = 'customer')
    {
        $this->reRequestedService = $reRequestedService;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re-requested Service Rejected - ' . $this->reRequestedService->service_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->recipientType === 'customer' 
            ? 'emails.re-requested-service-rejected-customer'
            : 'emails.re-requested-service-rejected-professional';

        return new Content(
            view: $view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
