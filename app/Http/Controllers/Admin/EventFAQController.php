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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $faq = EventFAQ::findOrFail($id);
    return view('admin.eventfaq.edit', compact('faq'));
}

public function update(Request $request, $id)
{
    $faq = EventFAQ::findOrFail($id);
    $request->validate([
        'question1' => 'required|string',
        'answer1' => 'required|string',
        'question2' => 'required|string',
        'answer2' => 'required|string',
        'question3' => 'required|string',
        'answer3' => 'required|string',
        'question4' => 'required|string',
        'answer4' => 'required|string',
    ]);

    $faq->update($request->only([
        'question1', 'answer1', 'question2', 'answer2',
        'question3', 'answer3', 'question4', 'answer4'
    ]));

    return redirect()->route('admin.eventfaq.index')->with('success', 'FAQ updated successfully!');
}

public function destroy($id)
{
    $faq = EventFAQ::findOrFail($id);
    $faq->delete();

    return redirect()->route('admin.eventfaq.index')->with('success', 'FAQ deleted successfully!');
}
}
