<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_post_id',
        'name',
        'email',
        'mobile',
        'comment',
        'is_approved'
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
