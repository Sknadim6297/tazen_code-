<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'professional_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization',
        'experience',
        'starting_price',
        'address',
        'education',
        'comments',
        'bio',
        'photo',
        'gallery',
        'qualification_document',
        'aadhaar_card',
        'pan_card',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
