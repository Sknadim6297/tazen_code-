<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutuses = AboutUs::all(); // Fetch all AboutUs records
        return view('admin.aboutus.index', compact('aboutuses')); // Pass to view
    }

    public function create()
    {
        return view('admin.aboutus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
            'line1' => 'nullable|string|max:255',
            'line2' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'year_of_experience' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('aboutus', 'public');
        }

        AboutUs::create($validated);

        return redirect()->route('admin.aboutus.index')->with('success', 'About Us entry created successfully.');
    }

    public function edit($id)
    {
        $about = AboutUs::findOrFail($id);
        return view('admin.aboutus.edit', compact('about'));
    }

    public function update(Request $request, AboutUs $aboutus)
    {
        $request->validate([
            'heading'             => 'required|string|max:255',
            'year_of_experience'  => 'required|integer',
            'description'         => 'required|string',
            'line1'               => 'nullable|string|max:255',
            'line2'               => 'nullable|string|max:255',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only([
            'heading',
            'year_of_experience',
            'description',
            'line1',
            'line2',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($aboutus->image && file_exists(public_path('storage/' . $aboutus->image))) {
                unlink(public_path('storage/' . $aboutus->image));
            }

            // Store new image
            $data['image'] = $request->file('image')->store('aboutus', 'public');
        }

        $aboutus->update($data);

        return redirect()->route('admin.aboutus.index')
            ->with('success', 'About Us entry updated successfully.');
    }


    public function destroy($id)
    {
        $about = AboutUs::findOrFail($id);
        if ($about->image && file_exists(public_path('uploads/aboutus/' . $about->image))) {
            unlink(public_path('uploads/aboutus/' . $about->image));
        }
        $about->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
