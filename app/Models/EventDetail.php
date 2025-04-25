<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'banner_image',
        'event_name',
        'event_type',
        'event_details',
        'starting_date',
        'starting_fees',
        'event_gallery',
    ];

    protected $casts = [
        'starting_date' => 'date',
        'event_gallery' => 'array', // Automatically casts JSON to array
    ];
}
