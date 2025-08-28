<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'professional_service_id',
    'sub_service_id',
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
    
    public function professionalService()
    {
        return $this->belongsTo(ProfessionalService::class);
    }

    public function subService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }
    
    public function slots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }
}
