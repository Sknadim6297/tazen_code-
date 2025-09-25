<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTimedate extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'date',
        'time_slot',
        'status',
    ];

    public function timedates()
    {
        return $this->hasMany(BookingTimedate::class);
    }
    // app/Models/BookingTimedate.php

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Normalize time slot format
     */
    public static function normalizeTimeSlot($timeSlot)
    {
        // Convert "06:00 PM to 06:30 PM" to "06:00 PM - 06:30 PM"
        return str_replace(' to ', ' - ', $timeSlot);
    }

    /**
     * Check if a time slot is already booked for a professional
     */
    public static function isSlotBooked($professionalId, $date, $timeSlot)
    {
        $normalizedTimeSlot = self::normalizeTimeSlot($timeSlot);
        
        return self::whereHas('booking', function ($query) use ($professionalId) {
            $query->where('professional_id', $professionalId);
        })
        ->where('date', $date)
        ->where(function($query) use ($timeSlot, $normalizedTimeSlot) {
            $query->where('time_slot', $timeSlot)
                  ->orWhere('time_slot', $normalizedTimeSlot);
        })
        ->where('status', '!=', 'cancelled')
        ->exists();
    }

    /**
     * Get all booked slots for a professional
     */
    public static function getBookedSlots($professionalId)
    {
        return self::whereHas('booking', function ($query) use ($professionalId) {
            $query->where('professional_id', $professionalId);
        })
        ->where('status', '!=', 'cancelled')
        ->get()
        ->groupBy('date')
        ->map(function ($slots) {
            return $slots->pluck('time_slot')->map(function ($timeSlot) {
                // Normalize time slot format for consistency
                return self::normalizeTimeSlot($timeSlot);
            })->toArray();
        })
        ->toArray();
    }
}
