<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get(); // fetch all banners
        return view('admin.banner.index', compact('banners'));   // pass to the view
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
        'sub_heading' => 'nullable|string|max:255',
        'banner_video' => 'nullable|mimes:mp4,avi,mov,wmv|max:51200', // max 50MB
    ]);

    $data = $request->only(['heading', 'sub_heading', 'status']);

    // Handle video upload
    if ($request->hasFile('banner_video')) {
        $videoPath = $request->file('banner_video')->store('banners', 'public');
        $data['banner_video'] = $videoPath; // only save 'banners/video.mp4'
    }

    Banner::create($data);

    return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully!');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'heading' => 'required|string|max:255',
            'banner_video' => 'nullable|mimes:mp4,avi,mov|max:20480',
        ]);

        $data = $request->only('heading', 'sub_heading', 'status');

        if ($request->hasFile('banner_video')) {
            $videoPath = $request->file('banner_video')->store('banners', 'public');
            $data['banner_video'] = $videoPath;
        }

        $banner->update($data);

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully.');
    }
}
