<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'month',
        'session_duration',
        'weekdays',
    ];

    protected $casts = [
        'weekdays' => 'array',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
    public function slots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }
}
