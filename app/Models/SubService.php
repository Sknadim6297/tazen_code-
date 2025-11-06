<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'integer'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Accessor to get status as string
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'active' : 'inactive';
    }

    // Scope for active sub-services
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
