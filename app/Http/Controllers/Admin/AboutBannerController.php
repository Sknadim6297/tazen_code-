<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutBanner;
use Illuminate\Http\Request;

class AboutBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = AboutBanner::all();
        return view('admin.about-banner.index', compact('banners'));
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
            'subheading' => 'nullable|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('banner_image')->store('banner_images', 'public');

        // Store the banner details in the database
        AboutBanner::create([
            'heading' => $request->input('heading'),
            'subheading' => $request->input('subheading'),
            'banner_image' => $imagePath,
        ]);

        return redirect()->route('admin.about-banner.index')->with('success', 'Banner added successfully');
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
    $banner = AboutBanner::findOrFail($id);
    return view('admin.about-banner.edit', compact('banner'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $banner = AboutBanner::findOrFail($id);

    $data = $request->validate([
        'heading' => 'required|string',
        'sub_heading' => 'nullable|string',
        // 'status' => 'required|in:active,inactive',
        'banner_image' => 'nullable|image',
    ]);

    if ($request->hasFile('banner_image')) {
        if ($banner->banner_image && file_exists(public_path('uploads/banners/' . $banner->banner_image))) {
            unlink(public_path('uploads/banners/' . $banner->banner_image));
        }
        $filename = time() . '.' . $request->banner_image->extension();
        $request->banner_image->move(public_path('uploads/banners'), $filename);
        $data['banner_image'] = $filename;
    }

    $banner->update($data);
    return redirect()->back()->with('success', 'Banner updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $banner = AboutBanner::findOrFail($id);
    if ($banner->banner_image && file_exists(public_path('uploads/banners/' . $banner->banner_image))) {
        unlink(public_path('uploads/banners/' . $banner->banner_image));
    }
    $banner->delete();
    return redirect()->back()->with('success', 'Banner deleted successfully.');
    }
}
