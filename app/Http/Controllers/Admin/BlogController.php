<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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

        // Prepare data for update - exclude image initially
        $data = $request->only(['title', 'description_short', 'created_by', 'status']);

        // Handle image upload only if a new image is provided
        if ($request->hasFile('image')) {
            try {
                // Delete old image if it exists
                if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                    Storage::disk('public')->delete($blog->image);
                }
                
                // Store new image
                $imagePath = $request->file('image')->store('blogs', 'public');
                if ($imagePath) {
                    $data['image'] = $imagePath;
                    Log::info('Blog image uploaded successfully: ' . $imagePath);
                    
                    // Also copy to blog_images directory for BlogPost frontend display
                    $sourcePath = storage_path('app/public/' . $imagePath);
                    $fileName = basename($imagePath);
                    $blogImagePath = 'blog_images/' . $fileName;
                    $destinationPath = storage_path('app/public/' . $blogImagePath);
                    
                    if (copy($sourcePath, $destinationPath)) {
                        // Update corresponding BlogPost image
                        $blogPost = BlogPost::where('blog_id', $blog->id)->first();
                        if ($blogPost) {
                            // Delete old BlogPost image
                            if ($blogPost->image && Storage::disk('public')->exists($blogPost->image)) {
                                Storage::disk('public')->delete($blogPost->image);
                            }
                            $blogPost->image = $blogImagePath;
                            $blogPost->save();
                            Log::info('BlogPost image synced: ' . $blogImagePath);
                        }
                    }
                } else {
                    Log::error('Failed to store blog image');
                    return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
                }
            } catch (\Exception $e) {
                Log::error('Blog image upload error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Image upload failed: ' . $e->getMessage());
            }
        }
        // If no new image is uploaded, keep the existing image (don't update image field)

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
