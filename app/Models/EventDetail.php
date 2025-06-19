<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'banner_image',
        'event_type',
        'event_details',
        'starting_date',
        'starting_fees',
        'event_gallery',
        'city',
        'event_mode'
    ];

    protected $casts = [
        'starting_date' => 'date',
        'starting_fees' => 'decimal:2',
        'event_gallery' => 'array',
        'banner_image' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }
}
