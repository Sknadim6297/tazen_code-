<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentData;
    public $userDetails;
    public $recipientType;

    /**
     * Create a new message instance.
     */
    public function __construct($paymentData, $userDetails, $recipientType = 'admin')
    {
        $this->paymentData = $paymentData;
        $this->userDetails = $userDetails;
        $this->recipientType = $recipientType;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->recipientType === 'professional' 
            ? 'Payment Failed - Customer Booking Alert' 
            : 'Payment Failure Alert - Admin Dashboard';

        return $this->subject($subject)
                    ->view('emails.payment-failure')
                    ->with([
                        'paymentData' => $this->paymentData,
                        'userDetails' => $this->userDetails,
                        'recipientType' => $this->recipientType,
                        'isAppointment' => $this->paymentData['booking_type'] === 'appointment',
                        'isEvent' => $this->paymentData['booking_type'] === 'event'
                    ]);
    }
}
