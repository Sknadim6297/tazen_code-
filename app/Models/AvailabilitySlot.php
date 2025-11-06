<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_id',
        'start_time',
        'end_time',
        'weekday',
    ];

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    
}
