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
        'start_period',
        'end_time',
        'end_period',
    ];

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    
}
