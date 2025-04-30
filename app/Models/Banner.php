<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'heading',
        'sub_heading',
        'banner_video', // updated from banner_image to banner_video
        'status',
    ];
    
}
