<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'session_type',
        'num_sessions',
        'rate_per_session',
        'final_rate',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
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
