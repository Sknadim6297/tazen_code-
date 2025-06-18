<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event_details';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'name', 'city', 'starting_date', 'starting_fees', 'event_mode'
    ];

    /**
     * Get the AllEvent record that this Event belongs to.
     * This confirms that event_id in event_details table references id in all_events table.
     */
    public function eventDetails()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }
    
    /**
     * Alternative accessor to get the related AllEvent model.
     * This provides a more semantic name for the relationship.
     */
    public function allEvent()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }
    
    /**
     * Get the all_events ID for this event.
     * This is a helper method that's useful for the booking system.
     */
    public function getAllEventIdAttribute()
    {
        return $this->event_id;
    }
}
