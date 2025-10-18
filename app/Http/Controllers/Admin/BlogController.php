<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogPost;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'short_description' => 'required|string', // Ensure validation for short_description
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'created_by' => 'required|string',
        'status' => 'required|in:active,inactive',
    ]);
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('blogs', 'public');
    }
    Blog::create([
        'title' => $validated['title'],
        'description_short' => $validated['short_description'], // Pass the short description
        'image' => isset($imagePath) ? $imagePath : null, // Handle image path
        'created_by' => $validated['created_by'],
        'status' => $validated['status'],
    ]);

    return redirect()->route('admin.blogs.index')->with('success', 'Blog added successfully');
    }

/**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|string|max:255',
            'description_short' => 'required|string',
            'created_by' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }

    public function show($id)
{
    $blogPost = BlogPost::findOrFail($id);
    return view('frontend.sections.blog-post', compact('blogPost'));
}
}
