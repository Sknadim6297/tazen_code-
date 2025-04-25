<?php

namespace App\Http\Controllers\Admin;
use App\Models\BlogBanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Fetch all blog banners from the database
    $blogbanners = BlogBanner::all();

    // Pass the data to the view
    return view('admin.blogbanners.index', compact('blogbanners'));
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
            'heading' => 'required|string|max:255',
            'subheading' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        $imagePath = $request->file('banner_image')->store('public/blog_banners');

        // Create the new blog banner
        BlogBanner::create([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'banner_image' => $imagePath,
        ]);

        return redirect()->route('admin.blogbanners.index')->with('success', 'Blog Banner Created Successfully!');
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
