<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfessionalChatMessage extends Model
{
    use HasFactory;

    protected $table = 'admin_professional_chat_messages';

    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'message',
        'is_read',
        'read_at',
        'metadata'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected $appends = ['sender_name'];

    /**
     * Get the chat that owns this message
     */
    public function chat()
    {
        return $this->belongsTo(AdminProfessionalChat::class, 'chat_id');
    }

    /**
     * Get the sender of this message (polymorphic)
     */
    public function sender()
    {
        return $this->morphTo();
    }

    /**
     * Get all attachments for this message
     */
    public function attachments()
    {
        return $this->hasMany(AdminProfessionalChatAttachment::class, 'message_id');
    }

    /**
     * Check if message has attachments
     */
    public function hasAttachments()
    {
        return $this->attachments()->exists();
    }

    /**
     * Get sender name
     */
    public function getSenderNameAttribute()
    {
        if ($this->sender_type === Admin::class) {
            if ($this->relationLoaded('sender') && $this->sender) {
                return $this->sender->name ?? 'Admin';
            }
            // Fallback: try to load admin directly
            $admin = \App\Models\Admin::find($this->sender_id);
            return $admin ? $admin->name : 'Admin';
        } elseif ($this->sender_type === Professional::class) {
            if ($this->relationLoaded('sender') && $this->sender) {
                return $this->sender->name ?? 'Professional';
            }
            // Fallback: try to load professional directly
            $professional = \App\Models\Professional::find($this->sender_id);
            return $professional ? $professional->name : 'Professional';
        }
        return 'Unknown';
    }

    /**
     * Check if message was sent by admin
     */
    public function isSentByAdmin()
    {
        return $this->sender_type === Admin::class;
    }

    /**
     * Check if message was sent by professional
     */
    public function isSentByProfessional()
    {
        return $this->sender_type === Professional::class;
    }
}
