<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\ProfessionalRejection;
use App\Models\Profile;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
    use ImageUploadTraits;
    // Show login form
    public function showLoginForm()
    {
        return view('professional.login.login');
    }

    // Show register form
    public function registerForm()
    {
        return view('professional.login.register');
    }

    // Handle login
    // Handle login
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::guard('professional')->attempt($credentials, $remember)) {
            $professional = Auth::guard('professional')->user();

            $request->session()->regenerate();
            
            // Check if the account is active
            if (!$professional->active) {
                Auth::guard('professional')->logout();
                return response()->json([
                    'status'  => 'deactivated',
                    'message' => 'Your account has been deactivated. Please contact support for assistance.',
                ], 403);
            }

            if ($professional->status === 'accepted') {
                return response()->json([
                    'status'  => 'success',
                    'redirect_url' => route('professional.dashboard'),
                    'message' => 'You are successfully logged in!',
                ]);
            }

            if ($professional->status === 'rejected') {
                return response()->json([
                    'status'  => 'rejected',
                    'redirect_url' => route('professional.rejected.view'),
                    'message' => 'Your profile has been rejected. Please review and resubmit your details.',
                ]);
            }

            return response()->json([
                'redirect_url' => route('professional.pending.view'),
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }



    public function register(Request $request)
    {
        $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:professionals,email',
            'password'              => 'required|min:6|confirmed',
            'phone'                 => 'required|string|max:20',
            'specialization'        => 'required|string|max:255',
            'experience'            => 'required|string|in:0-2,2-4,4-6,6-8,8-10,10+',
            'starting_price'        => 'required|string|max:255',
            'address'               => 'required|string|max:500',
            'education'             => 'required|string|max:255',
            'education2'            => 'nullable|string|max:255',
            'comments'              => 'nullable|string',
            'bio'                   => 'required|string|max:1000',
            'qualification_document' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'aadhaar_card'          => 'required|file|mimes:pdf,jpg,jpeg,png',
            'pan_card'              => 'required|file|mimes:pdf,jpg,jpeg,png',
            'profile_photo'                 => 'required|file|mimes:jpg,jpeg,png',
            'gallery.*'             => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $professional = Professional::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => 'pending',
        ]);

        $qualificationPath = $this->uploadImage($request, 'qualification_document', 'uploads/professionals/documents');
        $aadhaarPath       = $this->uploadImage($request, 'aadhaar_card', 'uploads/professionals/identity');
        $panPath           = $this->uploadImage($request, 'pan_card', 'uploads/professionals/identity');
        $photoPath         = $this->uploadImage($request, 'profile_photo', 'uploads/professionals/photo');
        $galleryPath       = $this->uploadMultipleImage($request, 'gallery', 'uploads/professionals/gallery');

        Profile::create([
            'professional_id'       => $professional->id,
            'name'                  => $request->first_name . ' ' . $request->last_name,
            'phone'                 => $request->phone,
            'email'                  => $request->email,
            'specialization'         => $request->specialization,
            'experience'             => $request->experience,
            'starting_price'         => $request->starting_price,
            'address'                => $request->address,
            'education'              => $request->education,
            'education2'             => $request->education2,
            'comments'               => $request->comments,
            'bio'                    => $request->bio,
            'qualification_document' => $qualificationPath,
            'aadhaar_card'           => $aadhaarPath,
            'pan_card'               => $panPath,
            'photo'                  => $photoPath,
            'gallery'                => json_encode($galleryPath),
        ]);

        Auth::guard('professional')->login($professional);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful. Admin approval is required before you can login.',
        ]);
    }


    public function rejectedPage()
    {
        // Fetch the latest rejection record for the logged-in professional
        $RejectedUser = ProfessionalRejection::with('professional', 'profile')
            ->where('professional_id', Auth::guard('professional')->id())
            ->latest('created_at')
            ->first();
        $reason = $RejectedUser ? $RejectedUser->reason : null;
        return view('professional.login.rejected', compact('RejectedUser', 'reason'));
    }
    public function pendingPage()
    {
        $professional = Professional::with('profile')->where('id', Auth::guard('professional')->id())->first();
        return view('professional.login.pending', compact('professional'));
    }
    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('professional')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
    public function reSubmit(Request $request)
    {
        $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email',
            'phone'                  => 'required|string|max:20',
            'specialization'         => 'required|string|max:255',
            'experience'             => 'required|string|max:255',
            'starting_price'         => 'required|string|max:255',
            'address'                => 'required|string|max:500',
            'education'              => 'required|string|max:255',
            'education2'             => 'nullable|string|max:255',
            'bio'                    => 'required|string|max:1000',
            'qualification_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'aadhaar_card'           => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'pan_card'               => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'photo'                  => 'nullable|file|mimes:jpg,jpeg,png',
            'gallery.*'              => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $professional = Professional::findOrFail(Auth::guard('professional')->id());
        // $RejectedUser = ProfessionalRejection::where('professional_id', $professional->id)->first();
        // if ($RejectedUser) {
        //     $RejectedUser->delete();
        // }
        $profile = Profile::where('professional_id', $professional->id)->first();

        $professional->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => 'pending',
        ]);

        $qualificationPath = $request->hasFile('qualification_document')
            ? $this->uploadImage($request, 'qualification_document', 'uploads/professionals/documents')
            : $profile->qualification_document;

        $aadhaarPath = $request->hasFile('aadhaar_card')
            ? $this->uploadImage($request, 'aadhaar_card', 'uploads/professionals/identity')
            : $profile->aadhaar_card;

        $panPath = $request->hasFile('pan_card')
            ? $this->uploadImage($request, 'pan_card', 'uploads/professionals/identity')
            : $profile->pan_card;

        $photoPath = $request->hasFile('photo')
            ? $this->uploadImage($request, 'photo', 'uploads/professionals/photo')
            : $profile->photo;

        $galleryPath = $request->hasFile('gallery')
            ? json_encode($this->uploadMultipleImage($request, 'gallery', 'uploads/professionals/gallery'))
            : $profile->gallery;

        $profile->update([
            'name'                   => $request->name,
            'email'                  => $request->email,
            'specialization'         => $request->specialization,
            'experience'             => $request->experience,
            'starting_price'         => $request->starting_price,
            'address'                => $request->address,
            'education'              => $request->education,
            'education2'             => $request->education2,
            'bio'                    => $request->bio,
            'qualification_document' => $qualificationPath,
            'aadhaar_card'           => $aadhaarPath,
            'pan_card'               => $panPath,
            'photo'                  => $photoPath,
            'gallery'                => $galleryPath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile re-submitted successfully. It is now under admin review.',
        ]);
    }
}
