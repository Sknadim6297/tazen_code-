<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfessionalChat extends Model
{
    use HasFactory;

    protected $table = 'admin_professional_chats';

    protected $fillable = [
        'admin_id',
        'professional_id', 
        'customer_id',
        'chat_type',
        'last_message_at',
        'last_message_by',
        'is_active'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin that owns this chat
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the professional that owns this chat
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    /**
     * Get the customer that owns this chat
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get all messages for this chat
     */
    public function messages()
    {
        return $this->hasMany(AdminProfessionalChatMessage::class, 'chat_id')->orderBy('created_at');
    }

    /**
     * Get the latest message for this chat
     */
    public function latestMessage()
    {
        return $this->hasOne(AdminProfessionalChatMessage::class, 'chat_id')->latest();
    }

    /**
     * Get unread messages count for a specific user
     */
    public function getUnreadCountForUser($userType, $userId)
    {
        return $this->messages()
            ->where('is_read', false)
            ->where(function($query) use ($userType, $userId) {
                // Count messages NOT sent by this user (i.e., messages they need to read)
                if ($userType === 'admin') {
                    $query->where('sender_type', '!=', Admin::class);
                } elseif ($userType === 'professional') {
                    $query->where('sender_type', '!=', Professional::class);
                } else { // customer
                    $query->where('sender_type', '!=', User::class);
                }
            })
            ->count();
    }

    /**
     * Mark all messages as read for a specific user
     */
    public function markAsReadForUser($userType, $userId)
    {
        return $this->messages()
            ->where('is_read', false)
            ->where(function($query) use ($userType, $userId) {
                // Mark messages NOT sent by this user as read
                if ($userType === 'admin') {
                    $query->where('sender_type', '!=', Admin::class);
                } elseif ($userType === 'professional') {
                    $query->where('sender_type', '!=', Professional::class);
                } else { // customer
                    $query->where('sender_type', '!=', User::class);
                }
            })
            ->update(['is_read' => true, 'read_at' => now()]);
    }
}
