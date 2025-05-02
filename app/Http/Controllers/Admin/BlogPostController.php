<?php

namespace App\Http\Controllers\Admin;
use App\Models\BlogPost;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
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
        $data['image'] = $request->file('image')->store('blog_images', 'public');
    }

    if ($request->hasFile('author_avatar')) {
        $data['author_avatar'] = $request->file('author_avatar')->store('avatars', 'public');
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
        \Storage::disk('public')->delete($blogPost->image);
    }

    if ($blogPost->author_avatar) {
        \Storage::disk('public')->delete($blogPost->author_avatar);
    }

    $blogPost->delete();

    return redirect()->route('admin.blogposts.index')->with('success', 'Blog post deleted successfully.');
    }

}
