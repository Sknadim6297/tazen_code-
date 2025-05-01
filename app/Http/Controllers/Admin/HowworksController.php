<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Howworks;

class HowworksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all Howworks records
        $howworks = Howworks::all();

        // Pass the data to the view
        return view('admin.howworks.index', compact('howworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the create view if you need to render a form.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_sub_heading' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading3' => 'nullable|string|max:255',
            'description3' => 'nullable|string',
        ]);

        // Handle file uploads for images
        $data = $request->all();

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image$i")) {
                $data["image$i"] = $request->file("image$i")->store("howworks", "public");
            }
        }

        // Store the data in the database
        Howworks::create($data);

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retrieve the specific Howworks record
        $howwork = Howworks::findOrFail($id);

        // Pass the record to the edit view
        return view('admin.howworks.edit', compact('howwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'section_sub_heading' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading3' => 'nullable|string|max:255',
            'description3' => 'nullable|string',
        ]);

        // Find the existing record
        $howwork = Howworks::findOrFail($id);

        // Update the data
        $data = $request->all();

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image$i")) {
                // Delete old image if exists
                if ($howwork["image$i"]) {
                    \Storage::delete("public/howworks/{$howwork["image$i"]}");
                }

                // Store the new image
                $data["image$i"] = $request->file("image$i")->store("howworks", "public");
            }
        }

        // Update the record in the database
        $howwork->update($data);

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the specific record
        $howwork = Howworks::findOrFail($id);

        // Delete the images if they exist
        for ($i = 1; $i <= 3; $i++) {
            if ($howwork["image$i"]) {
                \Storage::delete("public/howworks/{$howwork["image$i"]}");
            }
        }

        // Delete the record from the database
        $howwork->delete();

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section deleted successfully.');
    }
}
