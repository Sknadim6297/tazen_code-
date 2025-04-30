<?php

namespace App\Http\Controllers\Admin;
use App\Models\ServiceDetails;
use App\Models\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Get all service details
    $serviceDetails = ServiceDetails::all();

    // Get all services for the dropdown (assuming you have a Service model)
    $services = Service::all(); 

    // Return the view with both serviceDetails and services variables
    return view('admin.service-details.index', compact('serviceDetails', 'services'));
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
        // Validate form data
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
    
            // Banner Section
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_heading' => 'required|string|max:255',
            'banner_sub_heading' => 'nullable|string|max:255',
    
            // About Section
            'about_heading' => 'required|string|max:255',
            'about_subheading' => 'nullable|string|max:255',
            'about_description' => 'required|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    
            // How It Works Section
            'how_it_works_subheading' => 'nullable|string|max:255',
            'content_heading' => 'required|string|max:255',
            'content_sub_heading' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    
            // Steps
            'step1_heading' => 'required|string|max:255',
            'step1_description' => 'required|string',
            'step2_heading' => 'nullable|string|max:255',
            'step2_description' => 'nullable|string',
            'step3_heading' => 'nullable|string|max:255',
            'step3_description' => 'nullable|string',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('service-details', 'public');
        }
    
        if ($request->hasFile('about_image')) {
            $validated['about_image'] = $request->file('about_image')->store('service-details', 'public');
        }
    
        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store('service-details', 'public');
        }
    
        // Store in DB
        ServiceDetails::create($validated);
    
        return redirect()->route('admin.service-details.index')
                         ->with('success', 'Service details created successfully.');
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
