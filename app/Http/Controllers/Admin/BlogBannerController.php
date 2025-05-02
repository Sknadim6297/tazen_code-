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
        // Validate the form data
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255', // Optional field
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle the image upload
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('blog_banners', 'public');
        }
    
        // Ensure subheading is not null
        $subheading = $validated['subheading'] ?? ''; // Assign empty string if subheading is not provided
    
        // Create the new blog banner entry
        BlogBanner::create([
            'heading' => $validated['heading'],
            'subheading' => $subheading, // Make sure subheading is always set
            'banner_image' => $imagePath ?? null, // Handle image upload
        ]);
    
        // Redirect or return success response
        return redirect()->route('admin.blogbanners.index')->with('success', 'Blog Banner added successfully!');
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
    public function edit($id)
{
    $banner = BlogBanner::findOrFail($id);
    return view('admin.blogbanners.edit', compact('banner'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $banner = BlogBanner::findOrFail($id);

    $validated = $request->validate([
        'heading' => 'required|string|max:255',
        'subheading' => 'nullable|string|max:255',
        // 'status' => 'required|in:active,inactive',
        'banner_image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('banner_image')) {
        // Optionally delete old image
        if ($banner->banner_image && file_exists(public_path('uploads/blog_banners/' . $banner->banner_image))) {
            unlink(public_path('uploads/blog_banners/' . $banner->banner_image));
        }

        $imageName = time() . '.' . $request->banner_image->extension();
        $request->banner_image->move(public_path('uploads/blog_banners'), $imageName);
        $validated['banner_image'] = $imageName;
    }

    $banner->update($validated);

    return redirect()->route('admin.blogbanners.index')->with('success', 'Banner updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $banner = BlogBanner::findOrFail($id);

    // Delete the image
    if ($banner->banner_image && file_exists(public_path('uploads/blog_banners/' . $banner->banner_image))) {
        unlink(public_path('uploads/blog_banners/' . $banner->banner_image));
    }

    $banner->delete();

    return redirect()->route('admin.blogbanners.index')->with('success', 'Banner deleted successfully!');
}

}
