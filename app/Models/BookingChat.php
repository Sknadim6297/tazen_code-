<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'sender_id',
        'sender_type',
        'message',
        'attachment',
        'is_read',
        'is_system_message'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_system_message' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the booking associated with this chat message
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the sender (either User or Professional)
     */
    public function sender()
    {
        if ($this->sender_type === 'customer') {
            return $this->belongsTo(User::class, 'sender_id');
        } elseif ($this->sender_type === 'professional') {
            return $this->belongsTo(Professional::class, 'sender_id');
        }
        return null;
    }

    /**
     * Scope to get messages for a specific booking
     */
    public function scopeForBooking($query, $bookingId)
    {
        return $query->where('booking_id', $bookingId)->orderBy('created_at', 'asc');
    }

    /**
     * Scope to get unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
