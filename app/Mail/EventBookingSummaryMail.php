<?php

namespace App\Mail;

use App\Models\EventBooking;
use App\Models\AllEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventBookingSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetails;
    public $event;
    public $emailType;

    /**
     * Create a new message instance.
     * 
     * @param array $bookingDetails
     * @param \App\Models\AllEvent $event
     * @param string $emailType
     */
    public function __construct(array $bookingDetails, AllEvent $event = null, $emailType = 'customer')
    {
        $this->bookingDetails = $bookingDetails;
        $this->event = $event;
        $this->emailType = $emailType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->emailType) {
            'admin' => 'New Event Booking Alert - Tazen Admin',
            default => 'Event Booking Confirmation - Tazen'
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event-booking-summary',
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
