<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBlog extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_sub_heading',
        'image1', 'heading1', 'description1', 'by_whom1',
        'image2', 'heading2', 'description2', 'by_whom2',
        'image3', 'heading3', 'description3', 'by_whom3',
    ];
}
