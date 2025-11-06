<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllEvent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'professional_id',
        'card_image',
        'date',
        'mini_heading',
        'heading',
        'short_description',
        'starting_fees',
        'status',
        'admin_notes',
        'meet_link',
        'show_on_homepage',
        'approved_by',
        'approved_at',
        'created_by_type',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'starting_fees' => 'decimal:2',
        'show_on_homepage' => 'boolean',
    ];

    /**
     * Get the professional who created this event (if applicable)
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Get the admin who approved this event
     */
    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * Check if event is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if event is pending approval
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if event is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if event was created by admin
     */
    public function isAdminEvent()
    {
        return $this->created_by_type === 'admin';
    }

    /**
     * Check if event was created by professional
     */
    public function isProfessionalEvent()
    {
        return $this->created_by_type === 'professional';
    }

    public function eventDetails()
    {
        return $this->hasMany(Event::class, 'event_id');
    }
    
    public function bookings()
    {
        return $this->hasMany(EventBooking::class, 'event_id');
    }
}
