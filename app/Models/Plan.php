<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'lead_limit',
        'features',
        'validity_days',
        'status',
        'description',
        'order',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'lead_limit' => 'integer',
        'validity_days' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get all purchases for this plan
     */
    public function purchases()
    {
        return $this->hasMany(ProfessionalPlanPurchase::class);
    }

    /**
     * Scope to get only active plans
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('order');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    /**
     * Check if plan is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
