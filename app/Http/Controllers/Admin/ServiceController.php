<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.service.index', compact('services'));
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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug ?: \Illuminate\Support\Str::slug($request->name),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Store image in public directory for direct access
            $imagePath = $request->file('image')->store('uploads/services', 'public');
            $data['image'] = $imagePath;
        }

        Service::create($data);

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug ?: \Illuminate\Support\Str::slug($request->name),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            
            // Store the new image
            $imagePath = $request->file('image')->store('uploads/services', 'public');
            $data['image'] = $imagePath;
        }

        $service->update($data);
        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();
        return back()->with('success', 'Service deleted successfully.');
    }

    public function getMcqs($service_id)
    {
        $mcqs = \App\Models\ServiceMCQ::where('service_id', $service_id)->first();
        return response()->json($mcqs);
    }
}