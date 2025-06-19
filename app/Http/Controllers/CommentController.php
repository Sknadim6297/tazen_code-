<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $blogPostId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'comment' => 'required|string'
        ]);

        Comment::create([
            'blog_post_id' => $blogPostId,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'comment' => $request->comment,
            'is_approved' => false // Comments need approval by default
        ]);

        return redirect()->back()->with('success', 'Your comment has been submitted and is awaiting approval.');
    }
}
