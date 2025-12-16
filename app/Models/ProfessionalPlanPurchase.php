<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProfessionalPlanPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'plan_id',
        'plan_name',
        'price',
        'features',
        'lead_limit',
        'leads_used',
        'payment_status',
        'payment_id',
        'payment_method',
        'payment_screenshot',
        'start_date',
        'end_date',
        'admin_notes',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'lead_limit' => 'integer',
        'leads_used' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the professional that owns the purchase
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Get the plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get remaining leads
     */
    public function getRemainingLeadsAttribute()
    {
        return max(0, $this->lead_limit - $this->leads_used);
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
        if (strtolower($this->payment_status) !== 'success') {
            return false;
        }

        if ($this->end_date && Carbon::now()->greaterThan($this->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Check if plan is expired
     */
    public function isExpired()
    {
        return $this->end_date && Carbon::now()->greaterThan($this->end_date);
    }

    /**
     * Get active plan for a professional
     */
    public static function getActivePlanForProfessional($professionalId)
    {
        return self::where('professional_id', $professionalId)
            ->whereRaw('LOWER(payment_status) = ?', ['success'])
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>', Carbon::now());
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Increment leads used
     */
    public function incrementLeadsUsed()
    {
        if ($this->remaining_leads > 0) {
            $this->increment('leads_used');
            return true;
        }
        return false;
    }

    /**
     * Scope for successful purchases
     */
    public function scopeSuccessful($query)
    {
        return $query->where('payment_status', 'success');
    }

    /**
     * Scope for pending purchases
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}
