<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonial = Testimonial::first(); // Only one row expected
        return view('admin.testimonial.index', compact('testimonial'));
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
        $data = $request->all();

        for ($i = 1; $i <= 4; $i++) {
            if ($request->hasFile("image$i")) {
                $data["image$i"] = $request->file("image$i")->store('testimonials', 'public');
            }
        }

        Testimonial::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Testimonial updated successfully!');
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
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Validate request
        $request->validate([
            'section_sub_heading' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description1' => 'nullable|string|max:500',
            'description2' => 'nullable|string|max:500',
            'description3' => 'nullable|string|max:500',
            'description4' => 'nullable|string|max:500',
        ]);

        // Update fields
        $testimonial->section_sub_heading = $request->section_sub_heading;
        $testimonial->description1 = $request->description1;
        $testimonial->description2 = $request->description2;
        $testimonial->description3 = $request->description3;
        $testimonial->description4 = $request->description4;

        // Handle file uploads
        for ($i = 1; $i <= 4; $i++) {
            if ($request->hasFile('image' . $i)) {
                $imagePath = $request->file('image' . $i)->store('testimonials', 'public');
                // If image exists already, delete old one
                if ($testimonial->{'image' . $i}) {
                    Storage::delete('public/' . $testimonial->{'image' . $i});
                }
                $testimonial->{'image' . $i} = $imagePath;
            }
        }

        $testimonial->save();

        return redirect()->route('admin.admin.testimonial.index')->with('success', 'Testimonial updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete images if exist
        for ($i = 1; $i <= 4; $i++) {
            if ($testimonial->{'image' . $i}) {
                Storage::delete('public/' . $testimonial->{'image' . $i});
            }
        }

        $testimonial->delete();

        return redirect()->route('admin.admin.testimonial.index')->with('success', 'Testimonial deleted successfully!');
    }
}
