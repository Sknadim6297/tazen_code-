<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutExperience extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_heading',
        'section_subheading',
        'content_heading',
        'content_subheading',
        'experience_heading1',
        'experience_percentage1',
        'description1',
        'experience_heading2',
        'experience_percentage2',
        'description2',
        'experience_heading3',
        'experience_percentage3',
        'description3',
    ];
}
