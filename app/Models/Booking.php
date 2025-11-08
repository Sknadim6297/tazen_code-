<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'professional_id',
        'service_id',
        'sub_service_id',
        'plan_type',
        'customer_phone',
        'service_name',
        'sub_service_name',
        'session_type',
        'customer_name',
        'customer_email',
        'month',
        'booking_date',
        'booking_time',
        'days',
        'time_slot',
        'amount',
        'base_amount',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'payment_id',
        'payment_status',
        'paid_status', // Add paid_status field
        'transaction_id', // Payment transaction ID
        'payment_method', // Payment method (bank transfer, UPI, etc.)
        'payment_screenshot', // Payment screenshot path
        'payment_notes', // Additional payment notes
        'status',
        'created_by',
        'razorpay_payment_id',
        'razorpay_order_id',
        'remarks',
        'remarks_for_professional',
        'customer_document',
        'professional_documents',
        // Reschedule fields
        'reschedule_count',
        'original_date',
        'original_time_slot',
        'reschedule_reason',
        'reschedule_requested_at',
        'reschedule_approved_at',
        'max_reschedules_allowed'
    ];

    /**
     * Get the customer that owns the booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the professional that owns the booking.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    public function timedates()
    {
        return $this->hasMany(BookingTimedate::class, 'booking_id');
    }
    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class, 'user_id');
    }
    
    /**
     * Get the questionnaire answers associated with this booking
     */
    public function mcqAnswers()
    {
        return $this->hasMany(McqAnswer::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the service for this booking
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
    /**
     * Get the sub-service for this booking
     */
    public function subService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }
    public function additionalServices()
    {
        return $this->hasMany(AdditionalService::class);
    }
    
    /**
     * Check if this booking can be rescheduled
     */
    public function canBeRescheduled()
    {
        return $this->reschedule_count < $this->max_reschedules_allowed;
    }
    
    /**
     * Get remaining reschedule attempts
     */
    public function getRemainingReschedules()
    {
        return max(0, $this->max_reschedules_allowed - $this->reschedule_count);
    }
    
    /**
     * Check if booking has been rescheduled
     */
    public function hasBeenRescheduled()
    {
        return $this->reschedule_count > 0;
    }
    
    /**
     * Get reschedule history summary
     */
    public function getRescheduleHistory()
    {
        return [
            'count' => $this->reschedule_count,
            'remaining' => $this->getRemainingReschedules(),
            'original_date' => $this->original_date,
            'original_time_slot' => $this->original_time_slot,
            'last_reason' => $this->reschedule_reason,
            'last_rescheduled_at' => $this->reschedule_approved_at
        ];
    }
}
