<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventBookingNotification extends Notification
{
    use Queueable;

    protected $eventBooking;
    protected $event;
    protected $customer;

    /**
     * Create a new notification instance.
     */
    public function __construct($eventBooking, $event = null, $customer = null)
    {
        $this->eventBooking = $eventBooking;
        $this->event = $event;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('A new event booking has been received.')
                    ->action('View Booking', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $customerName = $this->customer ? $this->customer->name : 
                       ($this->eventBooking->user ? $this->eventBooking->user->name : 'Customer');
        
        $eventName = $this->event ? $this->event->heading : 
                    ($this->eventBooking->event_name ?? 'Event');

        return [
            'booking_id' => $this->eventBooking->id,
            'event_id' => $this->eventBooking->event_id,
            'customer_id' => $this->eventBooking->user_id,
            'customer_name' => $customerName,
            'event_name' => $eventName,
            'event_date' => $this->eventBooking->event_date,
            'total_amount' => $this->eventBooking->total_price,
            'payment_status' => $this->eventBooking->payment_status,
            'persons' => $this->eventBooking->persons,
            'location' => $this->eventBooking->location,
            'phone' => $this->eventBooking->phone,
            'type' => 'event_booking',
            'message' => "New event booking from {$customerName} for {$eventName}",
            'booking_date' => $this->eventBooking->created_at->format('Y-m-d H:i:s')
        ];
    }
}