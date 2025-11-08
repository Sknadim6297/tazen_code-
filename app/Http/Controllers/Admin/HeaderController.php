<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\HeaderFeature;
use App\Models\Service;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = Header::with('features.services')->latest()->get();
        $services = Service::where('status', 'active')->get();
        return view('admin.header.index', compact('headers', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tagline' => 'required|string',
            'status' => 'required|in:active,inactive',
            'features' => 'required|array|min:1',
            'features.*.feature_heading' => 'required|string',
            'features.*.services' => 'required|array|min:1',
            'features.*.services.*' => 'exists:services,id'
        ]);

        // Create the header
        $header = Header::create([
            'tagline' => $request->tagline,
            'status' => $request->status
        ]);

        // Create features and attach services
        foreach ($request->features as $index => $feature) {
            $headerFeature = HeaderFeature::create([
                'header_id' => $header->id,
                'feature_heading' => $feature['feature_heading'],
                'order' => $index
            ]);

            // Attach services to the feature
            $headerFeature->services()->attach($feature['services']);
        }

        return redirect()->route('admin.header.index')
            ->with('success', 'Header created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $header)
    {
        $request->validate([
            'tagline' => 'required|string',
            'status' => 'required|in:active,inactive',
            'features' => 'required|array|min:1',
            'features.*.feature_heading' => 'required|string',
            'features.*.services' => 'required|array|min:1',
            'features.*.services.*' => 'exists:services,id'
        ]);

        // Update the header
        $header->update([
            'tagline' => $request->tagline,
            'status' => $request->status
        ]);

        // Delete existing features (cascading will handle services)
        $header->features()->delete();

        // Create new features and attach services
        foreach ($request->features as $index => $feature) {
            $headerFeature = HeaderFeature::create([
                'header_id' => $header->id,
                'feature_heading' => $feature['feature_heading'],
                'order' => $index
            ]);

            // Attach services to the feature
            $headerFeature->services()->attach($feature['services']);
        }

        return redirect()->route('admin.header.index')
            ->with('success', 'Header updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Header $header)
    {
        $header->delete();

        return redirect()->route('admin.header.index')
            ->with('success', 'Header deleted successfully.');
    }
}

