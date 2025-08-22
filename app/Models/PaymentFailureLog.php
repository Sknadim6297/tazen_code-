<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentFailureLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_id',
        'booking_type',
        'booking_id',
        'razorpay_payment_id',
        'razorpay_order_id',
        'amount',
        'currency',
        'error_code',
        'error_description',
        'error_source',
        'error_step',
        'error_reason',
        'reference_id',
        'user_details',
        'payment_attempt_count',
        'notifications_sent',
        'admin_notified_at',
        'professional_notified_at',
        'resolved_at',
        'resolution_type',
        'notes'
    ];

    protected $casts = [
        'user_details' => 'array',
        'notifications_sent' => 'boolean',
        'admin_notified_at' => 'datetime',
        'professional_notified_at' => 'datetime',
        'resolved_at' => 'datetime',
        'amount' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeUnresolved($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByBookingType($query, $type)
    {
        return $query->where('booking_type', $type);
    }

    // Helper methods
    public function markAsResolved($resolutionType = 'customer_retry_success', $notes = null)
    {
        $this->update([
            'resolved_at' => now(),
            'resolution_type' => $resolutionType,
            'notes' => $notes
        ]);
    }

    public function incrementAttemptCount()
    {
        $this->increment('payment_attempt_count');
    }

    public function getFormattedAmountAttribute()
    {
        return '₹' . number_format($this->amount / 100, 2);
    }

    public function getErrorSummaryAttribute()
    {
        return $this->error_description ?: $this->error_reason ?: 'Unknown error';
    }

    public function isHighPriority()
    {
        $highPriorityErrors = [
            'GATEWAY_ERROR',
            'SERVER_ERROR',
            'PAYMENT_DECLINED'
        ];

        return in_array($this->error_code, $highPriorityErrors) || 
               $this->payment_attempt_count >= 3 ||
               $this->amount >= 500000; // High value transactions
    }
}
