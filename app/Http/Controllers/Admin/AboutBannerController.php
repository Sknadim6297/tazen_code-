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
