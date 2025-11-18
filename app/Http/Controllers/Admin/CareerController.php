<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::latest()->get();
        return view('admin.careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.careers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'who_are_we' => 'nullable|string',
            'expectation_of_role' => 'nullable|string',
            'accounts_payable_payroll' => 'nullable|string',
            'accounts_receivable' => 'nullable|string',
            'financial_reporting' => 'nullable|string',
            'requirements' => 'nullable|string',
            'what_we_offer' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Career::create($request->all());

        return redirect()->route('admin.careers.index')->with('success', 'Career job created successfully.');
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
        $career = Career::findOrFail($id);
        return view('admin.careers.edit', compact('career'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $career = Career::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'who_are_we' => 'nullable|string',
            'expectation_of_role' => 'nullable|string',
            'accounts_payable_payroll' => 'nullable|string',
            'accounts_receivable' => 'nullable|string',
            'financial_reporting' => 'nullable|string',
            'requirements' => 'nullable|string',
            'what_we_offer' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $career->update($request->all());

        return redirect()->route('admin.careers.index')->with('success', 'Career job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return redirect()->route('admin.careers.index')->with('success', 'Career job deleted successfully.');
    }
}
