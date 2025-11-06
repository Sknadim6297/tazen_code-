<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'user_id',
        'last_seen_at',
        'is_online'
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    /**
     * Get the user this activity belongs to  
     */
    public function user()
    {
        return $this->morphTo('user', 'user_type', 'user_id');
    }

    /**
     * Update user's online status
     */
    public static function updateUserActivity($userType, $userId, $isOnline = true)
    {
        return self::updateOrCreate(
            [
                'user_type' => $userType,
                'user_id' => $userId
            ],
            [
                'is_online' => $isOnline,
                'last_seen_at' => now()
            ]
        );
    }

    /**
     * Mark user as offline
     */
    public static function markUserOffline($userType, $userId)
    {
        return self::updateOrCreate(
            [
                'user_type' => $userType,
                'user_id' => $userId
            ],
            [
                'is_online' => false,
                'last_seen_at' => now()
            ]
        );
    }

    /**
     * Check if user is online
     */
    public static function isUserOnline($userType, $userId)
    {
        $activity = self::where('user_type', $userType)
                       ->where('user_id', $userId)
                       ->first();
        
        if (!$activity) {
            return false;
        }

        // Consider user online if they were active in the last 5 minutes
        return $activity->is_online && $activity->last_seen_at->diffInMinutes(now()) <= 5;
    }

    /**
     * Get last seen time formatted
     */
    public function getLastSeenFormattedAttribute()
    {
        if ($this->is_online && $this->last_seen_at->diffInMinutes(now()) <= 5) {
            return 'Online';
        }

        if (!$this->last_seen_at) {
            return 'Never';
        }

        $diffInMinutes = $this->last_seen_at->diffInMinutes(now());
        
        if ($diffInMinutes < 1) {
            return 'Just now';
        } elseif ($diffInMinutes < 60) {
            return $diffInMinutes . ' minutes ago';
        } elseif ($diffInMinutes < 1440) { // Less than 24 hours
            $hours = floor($diffInMinutes / 60);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } else {
            $days = floor($diffInMinutes / 1440);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        }
    }

    /**
     * Scope for online users
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', true)
                     ->where('last_seen_at', '>=', now()->subMinutes(5));
    }
}
