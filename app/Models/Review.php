<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_id',
        'rating',
        'review_text',
        'is_approved'
    ];

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the professional that was reviewed.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
