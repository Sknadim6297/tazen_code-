<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdditionalService;

class AdditionalServiceNotification extends Notification
{
    use Queueable;

    protected $additionalService;
    protected $type;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdditionalService $additionalService, $type, $message = null)
    {
        $this->additionalService = $additionalService;
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $titles = [
            'new_service' => 'New Additional Service Request',
            'negotiation_started' => 'Price Negotiation Started',
            'negotiation_responded' => 'Negotiation Response',
            'price_modified' => 'Price Modified by Admin',
            'delivery_date_changed' => 'Delivery Date Updated',
            'delivery_date_set' => 'Delivery Date Set',
            'consultation_completed' => 'Consultation Completed',
            'consultation_confirmed' => 'Consultation Confirmed',
            'payment_successful' => 'Payment Successful',
            'payment_released' => 'Payment Released',
            'service_approved' => 'Additional Service Approved',
            'service_rejected' => 'Additional Service Rejected',
        ];

        $messages = [
            'new_service' => "A new additional service '{$this->additionalService->service_name}' has been requested.",
            'negotiation_started' => "Price negotiation started for '{$this->additionalService->service_name}'.",
            'negotiation_responded' => "Admin has responded to your negotiation for '{$this->additionalService->service_name}'.",
            'price_modified' => "Price has been modified for '{$this->additionalService->service_name}'.",
            'delivery_date_changed' => "Delivery date has been updated for '{$this->additionalService->service_name}'.",
            'delivery_date_set' => "Professional has set delivery date for '{$this->additionalService->service_name}'.",
            'consultation_completed' => "Professional has marked consultation as completed for '{$this->additionalService->service_name}'.",
            'consultation_confirmed' => "User has confirmed consultation completion for '{$this->additionalService->service_name}'.",
            'payment_successful' => "Payment successful for '{$this->additionalService->service_name}'.",
            'payment_released' => "Payment has been released for '{$this->additionalService->service_name}'.",
            'service_approved' => "Additional service '{$this->additionalService->service_name}' has been approved.",
            'service_rejected' => "Additional service '{$this->additionalService->service_name}' has been rejected.",
        ];

        return [
            'title' => $titles[$this->type] ?? 'Additional Service Update',
            'message' => $this->message ?? $messages[$this->type] ?? 'An update regarding your additional service.',
            'additional_service_id' => $this->additionalService->id,
            'type' => $this->type,
            'service_name' => $this->additionalService->service_name,
            'professional_name' => $this->additionalService->professional->name,
            'user_name' => $this->additionalService->user->name,
            'amount' => $this->additionalService->final_price,
            'created_at' => now(),
        ];
    }
}