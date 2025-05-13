<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = CustomerProfile::all();
        return view('customer.add-profile.index', compact('profiles'));
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
        //
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
        $profile = CustomerProfile::findOrFail($id);
        return view('customer.add-profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = CustomerProfile::findOrFail($id);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'address',
            'notes',
            'city',
            'state',
            'zip_code'
        ]);

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image && file_exists(public_path($profile->profile_image))) {
                unlink(public_path($profile->profile_image));
            }
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $data['profile_image'] = 'uploads/profiles/' . $filename;
        }
        $profile->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ]);
    }

    public function destroy(string $id)
    {
        //
    }
}
