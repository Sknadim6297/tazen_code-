<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = [
            'event_id',
            'event_type',
            'event_details',
            'starting_date',
            'starting_fees',
            'map_link',
            'banner_image',
            'event_gallery',
        ];
        

    protected $casts = [
        'starting_date' => 'date',
        'event_gallery' => 'array', // Automatically casts JSON to array
    ];
    // app/Models/EventDetail.php
    public function event()
    {
    return $this->belongsTo(AllEvent::class, 'event_id');
    }

}
