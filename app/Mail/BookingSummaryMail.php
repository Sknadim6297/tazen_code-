<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $professional;
    public $bookingTimeDates;
    public $emailType;

    /**
     * Create a new message instance.
     * 
     * @param \App\Models\Booking $booking
     * @param \App\Models\Professional $professional
     * @param \Illuminate\Database\Eloquent\Collection $bookingTimeDates
     * @param string $emailType
     */
    public function __construct(Booking $booking, Professional $professional, $bookingTimeDates, $emailType = 'customer')
    {
        $this->booking = $booking;
        $this->professional = $professional;
        $this->bookingTimeDates = $bookingTimeDates;
        $this->emailType = $emailType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->emailType) {
            'professional' => 'New Booking Received - Tazen',
            'admin' => 'New Booking Alert - Tazen Admin',
            default => 'Your Booking Confirmation - Tazen'
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
            view: 'emails.booking-summary',
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
