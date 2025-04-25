<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Howworks extends Model
{
    use HasFactory;

    // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'section_sub_heading',
        'image1',
        'heading1',
        'description1',
        'image2',
        'heading2',
        'description2',
        'image3',
        'heading3',
        'description3',
    ];
}
