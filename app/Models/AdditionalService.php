<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'user_id',
        'booking_id',
        'service_name',
        'reason',
        'base_price',
        'cgst',
        'sgst',
        'igst',
        'total_price',
        'professional_percentage_amount',
        'professional_final_amount',
        'platform_commission',
        'earnings_calculated_at',
        'professional_status',
        'admin_status',
        'user_status',
        'consulting_status',
        'admin_reason',
        'modified_base_price',
        'modified_total_price',
        'user_negotiated_price',
        'user_negotiation_reason',
        'negotiation_status',
        'price_modified_by_admin',
        'price_modification_reason',
        'price_history',
        'admin_negotiation_response',
        'admin_final_negotiated_price',
        'admin_reviewed_at',
        'user_responded_at',
        'professional_completed_at',
        'customer_confirmed_at',
        'delivery_date',
        'delivery_date_set',
        'delivery_date_set_by_professional_at',
        'delivery_date_modified_by_admin_at',
        'delivery_date_reason',
        'can_complete_consultation',
        'professional_payment_status',
        'professional_payment_processed_at',
        'payment_id',
        'payment_status',
        'user_completion_date',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'cgst' => 'decimal:2',
        'sgst' => 'decimal:2',
        'igst' => 'decimal:2',
        'total_price' => 'decimal:2',
        'professional_percentage_amount' => 'decimal:2',
        'professional_final_amount' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'modified_base_price' => 'decimal:2',
        'modified_total_price' => 'decimal:2',
        'user_negotiated_price' => 'decimal:2',
        'admin_final_negotiated_price' => 'decimal:2',
        'price_modified_by_admin' => 'boolean',
        'delivery_date_set' => 'boolean',
        'can_complete_consultation' => 'boolean',
        'earnings_calculated_at' => 'datetime',
        'admin_reviewed_at' => 'datetime',
        'user_responded_at' => 'datetime',
        'professional_completed_at' => 'datetime',
        'customer_confirmed_at' => 'datetime',
        'delivery_date' => 'datetime',
        'delivery_date_set_by_professional_at' => 'datetime',
        'delivery_date_modified_by_admin_at' => 'datetime',
        'professional_payment_processed_at' => 'datetime',
        'user_completion_date' => 'datetime',
    ];

    // Relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Accessors & Mutators
    public function setBasePriceAttribute($value)
    {
        $this->attributes['base_price'] = $value;
        $this->calculateGST();
    }

    // Calculate GST automatically
    public function calculateGST()
    {
        if (isset($this->attributes['base_price'])) {
            $basePrice = (float) $this->attributes['base_price'];
            
            // GST calculation (18% total = 9% CGST + 9% SGST)
            $this->attributes['cgst'] = round($basePrice * 0.09, 2);
            $this->attributes['sgst'] = round($basePrice * 0.09, 2);
            $this->attributes['igst'] = 0.00; // Typically for inter-state transactions
            
            // Calculate total price
            $this->attributes['total_price'] = round($basePrice + $this->attributes['cgst'] + $this->attributes['sgst'], 2);
        }
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('professional_status', 'pending')
                    ->where('admin_status', 'pending')
                    ->where('user_status', 'pending');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForProfessional($query, $professionalId)
    {
        return $query->where('professional_id', $professionalId);
    }

    public function scopeWithNegotiation($query)
    {
        return $query->where('negotiation_status', '!=', 'none');
    }

    // Helper methods
    public function canBeNegotiated()
    {
        return $this->negotiation_status === 'none' && 
               $this->user_status === 'pending' &&
               $this->admin_status === 'pending';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isConsultationCompleted()
    {
        return $this->consulting_status === 'done' && 
               !is_null($this->customer_confirmed_at);
    }

    public function canBeCompletedByProfessional()
    {
        return $this->consulting_status === 'in_progress' && 
               $this->payment_status === 'paid';
    }

    /**
     * Whether the professional can start the consultation.
     * Typically allowed when the consultation hasn't started and payment is received
     */
    public function canStartConsultation()
    {
        return $this->consulting_status === 'pending' && $this->payment_status === 'paid' && $this->admin_status === 'approved';
    }

    /**
     * Whether the professional can mark the consultation as completed.
     * Wraps existing business logic for clarity in views.
     */
    public function canMarkAsCompleted()
    {
        return $this->canBeCompletedByProfessional();
    }

    /**
     * Whether the delivery date can be updated by the professional/admin.
     * Default rule: admin has approved the service and consultation is not completed yet.
     */
    public function canUpdateDeliveryDate()
    {
        return $this->admin_status === 'approved' && $this->consulting_status !== 'done';
    }

    public function getFinalPriceAttribute()
    {
        // Only use admin-approved prices
        if ($this->negotiation_status === 'admin_responded' && $this->admin_final_negotiated_price) {
            return $this->admin_final_negotiated_price;
        }
        
        if ($this->price_modified_by_admin && $this->modified_total_price) {
            return $this->modified_total_price;
        }
        
        // Don't use user negotiated price until admin responds
        return $this->total_price;
    }

    /**
     * Calculate professional earnings based on service request margin
     */
    public function calculateProfessionalEarnings()
    {
        $finalPrice = $this->final_price;
        $serviceRequestMargin = $this->professional->service_request_margin ?? 0;
        
        // Calculate platform commission based on service request margin
        $platformCommission = ($finalPrice * $serviceRequestMargin) / 100;
        
        // Professional final amount after deducting platform commission
        $professionalFinalAmount = $finalPrice - $platformCommission;
        
        return [
            'final_price' => $finalPrice,
            'platform_commission' => round($platformCommission, 2),
            'professional_final_amount' => round($professionalFinalAmount, 2),
            'service_request_margin' => $serviceRequestMargin
        ];
    }

    /**
     * Check if customer can negotiate below the offset limit
     */
    public function canNegotiateTo($proposedPrice)
    {
        $serviceRequestOffset = $this->professional->service_request_offset ?? 0;
        $minimumAllowedPrice = $this->base_price - (($this->base_price * $serviceRequestOffset) / 100);
        
        return $proposedPrice >= $minimumAllowedPrice;
    }

    /**
     * Get minimum negotiable price based on offset
     */
    public function getMinimumNegotiablePriceAttribute()
    {
        $serviceRequestOffset = $this->professional->service_request_offset ?? 0;
        return $this->base_price - (($this->base_price * $serviceRequestOffset) / 100);
    }

    /**
     * Check if professional can set delivery date
     */
    public function canSetDeliveryDate()
    {
        return $this->payment_status === 'paid' && 
               !$this->delivery_date_set_by_professional_at;
    }

    /**
     * Check if consultation can be completed (after delivery date)
     */
    public function canCompleteConsultation()
    {
        if (!$this->delivery_date || $this->consulting_status === 'done') {
            return false;
        }

        return $this->payment_status === 'paid' && 
               $this->delivery_date <= now();
    }

    /**
     * Update consultation completion eligibility
     */
    public function updateConsultationEligibility()
    {
        $this->update([
            'can_complete_consultation' => $this->canCompleteConsultation()
        ]);
    }

    public function getStatusTextAttribute()
    {
        if ($this->user_status === 'paid' && $this->consulting_status === 'done' && $this->customer_confirmed_at) {
            return 'Completed';
        }
        
        if ($this->user_status === 'paid' && $this->consulting_status === 'in_progress') {
            return 'In Progress';
        }
        
        if ($this->negotiation_status === 'user_negotiated') {
            return 'Under Negotiation';
        }
        
        if ($this->user_status === 'pending') {
            return 'Awaiting Payment';
        }
        
        return 'Pending';
    }
}