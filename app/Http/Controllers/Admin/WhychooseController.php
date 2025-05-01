<?php

namespace App\Http\Controllers\Admin;

use App\Models\Whychoose;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhychooseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whychooses = Whychoose::all(); // Get all entries
        return view('admin.whychoose.index', compact('whychooses')); // return view with data
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
    // Validate the incoming data
    $request->validate([
        'section_heading' => 'required|string|max:255',
        'section_sub_heading' => 'required|string|max:255',
        'card1_mini_heading' => 'required|string|max:255',
        'card1_heading' => 'required|string|max:255',
        'card1_icon' => 'required|string|max:255',
        'card1_description' => 'required|string',
        'card2_mini_heading' => 'required|string|max:255',
        'card2_heading' => 'required|string|max:255',
        'card2_icon' => 'required|string|max:255',
        'card2_description' => 'required|string',
        'card3_mini_heading' => 'required|string|max:255',
        'card3_heading' => 'required|string|max:255',
        'card3_icon' => 'required|string|max:255',
        'card3_description' => 'required|string',
        'card4_mini_heading' => 'required|string|max:255',
        'card4_heading' => 'required|string|max:255',
        'card4_icon' => 'required|string|max:255',
        'card4_description' => 'required|string',
        'card5_mini_heading' => 'required|string|max:255',
        'card5_heading' => 'required|string|max:255',
        'card5_icon' => 'required|string|max:255',
        'card5_description' => 'required|string',
        'card6_mini_heading' => 'required|string|max:255',
        'card6_heading' => 'required|string|max:255',
        'card6_icon' => 'required|string|max:255',
        'card6_description' => 'required|string',
    ]);

    // Create a new entry in the Whychoose table
    $data = $request->all();
    Whychoose::create($data);

    // Redirect back with success message
    return redirect()->route('admin.whychoose.index')->with('success', 'Whychoose section added successfully!');
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
        $whychoose = WhyChoose::findOrFail($id);
        return view('admin.whychoose.edit', compact('whychoose'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $whychoose = WhyChoose::findOrFail($id);

        $validatedData = $request->validate([
            'section_heading' => 'required|string|max:255',
            'section_sub_heading' => 'required|string|max:255',
            // Validate cards
            'card1_mini_heading' => 'required|string|max:255',
            'card1_heading' => 'required|string|max:255',
            'card1_icon' => 'required|string|max:255',
            'card1_description' => 'required|string',
            'card2_mini_heading' => 'required|string|max:255',
            'card2_heading' => 'required|string|max:255',
            'card2_icon' => 'required|string|max:255',
            'card2_description' => 'required|string',
            'card3_mini_heading' => 'required|string|max:255',
            'card3_heading' => 'required|string|max:255',
            'card3_icon' => 'required|string|max:255',
            'card3_description' => 'required|string',
            'card4_mini_heading' => 'required|string|max:255',
            'card4_heading' => 'required|string|max:255',
            'card4_icon' => 'required|string|max:255',
            'card4_description' => 'required|string',
            'card5_mini_heading' => 'required|string|max:255',
            'card5_heading' => 'required|string|max:255',
            'card5_icon' => 'required|string|max:255',
            'card5_description' => 'required|string',
            'card6_mini_heading' => 'required|string|max:255',
            'card6_heading' => 'required|string|max:255',
            'card6_icon' => 'required|string|max:255',
            'card6_description' => 'required|string',
        ]);

        $whychoose->update($validatedData);

        return redirect()->route('admin.whychoose.index')->with('success', 'Why Choose Us section updated successfully.');
    }

    // Delete a record
    public function destroy($id)
    {
        $whychoose = WhyChoose::findOrFail($id);
        $whychoose->delete();

        return redirect()->back()->with('success', 'Why Choose Us section deleted successfully.');
    }
}
