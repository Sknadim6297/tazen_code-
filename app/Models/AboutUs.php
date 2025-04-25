<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'heading',
        'description',
        'line1',
        'line2',
        'image',
        'year_of_experience',
    ];
}
