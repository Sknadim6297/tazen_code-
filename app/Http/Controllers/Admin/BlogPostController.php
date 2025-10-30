<?php

namespace App\Http\Controllers\Admin;
use App\Models\BlogPost;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogPosts = BlogPost::with('blog')->get();
        $blogTitles = Blog::latest()->get();
        
        return view('admin.blogposts.index', compact('blogPosts','blogTitles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'category' => 'required|string|max:255',
            'published_at' => 'required|date',
            'blog_id' => 'required|exists:blogs,id', // validate that blog id exists
            'content' => 'required|string',
            'author_name' => 'required|string|max:255',
            'author_avatar' => 'nullable|image',
            'comment_count' => 'nullable|integer|min:0',
        ]);
    
        $data = [
            'category' => $request->category,
            'published_at' => $request->published_at,
            'blog_id' => $request->blog_id, // Save blog ID directly
            'content' => $request->content,
            'author_name' => $request->author_name,
            'comment_count' => $request->comment_count ?? 0,
        ];
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog_images', 'public');
        }
    
        if ($request->hasFile('author_avatar')) {
            $data['author_avatar'] = $request->file('author_avatar')->store('avatars', 'public');
        }
    
        \App\Models\BlogPost::create($data);
    
        return redirect()->route('admin.blogposts.index')->with('success', 'Blog post created successfully.');
    }

/**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        
        return view('frontend.blog-post', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $blogPost = BlogPost::findOrFail($id);
    $blogTitles = Blog::latest()->get(); // for dropdown in edit form
    return view('admin.blogposts.edit', compact('blogPost', 'blogTitles'));
    }

/**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $blogPost = BlogPost::findOrFail($id);

    $request->validate([
        'image' => 'nullable|image',
        'category' => 'required|string|max:255',
        'published_at' => 'required|date',
        'blog_id' => 'required|exists:blogs,id',
        'content' => 'required|string',
        'author_name' => 'required|string|max:255',
        'author_avatar' => 'nullable|image',
        'comment_count' => 'nullable|integer|min:0',
    ]);

    $data = [
        'category' => $request->category,
        'published_at' => $request->published_at,
        'blog_id' => $request->blog_id,
        'content' => $request->content,
        'author_name' => $request->author_name,
        'comment_count' => $request->comment_count ?? 0,
    ];

    if ($request->hasFile('image')) {
        try {
            // Delete old image if it exists
            if ($blogPost->image && Storage::disk('public')->exists($blogPost->image)) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $imagePath = $request->file('image')->store('blog_images', 'public');
            if ($imagePath) {
                $data['image'] = $imagePath;
                Log::info('BlogPost image uploaded successfully: ' . $imagePath);
                
                // Also copy to blogs directory for Blog model consistency
                $sourcePath = storage_path('app/public/' . $imagePath);
                $fileName = basename($imagePath);
                $blogImagePath = 'blogs/' . $fileName;
                $destinationPath = storage_path('app/public/' . $blogImagePath);
                
                if (copy($sourcePath, $destinationPath)) {
                    // Update corresponding Blog image
                    $blog = Blog::find($request->blog_id);
                    if ($blog) {
                        // Delete old Blog image
                        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                            Storage::disk('public')->delete($blog->image);
                        }
                        $blog->image = $blogImagePath;
                        $blog->save();
                        Log::info('Blog image synced: ' . $blogImagePath);
                    }
                }
            } else {
                Log::error('Failed to store BlogPost image');
                return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('BlogPost image upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Image upload failed: ' . $e->getMessage());
        }
    }

    if ($request->hasFile('author_avatar')) {
        try {
            // Delete old avatar if it exists
            if ($blogPost->author_avatar && Storage::disk('public')->exists($blogPost->author_avatar)) {
                Storage::disk('public')->delete($blogPost->author_avatar);
            }
            $avatarPath = $request->file('author_avatar')->store('avatars', 'public');
            if ($avatarPath) {
                $data['author_avatar'] = $avatarPath;
                Log::info('BlogPost avatar uploaded successfully: ' . $avatarPath);
            } else {
                Log::error('Failed to store BlogPost avatar');
                return redirect()->back()->with('error', 'Failed to upload avatar. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('BlogPost avatar upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Avatar upload failed: ' . $e->getMessage());
        }
    }

    $blogPost->update($data);

    return redirect()->route('admin.blogposts.index')->with('success', 'Blog post updated successfully.');
    }

/**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $blogPost = BlogPost::findOrFail($id);

    if ($blogPost->image) {
        Storage::disk('public')->delete($blogPost->image);
    }

    if ($blogPost->author_avatar) {
        Storage::disk('public')->delete($blogPost->author_avatar);
    }

    $blogPost->delete();

    return redirect()->route('admin.blogposts.index')->with('success', 'Blog post deleted successfully.');
    }
}
