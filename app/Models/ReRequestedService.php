<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professional;
use App\Models\User;
use App\Models\Booking;

class ReRequestedService extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'customer_id',
        'original_booking_id',
        'service_name',
        'reason',
        'original_price',
        'admin_modified_price',
        'final_price',
        'gst_amount',
        'cgst_amount',
        'sgst_amount',
        'cgst_rate',
        'sgst_rate',
        'total_amount',
        'status',
        'priority',
        'payment_status',
        'payment_id',
        'payment_link',
        'requested_at',
        'admin_approved_at',
        'payment_completed_at',
        'customer_viewed_at',
        'professional_notified_at',
        'admin_notes',
        'customer_notes',
        'rejection_reason'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'payment_completed_at' => 'datetime',
        'customer_viewed_at' => 'datetime',
        'professional_notified_at' => 'datetime',
        'original_price' => 'decimal:2',
        'admin_modified_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'cgst_rate' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Relationships
    public function professional()
    {
    return $this->belongsTo(Professional::class, 'professional_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function originalBooking()
    {
        return $this->belongsTo(Booking::class, 'original_booking_id');
    }

    // Helper methods
    public function calculateCGST($amount, $cgstRate = 8)
    {
        return ($amount * $cgstRate) / 100;
    }

    public function calculateSGST($amount, $sgstRate = 8)
    {
        return ($amount * $sgstRate) / 100;
    }

    public function calculateTotalGST($amount, $cgstRate = 8, $sgstRate = 8)
    {
        return $this->calculateCGST($amount, $cgstRate) + $this->calculateSGST($amount, $sgstRate);
    }

    public function calculateTotalWithGST($amount, $cgstRate = 8, $sgstRate = 8)
    {
        $totalGst = $this->calculateTotalGST($amount, $cgstRate, $sgstRate);
        return $amount + $totalGst;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'admin_approved' => '<span class="badge badge-info">Admin Approved</span>',
            'customer_paid' => '<span class="badge badge-success">Customer Paid</span>',
            'rejected' => '<span class="badge badge-danger">Rejected</span>',
            'cancelled' => '<span class="badge badge-secondary">Cancelled</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'unpaid' => '<span class="badge badge-warning">Unpaid</span>',
            'paid' => '<span class="badge badge-success">Paid</span>',
            'failed' => '<span class="badge badge-danger">Failed</span>',
            'refunded' => '<span class="badge badge-info">Refunded</span>'
        ];

        return $badges[$this->payment_status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => '<span class="badge badge-secondary">Low</span>',
            'normal' => '<span class="badge badge-primary">Normal</span>',
            'high' => '<span class="badge badge-warning">High</span>',
            'urgent' => '<span class="badge badge-danger">Urgent</span>'
        ];

        return $badges[$this->priority] ?? '<span class="badge badge-light">Normal</span>';
    }

    // Scope methods for filtering
    public function scopeByStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $paymentStatus ? $query->where('payment_status', $paymentStatus) : $query;
    }

    public function scopeByPriority($query, $priority)
    {
        return $priority ? $query->where('priority', $priority) : $query;
    }

    public function scopeSearchByName($query, $search)
    {
        if (!$search) return $query;
        
        return $query->whereHas('professional', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->orWhereHas('customer', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->orWhere('service_name', 'like', "%{$search}%");
    }
}
