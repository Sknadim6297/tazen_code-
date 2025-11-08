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
            'negotiation_responded' => 'Negotiation Response Received',
            'negotiation_accepted' => 'Negotiation Accepted',
            'negotiation_rejected' => 'Negotiation Rejected',
            'price_modified' => 'Price Modified by Admin',
            'delivery_date_changed' => 'Delivery Date Updated',
            'delivery_date_set' => 'Delivery Date Set',
            'consultation_started' => 'Consultation Started',
            'consultation_completed' => 'Consultation Completed',
            'consultation_force_completed' => 'Consultation Force Completed by Admin',
            'consultation_confirmed' => 'Consultation Confirmed by Customer',
            'payment_successful' => 'Payment Successful',
            'payment_failed' => 'Payment Failed',
            'payment_released' => 'Payment Released',
            'service_approved' => 'Additional Service Approved',
            'service_rejected' => 'Additional Service Rejected',
            'admin_review_required' => 'Admin Review Required',
            'service_completed' => 'Service Completed Successfully',
        ];

        $messages = [
            'new_service' => "A new additional service '{$this->additionalService->service_name}' has been requested by {$this->additionalService->user->name}.",
            'negotiation_started' => "Customer {$this->additionalService->user->name} started price negotiation for '{$this->additionalService->service_name}' - Offered: ₹{$this->formatAmount($this->additionalService->user_negotiated_price)}",
            'negotiation_responded' => "Professional {$this->additionalService->professional->name} has responded to your negotiation for '{$this->additionalService->service_name}' - Final Price: ₹{$this->formatAmount($this->additionalService->admin_final_negotiated_price)}",
            'negotiation_accepted' => "Your negotiated price of ₹{$this->formatAmount($this->additionalService->admin_final_negotiated_price)} has been accepted for '{$this->additionalService->service_name}'.",
            'negotiation_rejected' => "Your negotiation for '{$this->additionalService->service_name}' has been rejected. Original price stands.",
            'price_modified' => "Admin has modified the price for '{$this->additionalService->service_name}' to ₹{$this->formatAmount($this->additionalService->final_price)}.",
            'delivery_date_changed' => "Delivery date has been updated to {$this->formatDate($this->additionalService->delivery_date)} for '{$this->additionalService->service_name}'.",
            'delivery_date_set' => "Professional has set delivery date to {$this->formatDate($this->additionalService->delivery_date)} for '{$this->additionalService->service_name}'.",
            'consultation_started' => "Professional {$this->additionalService->professional->name} has started consultation for '{$this->additionalService->service_name}'.",
            'consultation_completed' => "Professional has marked consultation as completed for '{$this->additionalService->service_name}'. Please confirm completion.",
            'consultation_force_completed' => "Admin has marked consultation as completed for '{$this->additionalService->service_name}' (administrative override).",
            'consultation_confirmed' => "Customer {$this->additionalService->user->name} has confirmed consultation completion for '{$this->additionalService->service_name}'.",
            'payment_successful' => "Payment of ₹{$this->formatAmount($this->additionalService->final_price)} successful for '{$this->additionalService->service_name}'.",
            'payment_failed' => "Payment failed for '{$this->additionalService->service_name}'. Please try again.",
            'payment_released' => "Payment of ₹{$this->formatAmount($this->additionalService->final_price)} has been released for '{$this->additionalService->service_name}'.",
            'service_approved' => "Additional service '{$this->additionalService->service_name}' has been approved by admin.",
            'service_rejected' => "Additional service '{$this->additionalService->service_name}' has been rejected by admin.",
            'admin_review_required' => "Additional service '{$this->additionalService->service_name}' requires admin review and approval.",
            'service_completed' => "Service '{$this->additionalService->service_name}' has been completed successfully. Total amount: ₹{$this->formatAmount($this->additionalService->final_price)}",
        ];

        // Determine notification priority
        $priority = $this->getNotificationPriority($this->type);

        // Get appropriate icon and color for the notification type
        $iconInfo = $this->getNotificationIcon($this->type);

        return [
            'title' => $titles[$this->type] ?? 'Additional Service Update',
            'message' => $this->message ?? $messages[$this->type] ?? 'An update regarding your additional service.',
            'additional_service_id' => $this->additionalService->id,
            'type' => $this->type,
            'priority' => $priority,
            'icon' => $iconInfo['icon'],
            'color' => $iconInfo['color'],
            'service_name' => $this->additionalService->service_name,
            'professional_name' => $this->additionalService->professional->name,
            'user_name' => $this->additionalService->user->name,
            'booking_id' => $this->additionalService->booking_id,
            'amount' => $this->additionalService->final_price,
            'original_amount' => $this->additionalService->original_professional_price,
            'negotiated_amount' => $this->additionalService->user_negotiated_price,
            'final_negotiated_amount' => $this->additionalService->admin_final_negotiated_price,
            'payment_status' => $this->additionalService->payment_status,
            'consulting_status' => $this->additionalService->consulting_status,
            'negotiation_status' => $this->additionalService->negotiation_status,
            'delivery_date' => $this->additionalService->delivery_date,
            'created_at' => now(),
            'expires_at' => now()->addDays(30), // Notifications expire after 30 days
        ];
    }

    /**
     * Format amount for display
     */
    private function formatAmount($amount)
    {
        if (!$amount) return '0.00';
        return number_format($amount, 2);
    }

    /**
     * Format date for display
     */
    private function formatDate($date)
    {
        if (!$date) return 'Not set';
        return \Carbon\Carbon::parse($date)->format('M d, Y');
    }

    /**
     * Get notification priority based on type
     */
    private function getNotificationPriority($type)
    {
        $highPriority = ['payment_failed', 'service_rejected', 'admin_review_required'];
        $mediumPriority = ['new_service', 'negotiation_started', 'consultation_completed', 'payment_successful'];
        
        if (in_array($type, $highPriority)) {
            return 'high';
        } elseif (in_array($type, $mediumPriority)) {
            return 'medium';
        }
        
        return 'low';
    }

    /**
     * Get appropriate icon and color for notification type
     */
    private function getNotificationIcon($type)
    {
        $iconMap = [
            'new_service' => ['icon' => 'fas fa-plus-circle', 'color' => '#3b82f6'],
            'negotiation_started' => ['icon' => 'fas fa-handshake', 'color' => '#f59e0b'],
            'negotiation_responded' => ['icon' => 'fas fa-reply', 'color' => '#10b981'],
            'negotiation_accepted' => ['icon' => 'fas fa-check-circle', 'color' => '#10b981'],
            'negotiation_rejected' => ['icon' => 'fas fa-times-circle', 'color' => '#ef4444'],
            'price_modified' => ['icon' => 'fas fa-edit', 'color' => '#8b5cf6'],
            'delivery_date_set' => ['icon' => 'fas fa-calendar-check', 'color' => '#06b6d4'],
            'consultation_started' => ['icon' => 'fas fa-comments', 'color' => '#3b82f6'],
            'consultation_completed' => ['icon' => 'fas fa-check-double', 'color' => '#10b981'],
            'consultation_confirmed' => ['icon' => 'fas fa-thumbs-up', 'color' => '#10b981'],
            'payment_successful' => ['icon' => 'fas fa-credit-card', 'color' => '#10b981'],
            'payment_failed' => ['icon' => 'fas fa-exclamation-triangle', 'color' => '#ef4444'],
            'service_approved' => ['icon' => 'fas fa-check-circle', 'color' => '#10b981'],
            'service_rejected' => ['icon' => 'fas fa-ban', 'color' => '#ef4444'],
            'admin_review_required' => ['icon' => 'fas fa-eye', 'color' => '#f59e0b'],
            'service_completed' => ['icon' => 'fas fa-trophy', 'color' => '#10b981'],
        ];

        return $iconMap[$type] ?? ['icon' => 'fas fa-info-circle', 'color' => '#6b7280'];
    }
}