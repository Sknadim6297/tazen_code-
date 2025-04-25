<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutHowWeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_heading',
        'section_sub_heading',
        'content_heading',
        'content_sub_heading',
        'step1_heading',
        'step1_description',
        'step2_heading',
        'step2_description',
        'step3_heading',
        'step3_description',
        'step4_heading',
        'step4_description',
    ];
}
