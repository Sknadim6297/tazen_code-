<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagline',
        'status'
    ];

    /**
     * Get the features for the header
     */
    public function features()
    {
        return $this->hasMany(HeaderFeature::class)->orderBy('order');
    }

    /**
     * Get all services for the header through features
     */
    public function getServicesAttribute()
    {
        $services = collect();
        foreach ($this->features as $feature) {
            $services = $services->merge($feature->services);
        }
        return $services->unique('id');
    }
}

