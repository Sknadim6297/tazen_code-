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
    $validatedData = $request->validate([
        'faq_description' => 'required|string',
        'question1' => 'required|string',
        'answer1' => 'required|string',
        'question2' => 'required|string',
        'answer2' => 'required|string',
        'question3' => 'required|string',
        'answer3' => 'required|string',
        'question4' => 'required|string',
        'answer4' => 'required|string',
    ]);

    AboutFaq::create([
        'faq_description' => $validatedData['faq_description'],
        'question1' => $validatedData['question1'],
        'answer1' => $validatedData['answer1'],
        'question2' => $validatedData['question2'],
        'answer2' => $validatedData['answer2'],
        'question3' => $validatedData['question3'],
        'answer3' => $validatedData['answer3'],
        'question4' => $validatedData['question4'],
        'answer4' => $validatedData['answer4'],
    ]);

    return redirect()->back()->with('success', 'FAQ Added Successfully!');
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
