<?php

namespace App\Http\Controllers\Admin;
use App\Models\BlogPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogposts = BlogPost::latest()->get();
        return view('admin.blogposts.index', compact('blogposts'));
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
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'admin_name' => 'required|string|max:255',
            'comments_count' => 'required|integer',
            'blog_image' => 'nullable|image',
            'admin_avatar' => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('blog_image')) {
            $data['blog_image'] = $request->file('blog_image')->store('blog_images', 'public');
        }

        if ($request->hasFile('admin_avatar')) {
            $data['admin_avatar'] = $request->file('admin_avatar')->store('avatars', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('blogposts.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
