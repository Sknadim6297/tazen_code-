<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'banner_image',
        'banner_heading',
        'banner_sub_heading',
        'about_heading',
        'about_subheading',
        'about_description',
        'about_image',
        'how_it_works_subheading',
        'content_heading',
        'content_sub_heading',
        'background_image',
        'step1_heading',
        'step1_description',
        'step2_heading',
        'step2_description',
        'step3_heading',
        'step3_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
