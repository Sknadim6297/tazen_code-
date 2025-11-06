<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdminProfessionalChatMessage;
use App\Models\User;
use App\Models\Professional;

class NewChatMessage extends Notification
{
    use Queueable;

    protected $chatMessage;
    protected $senderName;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdminProfessionalChatMessage $chatMessage, $senderName = null)
    {
        $this->chatMessage = $chatMessage;
        $this->senderName = $senderName;
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
                    ->subject('New Chat Message')
                    ->greeting('Hello!')
                    ->line('You have received a new message from ' . $this->senderName)
                    ->line('Message: ' . ($this->chatMessage->message ?? 'File attachment'))
                    ->action('View Chat', route($this->getRouteForUser($notifiable)))
                    ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_chat_message',
            'chat_id' => $this->chatMessage->chat_id,
            'message_id' => $this->chatMessage->id,
            'sender_name' => $this->senderName ?? 'Unknown',
            'sender_type' => $this->chatMessage->sender_type,
            'sender_id' => $this->chatMessage->sender_id,
            'message_preview' => $this->chatMessage->message ? 
                (strlen($this->chatMessage->message) > 100 ? 
                    substr($this->chatMessage->message, 0, 100) . '...' : 
                    $this->chatMessage->message) : 
                'File attachment',
            'created_at' => $this->chatMessage->created_at,
        ];
    }

    /**
     * Get the appropriate route based on user type
     */
    private function getRouteForUser($notifiable)
    {
        if ($notifiable instanceof User) {
            return 'admin.manage-professional.index'; // Admin goes to manage professional page
        } elseif ($notifiable instanceof Professional) {
            return 'professional.admin-chat.index'; // Professional goes to chat page
        }
        
        return 'dashboard';
    }
}
