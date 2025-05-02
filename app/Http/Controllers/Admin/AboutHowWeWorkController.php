<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutHowWeWork;


class AboutHowWeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouthowweworks = AboutHowWeWork::all(); // or paginate(), or with() etc.
        return view('admin.abouthowweworks.index', compact('abouthowweworks'));
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
            'section_heading' => 'required|string|max:255',
            'section_sub_heading' => 'nullable|string|max:255',
            'content_heading' => 'nullable|string|max:255',
            'content_sub_heading' => 'nullable|string|max:255',
            'step1_heading' => 'nullable|string|max:255',
            'step1_description' => 'nullable|string',
            'step2_heading' => 'nullable|string|max:255',
            'step2_description' => 'nullable|string',
            'step3_heading' => 'nullable|string|max:255',
            'step3_description' => 'nullable|string',
            'step4_heading' => 'nullable|string|max:255',
            'step4_description' => 'nullable|string',
        ]);

        AboutHowWeWork::create($request->all());

        return redirect()->route('admin.abouthowweworks.index')->with('success', 'Data saved successfully!');
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
    $howwework = AboutHowWeWork::findOrFail($id);
    return view('admin.abouthowweworks.edit', compact('howwework'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'section_heading' => 'required|string',
        'section_sub_heading' => 'nullable|string',
        'content_heading' => 'nullable|string',
        'content_sub_heading' => 'nullable|string',

        'step1_heading' => 'nullable|string',
        'step1_description' => 'nullable|string',
        'step2_heading' => 'nullable|string',
        'step2_description' => 'nullable|string',
        'step3_heading' => 'nullable|string',
        'step3_description' => 'nullable|string',
        'step4_heading' => 'nullable|string',
        'step4_description' => 'nullable|string',
    ]);

    $howwework = AboutHowWeWork::findOrFail($id);
    $howwework->update($validated);

    return redirect()->route('admin.abouthowweworks.index')->with('success', 'How We Work updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $howwework = AboutHowWeWork::findOrFail($id);
    $howwework->delete();

    return redirect()->route('admin.abouthowweworks.index')->with('success', 'How We Work deleted successfully.');
}
}
