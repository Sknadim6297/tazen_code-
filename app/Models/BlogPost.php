<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    // Allow 'blog_id' instead of 'title' to be mass-assigned
    protected $fillable = [
        'image',
        'category',
        'published_at',
        'blog_id', // updated from 'title' to 'blog_id'
        'content',
        'author_name',
        'author_avatar',
        'comment_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Define the relationship with the Blog model.
     * Each BlogPost belongs to one Blog.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');  // Define the relationship
    }
    
}
