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
        $howworks = Howworks::all();
        return view('admin.howworks.index', compact('howworks'));
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
        $data = $request->all();

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image$i")) {
                $data["image$i"] = $request->file("image$i")->store("howworks", "public");
            }
        }
        Howworks::create($data);

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $howwork = Howworks::findOrFail($id);
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
        $howwork = Howworks::findOrFail($id);
        $data = $request->all();

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image$i")) {
                if ($howwork["image$i"]) {
                    \Storage::delete("public/howworks/{$howwork["image$i"]}");
                }
                $data["image$i"] = $request->file("image$i")->store("howworks", "public");
            }
        }
        $howwork->update($data);

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $howwork = Howworks::findOrFail($id);
        for ($i = 1; $i <= 3; $i++) {
            if ($howwork["image$i"]) {
                \Storage::delete("public/howworks/{$howwork["image$i"]}");
            }
        }
        $howwork->delete();

        return redirect()->route('admin.howworks.index')->with('success', 'Howworks section deleted successfully.');
    }
}
