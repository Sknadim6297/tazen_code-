<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the profile details of the authenticated user.
     */
    public function index()
    {
        $profiles = User::with('customerProfile')
            ->where('id', Auth::guard('user')->user()->id)
            ->get();

        return view('customer.add-profile.index', compact('profiles'));
    }

    /**
     * Show the form for editing the specified profile.
     */
    public function edit($id)
    {
        $profile = User::with('customerProfile')->findOrFail($id);

        if (!$profile->customerProfile) {
            $profile->customerProfile()->create([
                'name' => $profile->name ?? '',
                'email' => $profile->email ?? '',
                'phone' => '',
                'address' => '',
                'notes' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'profile_image' => null,
            ]);
        }

        $profile->load('customerProfile');
        return view('customer.add-profile.edit', compact('profile'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request, $user_id)
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

        // Find the user
        $user = User::findOrFail($user_id);
        $profile = $user->customerProfile;

        // If no profile exists (just in case), create it
        if (!$profile) {
            $profile = $user->customerProfile()->create([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        // Prepare data to update
        $data = $request->only([
            'name', 'email', 'phone', 'address', 'notes',
            'city', 'state', 'zip_code',
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

        // Also update user table
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ]);
    }

    /**
     * Destroy the profile (optional, add logic if needed).
     */
    public function destroy($id)
    {
        $profile = CustomerProfile::findOrFail($id);
        $profile->delete();

        return redirect()->route('user.profile.index')->with('success', 'Profile deleted successfully.');
    }
}
