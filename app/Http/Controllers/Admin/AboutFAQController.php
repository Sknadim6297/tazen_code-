<?php

namespace App\Http\Controllers\Admin;
use App\Models\AboutFAQ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutFAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $aboutfaqs = AboutFAQ::all(); // or paginate()
    return view('admin.aboutfaq.index', compact('aboutfaqs'));
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
            'faq_description' => 'required|string',
            'question1' => 'required|string',
            'answer1' => 'required|string',
            'question2' => 'nullable|string',
            'answer2' => 'nullable|string',
            'question3' => 'nullable|string',
            'answer3' => 'nullable|string',
            'question4' => 'nullable|string',
            'answer4' => 'nullable|string',
        ]);

        AboutFAQ::create($request->all());

        return redirect()->route('admin.abouthowweworks.index')->with('success', 'FAQ created successfully.');
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
