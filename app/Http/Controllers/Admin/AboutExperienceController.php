<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutExperience;

class AboutExperienceController extends Controller
{
    public function index()
    {
        $aboutexperiences = AboutExperience::latest()->get();
        return view('admin.aboutexperiences.index', compact('aboutexperiences'));
    }

    public function create()
    {
        return view('admin.aboutexperiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_heading' => 'nullable|string',
            'section_subheading' => 'nullable|string',
            'content_heading' => 'nullable|string',
            'content_subheading' => 'nullable|string',

            'experience_heading1' => 'nullable|string',
            'experience_percentage1' => 'nullable|integer',
            'description1' => 'nullable|string',

            'experience_heading2' => 'nullable|string',
            'experience_percentage2' => 'nullable|integer',
            'description2' => 'nullable|string',

            'experience_heading3' => 'nullable|string',
            'experience_percentage3' => 'nullable|integer',
            'description3' => 'nullable|string',
        ]);

        AboutExperience::create($validated);

        return redirect()->route('aboutexperiences.index')->with('success', 'About Experience added successfully.');
    }

    public function show(AboutExperience $aboutexperience)
    {
        return view('admin.aboutexperiences.show', compact('aboutexperience'));
    }

    public function edit(AboutExperience $aboutexperience)
    {
        return view('admin.aboutexperiences.edit', compact('aboutexperience'));
    }

    public function update(Request $request, AboutExperience $aboutexperience)
    {
        $validated = $request->validate([
            'section_heading' => 'nullable|string',
            'section_subheading' => 'nullable|string',
            'content_heading' => 'nullable|string',
            'content_subheading' => 'nullable|string',

            'experience_heading1' => 'nullable|string',
            'experience_percentage1' => 'nullable|integer',
            'description1' => 'nullable|string',

            'experience_heading2' => 'nullable|string',
            'experience_percentage2' => 'nullable|integer',
            'description2' => 'nullable|string',

            'experience_heading3' => 'nullable|string',
            'experience_percentage3' => 'nullable|integer',
            'description3' => 'nullable|string',
        ]);

        $aboutexperience->update($validated);

        return redirect()->route('aboutexperiences.index')->with('success', 'About Experience updated successfully.');
    }

    public function destroy(AboutExperience $aboutexperience)
    {
        $aboutexperience->delete();
        return redirect()->route('aboutexperiences.index')->with('success', 'About Experience deleted successfully.');
    }
}
