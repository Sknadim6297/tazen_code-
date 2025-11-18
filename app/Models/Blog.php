<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'title',
        'meta_title',
        'meta_description',
        'description_short',
        'created_by',
        'status',
    ];
}
