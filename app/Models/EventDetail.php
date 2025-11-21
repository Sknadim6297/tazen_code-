<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'creator_type',
        'creator_id',
        'banner_image',
        'event_type',
        'event_details',
        'starting_date',
        'time',
        'starting_fees',
        'event_gallery',
        'city',
        'event_mode'
    ];

    protected $casts = [
        'starting_date' => 'date',
        'starting_fees' => 'decimal:2',
        'event_gallery' => 'array',
        'banner_image' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }

    /**
     * Get the creator (Admin or Professional)
     */
    public function creator()
    {
        // Handle both old format (admin/professional) and new format (full class names)
        if ($this->creator_type === 'admin') {
            return $this->belongsTo(\App\Models\Admin::class, 'creator_id');
        } elseif ($this->creator_type === 'professional') {
            return $this->belongsTo(\App\Models\Professional::class, 'creator_id');
        } elseif ($this->creator_type === \App\Models\Admin::class) {
            return $this->belongsTo(\App\Models\Admin::class, 'creator_id');
        } elseif ($this->creator_type === \App\Models\Professional::class) {
            return $this->belongsTo(\App\Models\Professional::class, 'creator_id');
        }
        
        return null;
    }

    /**
     * Get the admin creator (if created by admin)
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'creator_id');
    }

    /**
     * Get the professional creator (if created by professional)
     */
    public function professional()
    {
        return $this->belongsTo(\App\Models\Professional::class, 'creator_id');
    }

    /**
     * Scope to get event details created by admin
     */
    public function scopeByAdmin($query)
    {
        return $query->where('creator_type', 'admin');
    }

    /**
     * Scope to get event details created by professional
     */
    public function scopeByProfessional($query)
    {
        return $query->where('creator_type', 'professional');
    }

    /**
     * Check if event detail was created by admin
     */
    public function isCreatedByAdmin()
    {
        return $this->creator_type === 'admin';
    }

    /**
     * Check if event detail was created by professional
     */
    public function isCreatedByProfessional()
    {
        return $this->creator_type === 'professional';
    }

    /**
     * Get the creator name
     */
    public function getCreatorNameAttribute()
    {
        if ($this->creator_type === 'admin') {
            $admin = \App\Models\Admin::find($this->creator_id);
            return $admin ? $admin->name : 'Admin (Unknown)';
        } elseif ($this->creator_type === 'professional') {
            $professional = \App\Models\Professional::find($this->creator_id);
            return $professional ? $professional->name : 'Professional (Unknown)';
        }
        
        return ucfirst($this->creator_type ?? 'Unknown');
    }
}
