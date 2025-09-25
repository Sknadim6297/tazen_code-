<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailureNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $paymentData;
    private $userType;
    private $userDetails;

    public function __construct($paymentData, $userType = 'admin', $userDetails = null)
    {
        $this->paymentData = $paymentData;
        $this->userType = $userType;
        $this->userDetails = $userDetails;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->userType === 'professional' 
            ? 'Payment Failed - Customer Booking Alert'
            : 'Payment Failure Alert - Immediate Attention Required';

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting($this->getGreeting())
            ->line($this->getMainMessage())
            ->line('')
            ->line('**Payment Details:**')
            ->line('• Amount: ₹' . number_format($this->paymentData['amount'] / 100, 2))
            ->line('• Error: ' . ($this->paymentData['error_description'] ?? 'Unknown error'))
            ->line('• Reference ID: ' . ($this->paymentData['reference_id'] ?? 'N/A'))
            ->line('• Time: ' . now()->format('d M Y, h:i A'))
            ->line('')
            ->line('**Customer Details:**')
            ->line('• Name: ' . ($this->userDetails['name'] ?? 'N/A'))
            ->line('• Email: ' . ($this->userDetails['email'] ?? 'N/A'))
            ->line('• Phone: ' . ($this->paymentData['phone'] ?? 'N/A'));

        if ($this->userType === 'professional') {
            $mailMessage->line('')
                ->line('**Next Steps for Professional:**')
                ->line('• Contact the customer to provide alternative payment options')
                ->line('• Offer manual booking assistance if needed')
                ->line('• Keep this booking slot reserved for 24 hours')
                ->action('View Customer Details', url('/professional/dashboard'))
                ->line('Please reach out to the customer promptly to ensure a positive experience.');
        } else {
            $mailMessage->line('')
                ->line('**Immediate Actions Required:**')
                ->line('• Review the payment failure reason')
                ->line('• Contact the customer if needed')
                ->line('• Monitor for retry attempts')
                ->action('View Admin Dashboard', url('/admin/dashboard'))
                ->line('This requires immediate attention to maintain customer satisfaction.');
        }

        return $mailMessage->line('')
            ->line('Thank you for maintaining excellent service quality!');
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'payment_failure',
            'user_type' => $this->userType,
            'title' => $this->getNotificationTitle(),
            'message' => $this->getNotificationMessage(),
            'payment_data' => $this->paymentData,
            'user_details' => $this->userDetails,
            'urgency' => 'high',
            'reference_id' => $this->paymentData['reference_id'] ?? null,
            'amount' => $this->paymentData['amount'] ?? 0,
            'created_at' => now(),
        ];
    }

    private function getGreeting()
    {
        if ($this->userType === 'professional') {
            return 'Dear Professional,';
        }
        return 'Dear Admin Team,';
    }

    private function getMainMessage()
    {
        if ($this->userType === 'professional') {
            return 'A customer attempted to book an appointment with you, but the payment failed. Your immediate attention is needed to assist the customer and secure this booking.';
        }
        
        return 'A payment failure has occurred in the booking system. This requires immediate review to ensure customer satisfaction and system reliability.';
    }

    private function getNotificationTitle()
    {
        if ($this->userType === 'professional') {
            return 'Customer Payment Failed - Action Required';
        }
        return 'Payment Failure Alert - Admin Review Needed';
    }

    private function getNotificationMessage()
    {
        $amount = number_format(($this->paymentData['amount'] ?? 0) / 100, 2);
        $customerName = $this->userDetails['name'] ?? 'Unknown Customer';
        
        if ($this->userType === 'professional') {
            return "Payment of ₹{$amount} failed for {$customerName}'s booking. Please contact the customer to provide assistance and alternative payment options.";
        }
        
        return "Payment failure detected: ₹{$amount} for customer {$customerName}. Error: " . ($this->paymentData['error_description'] ?? 'Unknown error') . ". Immediate review required.";
    }
}
