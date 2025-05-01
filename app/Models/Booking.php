<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = ['user_id', 'professional_id', 'plan_type', 'booking_date', 'time_slot',
        'customer_name', 'customer_email', 'customer_phone', 'session_type', 'month', 'days', 'meeting_link'];

    /**
     * Get the customer that owns the booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    /**
     * Get the professional that owns the booking.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}
