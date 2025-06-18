<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['blogPost.blog'])
            ->latest()
            ->paginate(10);
            
        return view('admin.blog-comment.index', compact('comments'));
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Comment approved successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
