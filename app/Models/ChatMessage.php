<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'message',
        'message_type',
        'file_path',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the chat this message belongs to
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get the sender of this message
     */
    public function sender()
    {
        return $this->morphTo('sender', 'sender_type', 'sender_id');
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for messages by sender
     */
    public function scopeBySender($query, $senderType, $senderId)
    {
        return $query->where('sender_type', $senderType)
                     ->where('sender_id', $senderId);
    }
}
