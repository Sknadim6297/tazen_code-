<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalEvent extends Model
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
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'starting_fees' => 'decimal:2',
    ];

    /**
     * Get the professional who created this event
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
     * Check if event is pending
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
     * Scope for approved events only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending events only
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
