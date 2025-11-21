<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AllEvent;

class NewProfessionalEvent extends Notification
{
    use Queueable;

    protected $event;
    protected $professionalName;

    /**
     * Create a new notification instance.
     */
    public function __construct(AllEvent $event, $professionalName)
    {
        $this->event = $event;
        $this->professionalName = $professionalName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Event Created by Professional')
                    ->greeting('Hello Admin!')
                    ->line('A new event has been created by ' . $this->professionalName)
                    ->line('Event: ' . $this->event->heading)
                    ->line('Date: ' . date('F d, Y', strtotime($this->event->date)))
                    ->action('View Event Details', route('admin.allevents.show', $this->event->id))
                    ->line('Please review and approve the event.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_professional_event',
            'event_id' => $this->event->id,
            'professional_id' => $this->event->professional_id,
            'professional_name' => $this->professionalName,
            'event_heading' => $this->event->heading,
            'event_date' => $this->event->date,
            'event_time' => $this->event->time,
            'mini_heading' => $this->event->mini_heading,
            'status' => $this->event->status,
            'created_at' => $this->event->created_at,
        ];
    }
}
