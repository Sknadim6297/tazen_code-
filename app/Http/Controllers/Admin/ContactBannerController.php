<?php

namespace App\Http\Controllers\Admin;
use App\Models\Contactbanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $contactbanners = ContactBanner::all(); // or paginate(10) if needed
    return view('admin.contactbanner.index', compact('contactbanners'));
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
            'heading' => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['heading', 'sub_heading', 'status']);

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/contactbanners'), $filename);
            $data['banner_image'] = 'uploads/contactbanners/'.$filename;
        }

        Contactbanner::create($data);

        return redirect()->route('admin.contactbanner.index')->with('success', 'Banner Added Successfully!');
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
    $contactbanner = ContactBanner::findOrFail($id);
    return view('admin.contactbanner.edit', compact('contactbanner'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $contactbanner = ContactBanner::findOrFail($id);

    $request->validate([
        'heading' => 'required',
        'sub_heading' => 'nullable',
        'banner_image' => 'nullable|image',
        'status' => 'required'
    ]);

    $contactbanner->heading = $request->heading;
    $contactbanner->sub_heading = $request->sub_heading;
    $contactbanner->status = $request->status;

    // Check if a new image is uploaded
    if ($request->hasFile('banner_image')) {
        // Delete old image
        if (file_exists(public_path('uploads/contactbanner/' . $contactbanner->banner_image))) {
            unlink(public_path('uploads/contactbanner/' . $contactbanner->banner_image));
        }

        $file = $request->file('banner_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/contactbanner/'), $filename);
        $contactbanner->banner_image = $filename;
    }

    $contactbanner->save();

    return redirect()->route('admin.contactbanner.index')->with('success', 'Contact banner updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $contactbanner = ContactBanner::findOrFail($id);

    // Delete banner image
    if (file_exists(public_path('uploads/contactbanner/' . $contactbanner->banner_image))) {
        unlink(public_path('uploads/contactbanner/' . $contactbanner->banner_image));
    }

    $contactbanner->delete();

    return redirect()->route('admin.contactbanner.index')->with('success', 'Contact banner deleted successfully!');
}

}
