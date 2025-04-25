<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Whychoose;


class WhychooseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whychoose = Whychoose::all(); // not first(), use all()
        return view('admin.whychoose.index', compact('whychoose'));
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

            'card1_heading' => 'nullable|string|max:255',
            'card1_mini_heading' => 'nullable|string|max:255',
            'card1_icon' => 'nullable|string|max:255',
            'card1_description' => 'nullable|string',

            'card2_heading' => 'nullable|string|max:255',
            'card2_mini_heading' => 'nullable|string|max:255',
            'card2_icon' => 'nullable|string|max:255',
            'card2_description' => 'nullable|string',

            'card3_heading' => 'nullable|string|max:255',
            'card3_mini_heading' => 'nullable|string|max:255',
            'card3_icon' => 'nullable|string|max:255',
            'card3_description' => 'nullable|string',

            'card4_heading' => 'nullable|string|max:255',
            'card4_mini_heading' => 'nullable|string|max:255',
            'card4_icon' => 'nullable|string|max:255',
            'card4_description' => 'nullable|string',

            'card5_heading' => 'nullable|string|max:255',
            'card5_mini_heading' => 'nullable|string|max:255',
            'card5_icon' => 'nullable|string|max:255',
            'card5_description' => 'nullable|string',

            'card6_heading' => 'nullable|string|max:255',
            'card6_mini_heading' => 'nullable|string|max:255',
            'card6_icon' => 'nullable|string|max:255',
            'card6_description' => 'nullable|string',
        ]);

        Whychoose::create($request->all());

        return redirect()->back()->with('success', 'Why Choose section added successfully.');
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
        $whychoose = Whychoose::findOrFail($id);
        return view('admin.whychoose.edit', compact('whychoose'));
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
