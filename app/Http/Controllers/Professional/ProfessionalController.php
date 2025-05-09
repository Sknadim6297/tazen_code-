<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Professional;
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

            if ($professional->status !== 'accepted') {
                Auth::guard('professional')->logout();

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Your application has not been accepted yet. Please wait for approval.',
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'status'  => 'success',
                'message' => 'You are successfully logged in!',
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
            'experience'            => 'required|string|max:255',
            'starting_price'        => 'required|string|max:255',
            'address'               => 'required|string|max:500',
            'education'             => 'required|string|max:255',
            'comments'              => 'nullable|string',
            'bio'                   => 'required|string|max:1000',
            'qualification_document' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'aadhaar_card'           => 'required|file|mimes:pdf,jpg,jpeg,png',
            'pan_card'               => 'required|file|mimes:pdf,jpg,jpeg,png',
            'profile_photo'          => 'required|file|mimes:jpg,jpeg,png',
            'gallery.*'              => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $professional = Professional::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
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
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'specialization'        => $request->specialization,
            'experience'            => $request->experience,
            'starting_price'        => $request->starting_price,
            'address'               => $request->address,
            'education'             => $request->education,
            'comments'              => $request->comments,
            'bio'                   => $request->bio,
            'qualification_document' => $qualificationPath,
            'aadhaar_card'          => $aadhaarPath,
            'pan_card'              => $panPath,
            'profile_photo'         => $photoPath,
            'gallery'               => json_encode($galleryPath),
        ]);

        Auth::guard('professional')->login($professional);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful. Admin approval is required before you can login.',
        ]);
    }



    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('professional')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
