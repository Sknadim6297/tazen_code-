<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'professional_service_id',
        'session_type',
        'num_sessions',
        'rate_per_session',
        'final_rate',
        'sub_service_id',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
    
    public function professionalService()
    {
        return $this->belongsTo(ProfessionalService::class);
    }

    public function subService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    /**
     * Get features or return default ones if empty
     */
    public function getFeaturesListAttribute()
    {
        $features = $this->features ?? [];
        
        // Remove empty values
        $features = array_filter($features);
        
        // If no features, return default based on session type
        if (empty($features)) {
            return ['Curated solutions for you'];
        }
        
        return $features;
    }
}