<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventFAQ;

class EventFAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventfaqs = EventFAQ::all();
        return view('admin.eventfaq.index', compact('eventfaqs'));
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
            'question1' => 'required|string|max:255',
            'answer1' => 'required|string',
            'question2' => 'nullable|string|max:255',
            'answer2' => 'nullable|string',
            'question3' => 'nullable|string|max:255',
            'answer3' => 'nullable|string',
            'question4' => 'nullable|string|max:255',
            'answer4' => 'nullable|string',
        ]);

        EventFAQ::create($request->all());

        return redirect()->route('admin.eventfaq.index')->with('success', 'Event FAQ added successfully.');
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
