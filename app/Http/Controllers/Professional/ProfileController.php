<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Profile;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professionalId = Auth::guard('professional')->id();
        $profiles = Profile::where('professional_id', $professionalId)->with('professional')->get();
        return view('professional.profile.show-profile', compact('profiles'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request, string $id)
    // {

    //     $data = $request->validate([
    //         'firstName' => 'required|string',
    //         'lastName' => 'required|string',
    //         'email' => 'required|email',
    //         'phone' => 'nullable|string',
    //         'specialization' => 'nullable|string',
    //         'experience' => 'nullable|string',
    //         'startingPrice' => 'nullable|numeric',
    //         'address' => 'nullable|string',
    //         'education' => 'nullable|string',
    //         'comments' => 'nullable|string',
    //         'bio' => 'nullable|string',
    //         'photo' => 'nullable|image',
    //         'gallery.*' => 'nullable|image',
    //         'qualificationDocument' => 'nullable|file',
    //         'aadhaarCard' => 'nullable|file',
    //         'panCard' => 'nullable|file',
    //     ]);

    //     $profile = Profile::findOrFail($id);
    //     $professionalId = Auth::guard('professional')->id();

    //     // Delete & update photo
    //     if ($request->hasFile('photo') && $profile->photo) {
    //         Storage::disk('public')->delete($profile->photo);
    //         $profile->photo = $this->uploadImage($request, 'photo', 'uploads/profiles/photo');
    //     }

    //     // Delete & update gallery
    //     if ($request->hasFile('gallery')) {
    //         if ($profile->gallery) {
    //             foreach (json_decode($profile->gallery, true) as $img) {
    //                 Storage::disk('public')->delete($img);
    //             }
    //         }
    //         $profile->gallery = json_encode($this->uploadMultipleImage($request, 'gallery', 'uploads/profiles/gallery'));
    //     }

    //     // Delete & update qualification document
    //     if ($request->hasFile('qualificationDocument') && $profile->qualification_document) {
    //         Storage::disk('public')->delete($profile->qualification_document);
    //         $profile->qualification_document = $this->uploadImage($request, 'qualificationDocument', 'uploads/profiles/documents');
    //     }

    //     // Delete & update aadhaar
    //     if ($request->hasFile('aadhaarCard') && $profile->aadhaar_card) {
    //         Storage::disk('public')->delete($profile->aadhaar_card);
    //         $profile->aadhaar_card = $this->uploadImage($request, 'aadhaarCard', 'uploads/profiles/identity');
    //     }

    //     // Delete & update pan
    //     if ($request->hasFile('panCard') && $profile->pan_card) {
    //         Storage::disk('public')->delete($profile->pan_card);
    //         $profile->pan_card = $this->uploadImage($request, 'panCard', 'uploads/profiles/identity');
    //     }

    //     // Update other fields
    //     $profile->professional_id = $professionalId;
    //     $profile->first_name = $data['firstName'];
    //     $profile->last_name = $data['lastName'];
    //     $profile->email = $data['email'];
    //     $profile->phone = $data['phone'] ?? null;
    //     $profile->specialization = $data['specialization'] ?? null;
    //     $profile->experience = $data['experience'] ?? null;
    //     $profile->starting_price = $data['startingPrice'] ?? null;
    //     $profile->address = $data['address'] ?? null;
    //     $profile->education = $data['education'] ?? null;
    //     $profile->comments = $data['comments'] ?? null;
    //     $profile->bio = $data['bio'] ?? null;
    //     $profile->save();

    //     // Update Professional name also
    //     $professional = Professional::findOrFail($professionalId);
    //     $professional->name = $data['firstName'] . ' ' . $data['lastName'];
    //     $professional->save();

    //     return response()->json(['success' => true, 'message' => 'Profile and name updated successfully!']);
    // }


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
        $data = $request->validate([
            'name' => 'required|string',
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
            'delete_gallery' => 'nullable|array',
            'qualificationDocument' => 'nullable|file',
            'aadhaarCard' => 'nullable|file',
            'panCard' => 'nullable|file',
        ]);

        $profile = Profile::findOrFail($id);
        
        // Security check - ensure the profile belongs to the authenticated professional
        if ($profile->professional_id != Auth::guard('professional')->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized access'], 403);
        }
        
        $professionalId = Auth::guard('professional')->id();

        // Handle profile photo update
        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $profile->photo = $this->uploadImage($request, 'photo', 'uploads/profiles/photo');
        }

        // Enhanced gallery handling - preserve existing images
        if ($request->hasFile('gallery') || $request->has('delete_gallery')) {
            // Get current gallery images
            $currentGallery = $profile->gallery ? json_decode($profile->gallery, true) : [];
            
            // Handle image deletions first
            if ($request->has('delete_gallery') && is_array($request->delete_gallery)) {
                foreach ($request->delete_gallery as $imageToDelete) {
                    // Find and remove from array
                    $key = array_search($imageToDelete, $currentGallery);
                    if ($key !== false) {
                        // Delete the actual file
                        Storage::disk('public')->delete($imageToDelete);
                        // Remove from array
                        unset($currentGallery[$key]);
                    }
                }
                // Reindex array to avoid issues with JSON encoding
                $currentGallery = array_values($currentGallery);
            }
            
            // Add new gallery images
            if ($request->hasFile('gallery')) {
                $newImages = $this->uploadMultipleImage($request, 'gallery', 'uploads/profiles/gallery');
                // Merge with existing images
                $currentGallery = array_merge($currentGallery, $newImages);
            }
            
            // Update gallery with preserved + new images
            $profile->gallery = json_encode($currentGallery);
        }

        // Handle document uploads
        if ($request->hasFile('qualificationDocument')) {
            if ($profile->qualification_document) {
                Storage::disk('public')->delete($profile->qualification_document);
            }
            $profile->qualification_document = $this->uploadImage($request, 'qualificationDocument', 'uploads/profiles/documents');
        }

        if ($request->hasFile('aadhaarCard')) {
            if ($profile->aadhaar_card) {
                Storage::disk('public')->delete($profile->aadhaar_card);
            }
            $profile->aadhaar_card = $this->uploadImage($request, 'aadhaarCard', 'uploads/profiles/identity');
        }

        if ($request->hasFile('panCard')) {
            if ($profile->pan_card) {
                Storage::disk('public')->delete($profile->pan_card);
            }
            $profile->pan_card = $this->uploadImage($request, 'panCard', 'uploads/profiles/identity');
        }

        // Update other fields
        $profile->professional_id = $professionalId;
        $profile->name = $data['name'];
        $profile->email = $data['email'];
        $profile->phone = $data['phone'] ?? null;
        $profile->specialization = $data['specialization'] ?? null;
        $profile->experience = $data['experience'] ?? null;
        $profile->starting_price = $data['startingPrice'] ?? null;
        $profile->address = $data['address'] ?? null;
        $profile->education = $data['education'] ?? null;
        $profile->comments = $data['comments'] ?? null;
        $profile->bio = $data['bio'] ?? null;
        $profile->save();

        // Update Professional name also
        $professional = Professional::findOrFail($professionalId);
        $professional->name = $data['name'];
        $professional->save();

        return response()->json(['status' => 'success', 'message' => 'Profile updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
