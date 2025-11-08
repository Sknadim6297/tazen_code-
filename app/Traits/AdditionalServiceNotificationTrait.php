<?php

namespace App\Traits;

use App\Models\AdditionalService;
use App\Models\Admin;
use App\Notifications\AdditionalServiceNotification;

trait AdditionalServiceNotificationTrait
{
    /**
     * Send notification to all relevant parties
     *
     * @param AdditionalService $service
     * @param string $type
     * @param string|null $customMessage
     * @return void
     */
    public function sendAdditionalServiceNotification(AdditionalService $service, string $type, string $customMessage = null)
    {
        $notification = new AdditionalServiceNotification($service, $type, $customMessage);

        // Determine who should receive the notification based on type
        $recipients = $this->getNotificationRecipients($service, $type);

        // Send to each recipient
        foreach ($recipients as $recipient) {
            if ($recipient) {
                $recipient->notify($notification);
            }
        }
    }

    /**
     * Determine notification recipients based on type
     *
     * @param AdditionalService $service
     * @param string $type
     * @return array
     */
    private function getNotificationRecipients(AdditionalService $service, string $type): array
    {
        $admin = Admin::first(); // Get admin (adjust if multiple admins)
        $professional = $service->professional;
        $customer = $service->user;

        $recipients = [];

        switch ($type) {
            case 'new_service':
                // Professional creates service -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'negotiation_started':
                // Customer starts negotiation -> notify Professional & Admin
                $recipients = [$professional, $admin];
                break;

            case 'negotiation_responded':
            case 'negotiation_accepted':
                // Professional responds to negotiation -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'negotiation_rejected':
                // Professional rejects negotiation -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'price_modified':
                // Admin modifies price -> notify Customer & Professional
                $recipients = [$customer, $professional];
                break;

            case 'delivery_date_set':
            case 'delivery_date_changed':
                // Professional sets/changes delivery date -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'consultation_started':
                // Professional starts consultation -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'consultation_completed':
                // Professional completes consultation -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'consultation_confirmed':
                // Customer confirms completion -> notify Professional & Admin
                $recipients = [$professional, $admin];
                break;

            case 'consultation_force_completed':
                // Admin force completes -> notify Customer & Professional
                $recipients = [$customer, $professional];
                break;

            case 'payment_successful':
                // Payment successful -> notify all parties
                $recipients = [$customer, $professional, $admin];
                break;

            case 'payment_failed':
                // Payment failed -> notify Customer & Admin
                $recipients = [$customer, $admin];
                break;

            case 'payment_released':
                // Payment released to professional -> notify Professional & Admin
                $recipients = [$professional, $admin];
                break;

            case 'service_approved':
                // Admin approves service -> notify Customer & Professional
                $recipients = [$customer, $professional];
                break;

            case 'service_rejected':
                // Admin rejects service -> notify Customer & Professional
                $recipients = [$customer, $professional];
                break;

            case 'admin_review_required':
                // System requires admin review -> notify Admin only
                $recipients = [$admin];
                break;

            case 'service_completed':
                // Service fully completed -> notify all parties
                $recipients = [$customer, $professional, $admin];
                break;

            default:
                // Default: notify admin for unknown types
                $recipients = [$admin];
                break;
        }

        // Filter out null recipients
        return array_filter($recipients);
    }

    /**
     * Send notification with activity logging
     *
     * @param AdditionalService $service
     * @param string $type
     * @param string|null $customMessage
     * @param array|null $additionalData
     * @return void
     */
    public function sendNotificationWithLogging(AdditionalService $service, string $type, string $customMessage = null, array $additionalData = [])
    {
        // Send the notification
        $this->sendAdditionalServiceNotification($service, $type, $customMessage);

        // Log the activity (you can extend this to create activity logs table)
        \Log::info("Additional Service Notification Sent", [
            'service_id' => $service->id,
            'service_name' => $service->service_name,
            'type' => $type,
            'customer' => $service->user->name,
            'professional' => $service->professional->name,
            'booking_id' => $service->booking_id,
            'amount' => $service->final_price,
            'negotiation_status' => $service->negotiation_status,
            'payment_status' => $service->payment_status,
            'consulting_status' => $service->consulting_status,
            'additional_data' => $additionalData,
            'triggered_by' => auth()->user()->name ?? 'System',
            'triggered_at' => now(),
        ]);
    }

    /**
     * Send bulk notifications for multiple services
     *
     * @param array $services
     * @param string $type
     * @param string|null $customMessage
     * @return void
     */
    public function sendBulkNotifications(array $services, string $type, string $customMessage = null)
    {
        foreach ($services as $service) {
            $this->sendAdditionalServiceNotification($service, $type, $customMessage);
        }
    }

    /**
     * Send urgent notification (high priority)
     *
     * @param AdditionalService $service
     * @param string $type
     * @param string|null $customMessage
     * @return void
     */
    public function sendUrgentNotification(AdditionalService $service, string $type, string $customMessage = null)
    {
        // Add urgent prefix to message
        $urgentMessage = $customMessage ? "[URGENT] " . $customMessage : null;
        
        $this->sendNotificationWithLogging($service, $type, $urgentMessage, [
            'priority' => 'urgent',
            'requires_immediate_attention' => true
        ]);
    }
}