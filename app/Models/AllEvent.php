<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_image',
        'date',
        'mini_heading',
        'heading',
        'short_description',
        'starting_fees',
    ];
    public function eventDetails()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }
    public function bookings()
    {
        return $this->hasMany(EventBooking::class, 'event_id');
    }
}
