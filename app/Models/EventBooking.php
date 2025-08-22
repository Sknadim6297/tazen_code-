<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'event_name', 'event_date', 'location', 
        'type', 'persons', 'phone', 'price', 'total_price', 'payment_status',
        'order_id', 'razorpay_payment_id', 'razorpay_signature'
    ];
    
    // Cast dates to proper format
    protected $dates = [
        'event_date'
    ];
    
    protected $casts = [
        'event_date' => 'date',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'persons' => 'integer'
    ];
    
    // Allow event_id to be null
    protected $attributes = [
        'event_id' => null
    ];

    /**
     * Get the event associated with the booking.
     */
    public function event()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
