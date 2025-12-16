<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProfessionalPlanPurchase;

class PlanPurchaseNotification extends Notification
{
    use Queueable;

    protected $purchase;

    /**
     * Create a new notification instance.
     */
    public function __construct(ProfessionalPlanPurchase $purchase)
    {
        $this->purchase = $purchase;
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
        $professional = $this->purchase->professional;
        
        return [
            'type' => 'plan_purchase',
            'title' => 'New Plan Purchase',
            'message' => $professional->name . ' purchased ' . $this->purchase->plan_name . ' plan',
            'professional_id' => $this->purchase->professional_id,
            'professional_name' => $professional->name,
            'plan_id' => $this->purchase->plan_id,
            'plan_name' => $this->purchase->plan_name,
            'price' => $this->purchase->price,
            'payment_method' => $this->purchase->payment_method,
            'payment_status' => $this->purchase->payment_status,
            'purchase_id' => $this->purchase->id,
            'requires_approval' => $this->purchase->payment_method === 'manual',
            'url' => route('admin.plans.purchases.show', $this->purchase->id),
        ];
    }
}
