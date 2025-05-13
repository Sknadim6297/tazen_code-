<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'email',
        'phone',
        'specialization',
        'experience',
        'starting_price',
        'address',
        'education',
        'education2', 
        'bio',
        'comments',
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
