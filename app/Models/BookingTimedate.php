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
}
