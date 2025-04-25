<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::with('professional')->get();
        return view('professional.profile.show-profile', compact('profiles'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'specialization' => 'nullable|string',
            'experience' => 'nullable|string',
            'startingPrice' => 'nullable|numeric',
            'address' => 'nullable|string',
            'education' => 'nullable|string',
            'comments' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image',
            'gallery.*' => 'nullable|image',
            'qualificationDocument' => 'nullable|file',
            'aadhaarCard' => 'nullable|file',
            'panCard' => 'nullable|file',
        ]);

        $profile = new Profile();
        $profile->professional_id = Auth::guard('professional')->id();
        $profile->first_name = $data['firstName'];
        $profile->last_name = $data['lastName'];
        $profile->email = $data['email'];
        $profile->phone = $data['phone'] ?? null;
        $profile->specialization = $data['specialization'] ?? null;
        $profile->experience = $data['experience'] ?? null;
        $profile->starting_price = $data['startingPrice'] ?? null;
        $profile->address = $data['address'] ?? null;
        $profile->education = $data['education'] ?? null;
        $profile->comments = $data['comments'] ?? null;
        $profile->bio = $data['bio'] ?? null;


        $profile->photo = $this->uploadImage($request, 'photo', 'uploads/profiles/photo');
        $profile->gallery = json_encode($this->uploadMultipleImage($request, 'gallery', 'uploads/profiles/gallery'));
        $profile->qualification_document = $this->uploadImage($request, 'qualificationDocument', 'uploads/profiles/documents');
        $profile->aadhaar_card = $this->uploadImage($request, 'aadhaarCard', 'uploads/profiles/identity');
        $profile->pan_card = $this->uploadImage($request, 'panCard', 'uploads/profiles/identity');

        $profile->save();

        return response()->json(['success' => true, 'message' => 'Profile saved successfully!']);
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
        $profile = Profile::findOrFail($id);
        if ($profile->professional_id != Auth::guard('professional')->id()) {
            return redirect()->route('professional.profile.index')->with('error', 'Unauthorized access');
        }
        return view('professional.profile.add-profile', compact('profile'));
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
