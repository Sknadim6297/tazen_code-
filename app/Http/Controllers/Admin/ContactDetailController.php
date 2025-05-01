<?php

namespace App\Http\Controllers\Admin;
use App\Models\ContactDetail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactdetails = ContactDetail::latest()->get();
        return view('admin.contactdetails.index', compact('contactdetails'));
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
            'icon1' => 'required|string|max:255',
            'heading1' => 'required|string|max:255',
            'sub_heading1' => 'nullable|string|max:255',
            'description1' => 'nullable|string',
            'icon2' => 'required|string|max:255',
            'heading2' => 'required|string|max:255',
            'sub_heading2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'icon3' => 'required|string|max:255',
            'heading3' => 'required|string|max:255',
            'sub_heading3' => 'nullable|string|max:255',
            'description3' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        ContactDetail::create($request->all());

        return redirect()->route('admin.contactdetails.index')->with('success', 'Contact details added successfully.');
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
    /**
     * Update the specified resource in storage.
     */
    public function edit($id)
    {
    $contactdetail = ContactDetail::findOrFail($id);
    return view('admin.contactdetails.edit', compact('contactdetail'));
    }

    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'icon1' => 'required|string',
        'heading1' => 'required|string',
        'sub_heading1' => 'nullable|string',
        'description1' => 'nullable|string',
        'icon2' => 'required|string',
        'heading2' => 'required|string',
        'sub_heading2' => 'nullable|string',
        'description2' => 'nullable|string',
        'icon3' => 'required|string',
        'heading3' => 'required|string',
        'sub_heading3' => 'nullable|string',
        'description3' => 'nullable|string',
        'status' => 'required|in:active,inactive',
    ]);

    $contactdetail = ContactDetail::findOrFail($id);
    $contactdetail->update($validated);

    return redirect()->route('admin.contactdetails.index')->with('success', 'Contact details updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $contactdetail = ContactDetail::findOrFail($id);
    $contactdetail->delete();

    return redirect()->route('admin.contactdetails.index')->with('success', 'Contact details deleted successfully.');
    }

}
