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
        'status',
        'created_by',
        'razorpay_payment_id',
        'razorpay_order_id',
        'remarks',
        'remarks_for_professional',
        'customer_document',
        'professional_documents'
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
}
