<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = [
        'heading',
        'description',
        'line_1',
        'line_2',
        'image',
        'year_of_experience',
        'banner_image',
    ];
}
