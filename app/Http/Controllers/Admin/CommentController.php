<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Exports\CommentsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['blogPost.blog']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('comment', 'like', '%' . $search . '%')
                  ->orWhereHas('blogPost.blog', function($subQ) use ($search) {
                      $subQ->where('title', 'like', '%' . $search . '%');
                  });
            });
        }
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        if ($request->filled('blog_post')) {
            $query->where('blog_post_id', $request->blog_post);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        switch ($sortField) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'blog_post':
                $query->join('blog_posts', 'comments.blog_post_id', '=', 'blog_posts.id')
                      ->join('blogs', 'blog_posts.blog_id', '=', 'blogs.id')
                      ->orderBy('blogs.title', $sortDirection)
                      ->select('comments.*');
                break;
            case 'is_approved':
                $query->orderBy('is_approved', $sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        $comments = $query->paginate(10);
        $blogPosts = BlogPost::with('blog')->get();

        return view('admin.blog-comment.index', compact('comments', 'blogPosts'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $query = Comment::with(['blogPost.blog']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('comment', 'like', '%' . $search . '%')
                  ->orWhereHas('blogPost.blog', function($subQ) use ($search) {
                      $subQ->where('title', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        if ($request->filled('blog_post')) {
            $query->where('blog_post_id', $request->blog_post);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $comments = $query->latest()->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.exports.comments-pdf', compact('comments'));
            return $pdf->download('blog-comments-' . date('Y-m-d') . '.pdf');
        } else {
            $export = new CommentsExport($comments);
            return $export->toCsv();
        }
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
