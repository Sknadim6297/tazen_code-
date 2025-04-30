<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCQ;

class MCQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mcqs = MCQ::all();
        return view('admin.mcq.index', compact('mcqs'));
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
    // Validate the form data
    $request->validate([
        'question1' => 'required|string',
        'option1_a' => 'required|string',
        'option1_b' => 'required|string',
        'option1_c' => 'required|string',
        'option1_d' => 'required|string',
        'question2' => 'required|string',
        'option2_a' => 'required|string',
        'option2_b' => 'required|string',
        'option2_c' => 'required|string',
        'option2_d' => 'required|string',
        'question3' => 'required|string',
        'option3_a' => 'required|string',
        'option3_b' => 'required|string',
        'option3_c' => 'required|string',
        'option3_d' => 'required|string',
        'question4' => 'required|string',
        'option4_a' => 'required|string',
        'option4_b' => 'required|string',
        'option4_c' => 'required|string',
        'option4_d' => 'required|string',
        'question5' => 'required|string',
        'option5_a' => 'required|string',
        'option5_b' => 'required|string',
        'option5_c' => 'required|string',
        'option5_d' => 'required|string',
    ]);

    // Create the MCQ record
    MCQ::create([
        'question1' => $request->question1,
        'option1_a' => $request->option1_a,
        'option1_b' => $request->option1_b,
        'option1_c' => $request->option1_c,
        'option1_d' => $request->option1_d,
        'question2' => $request->question2,
        'option2_a' => $request->option2_a,
        'option2_b' => $request->option2_b,
        'option2_c' => $request->option2_c,
        'option2_d' => $request->option2_d,
        'question3' => $request->question3,
        'option3_a' => $request->option3_a,
        'option3_b' => $request->option3_b,
        'option3_c' => $request->option3_c,
        'option3_d' => $request->option3_d,
        'question4' => $request->question4,
        'option4_a' => $request->option4_a,
        'option4_b' => $request->option4_b,
        'option4_c' => $request->option4_c,
        'option4_d' => $request->option4_d,
        'question5' => $request->question5,
        'option5_a' => $request->option5_a,
        'option5_b' => $request->option5_b,
        'option5_c' => $request->option5_c,
        'option5_d' => $request->option5_d,
    ]);

    // Redirect back with a success message
    return redirect()->route('admin.mcq.index')->with('success', 'MCQ added successfully!');
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
