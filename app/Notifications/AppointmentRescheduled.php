<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\User;

class AppointmentRescheduled extends Notification
{
    use Queueable;

    protected $booking;
    protected $timedate;
    protected $customer;
    protected $oldDate;
    protected $oldTime;
    protected $newDate;
    protected $newTime;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, BookingTimedate $timedate, User $customer, $oldDate, $oldTime, $newDate, $newTime)
    {
        $this->booking = $booking;
        $this->timedate = $timedate;
        $this->customer = $customer;
        $this->oldDate = $oldDate;
        $this->oldTime = $oldTime;
        $this->newDate = $newDate;
        $this->newTime = $newTime;
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
                    ->line('An appointment has been rescheduled.')
                    ->action('View Details', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'appointment_rescheduled',
            'title' => 'Appointment Rescheduled',
            'message' => sprintf(
                '%s has rescheduled their appointment for %s from %s to %s at %s',
                $this->customer->name,
                $this->booking->service_name,
                \Carbon\Carbon::parse($this->oldDate)->format('M d, Y'),
                \Carbon\Carbon::parse($this->newDate)->format('M d, Y'),
                $this->newTime
            ),
            'booking_id' => $this->booking->id,
            'timedate_id' => $this->timedate->id,
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'service_name' => $this->booking->service_name,
            'old_date' => $this->oldDate,
            'old_time' => $this->oldTime,
            'new_date' => $this->newDate,
            'new_time' => $this->newTime,
            'professional_id' => $this->booking->professional_id,
            'url' => '/professional/booking',
            'created_at' => now(),
        ];
    }

    /**
     * Get the notification data for database storage.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
