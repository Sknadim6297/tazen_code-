<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'category',
        'published_at',
        'title',
        'content',
        'author_name',
        'author_avatar',
        'comment_count',
    ];
}
