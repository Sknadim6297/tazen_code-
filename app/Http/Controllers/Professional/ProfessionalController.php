<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\Professional;
use App\Models\ProfessionalRejection;
use App\Models\Profile;
use App\Models\Service; 
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfessionalController extends Controller
{
    use ImageUploadTraits;
    // Show login form
    public function showLoginForm()
    {
        return view('professional.login.login');
    }

    public function registerForm()
    {
        $services = Service::where('status', 'active')->get();
        return view('professional.login.register', compact('services'));
    }

    public function store(Request $request)
    {
        // Custom validation with better error messages
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

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
        // Check if email has been verified
        if (!Session::get('email_verified')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Please verify your email address before proceeding.',
            ], 403);
        }

        // Verify the email used for registration is the same as the verified one
        if (Session::get('registration_email') !== $request->email) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email address does not match the verified email.',
            ], 403);
        }
        
        // Base validation rules - GST fields are optional
        $validationRules = [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:professionals,email',
            'password'              => 'required|min:6|confirmed',
            'phone'                 => 'required|string|max:20',
            'specialization'        => 'required|string|max:255',
            'experience'            => 'required|string|in:0-2,2-4,4-6,6-8,8-10,10+',
            'starting_price'        => 'required|string|max:100', // Allow range values like "1000-2000"
            'address'               => 'required|string|max:500',
            'education'             => 'required|string|max:255',
            'education2'            => 'nullable|string|max:255',
            'comments'              => 'nullable|string',
            'id_proof_document'     => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240',
            'qualification_document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240',
            'profile_photo'         => 'nullable|file|mimes:jpg,jpeg,png,bmp,gif,tiff,webp|max:5120',
            'gallery.*'             => 'nullable|file|mimes:jpg,jpeg,png,bmp,gif,tiff,webp|max:5120',
        ];

        // Custom error messages for better user experience
        $customMessages = [
            'id_proof_document.required' => 'ID proof document (Aadhaar Card or PAN Card) is required.',
            'id_proof_document.max' => 'ID proof document file size should not exceed 10MB.',
            'profile_photo.mimes' => 'Profile photo must be an image file (JPG, PNG, GIF, WebP).',
            'qualification_document.required' => 'Qualification document is required.',
            'qualification_document.max' => 'Qualification document file size should not exceed 10MB.',
        ];

        // If GST number is provided, make all GST fields mandatory
        if ($request->filled('gst_number')) {
            $validationRules['gst_number'] = 'required|string|max:15';
            $validationRules['gst_address'] = 'required|string|max:1000';
            $validationRules['state_code'] = 'required|string|max:10';
            $validationRules['state_name'] = 'required|string|max:100';
            $validationRules['gst_certificate'] = 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240';
        } else {
            // If no GST number, make all GST fields optional
            $validationRules['gst_number'] = 'nullable|string|max:15';
            $validationRules['gst_address'] = 'nullable|string|max:1000';
            $validationRules['state_code'] = 'nullable|string|max:10';
            $validationRules['state_name'] = 'nullable|string|max:100';
            $validationRules['gst_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png';
        }

        $request->validate($validationRules, $customMessages);

        try {
            $professional = Professional::create([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password),
                'status'   => 'pending',
            ]);

        $qualificationPath = $this->uploadImage($request, 'qualification_document', 'uploads/professionals/documents');
        
        // Handle single ID proof document upload
        $idProofPath = $request->hasFile('id_proof_document') 
            ? $this->uploadImage($request, 'id_proof_document', 'uploads/professionals/identity')
            : null;            // Profile photo is optional
            $photoPath = $request->hasFile('profile_photo') 
                ? $this->uploadImage($request, 'profile_photo', 'uploads/professionals/photo')
                : null;
                
            // Gallery is optional
            $galleryPath = $request->hasFile('gallery') 
                ? $this->uploadMultipleImage($request, 'gallery', 'uploads/professionals/gallery')
                : null;
            
            // GST certificate is only uploaded if GST details are provided
            $gstCertificatePath = $request->hasFile('gst_certificate') 
                ? $this->uploadImage($request, 'gst_certificate', 'uploads/professionals/documents')
                : null;

            Profile::create([
                'professional_id'       => $professional->id,
                'name'                  => $request->first_name . ' ' . $request->last_name,
                'phone'                 => $request->phone,
                'email'                 => $request->email,
                'specialization'        => $request->specialization,
                'experience'            => $request->experience,
                'starting_price'        => $request->starting_price,
                'address'               => $request->address,
                'education'             => $request->education,
                'education2'            => $request->education2,
                'comments'              => $request->comments,
                'gst_number'            => $request->gst_number ?? null,
                'gst_address'           => $request->gst_address ?? null,
                'state_code'            => $request->state_code ?? null,
                'state_name'            => $request->state_name ?? null,
                'gst_certificate'       => $gstCertificatePath,
                'qualification_document' => $qualificationPath,
                'id_proof_document'     => $idProofPath,
                'photo'                 => $photoPath,
                'gallery'               => $galleryPath ? json_encode($galleryPath) : null,
            ]);

            // Clear OTP session data after successful registration
            Session::forget(['registration_otp', 'otp_expiry', 'email_verified', 'registration_email']);

            Auth::guard('professional')->login($professional);

            return response()->json([
                'status'  => 'success',
                'message' => 'Registration successful! Your application is now under admin review. You will be notified once approved.',
                'redirect_url' => route('professional.pending.view'),
            ]);

        } catch (\Exception $e) {
            Log::error('Professional registration error: ' . $e->getMessage(), [
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed due to a technical issue. Please try again or contact support if the problem persists.',
            ], 500);
        }
    }


    public function rejectedPage()
    {
        // Fetch the latest rejection record for the logged-in professional
        $RejectedUser = ProfessionalRejection::with('professional', 'profile')
            ->where('professional_id', Auth::guard('professional')->id())
            ->latest('created_at')
            ->first();
        $reason = $RejectedUser ? $RejectedUser->reason : null;
        
        // Get active services for the dropdown
        $services = Service::where('status', 'active')->get();
        
        // Add experience and city options
        $experiences = ['0-2', '2-4', '4-6', '6-8', '8-10', '10+'];
        $cities = ['Mumbai', 'Kolkata', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Ahmedabad', 'Surat', 'Jaipur'];
        
        return view('professional.login.rejected', compact('RejectedUser', 'reason', 'services', 'experiences', 'cities'));
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
        // For rejected users, validation is more flexible - only validate what they're updating
        $validationRules = [
            'name'                   => 'nullable|string|max:255',
            // Email is read-only and not included in validation
            'phone'                  => 'nullable|string|min:6|max:15|regex:/^\d+$/',
            'specialization'         => 'nullable|string|max:255',
            'experience'             => 'nullable|string|max:255',
            'starting_price'         => 'nullable|string|max:100',
            'address'                => 'nullable|string|max:500',
            'education'              => 'nullable|string|max:255',
            'education2'             => 'nullable|string|max:255',
            'qualification_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240',
            'id_proof_document'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240',
            'profile_photo'          => 'nullable|file|mimes:jpg,jpeg,png,bmp,gif,tiff,webp|max:5120',
            'gallery.*'              => 'nullable|file|mimes:jpg,jpeg,png,bmp,gif,tiff,webp|max:5120',
        ];

        $customMessages = [
            'phone.min' => 'Phone number must be at least 6 digits.',
            'phone.max' => 'Phone number cannot exceed 15 digits.',
            'phone.regex' => 'Phone number can only contain digits.',
            'starting_price.max' => 'Starting price cannot exceed 100 characters.',
            'qualification_document.max' => 'Qualification document file size should not exceed 10MB.',
            'id_proof_document.max' => 'ID proof document file size should not exceed 10MB.',
            'profile_photo.max' => 'Profile photo file size should not exceed 5MB.',
            'gallery.*.max' => 'Gallery images should not exceed 5MB each.',
        ];

        // If GST number is provided, make GST fields required
        if ($request->filled('gst_number')) {
            $validationRules['gst_number'] = 'required|string|min:10|max:15';
            $validationRules['gst_address'] = 'required|string|max:1000';
            $validationRules['state_code'] = 'required|string|max:10';
            $validationRules['state_name'] = 'required|string|max:100';
            $validationRules['gst_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240';
            
            $customMessages['gst_number.required'] = 'GST number is required when providing GST details.';
            $customMessages['gst_number.min'] = 'GST number must be at least 10 characters.';
            $customMessages['gst_number.max'] = 'GST number cannot exceed 15 characters.';
            $customMessages['gst_address.required'] = 'GST address is required when providing GST details.';
            $customMessages['state_code.required'] = 'GST state code is required when providing GST details.';
            $customMessages['state_name.required'] = 'GST state name is required when providing GST details.';
            $customMessages['gst_certificate.max'] = 'GST certificate file size should not exceed 10MB.';
        } else {
            // If no GST number, make all GST fields optional
            $validationRules['gst_number'] = 'nullable|string|min:10|max:15';
            $validationRules['gst_address'] = 'nullable|string|max:1000';
            $validationRules['state_code'] = 'nullable|string|max:10';
            $validationRules['state_name'] = 'nullable|string|max:100';
            $validationRules['gst_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt,bmp,gif,tiff,webp|max:10240';
            
            $customMessages['gst_number.min'] = 'GST number must be at least 10 characters.';
            $customMessages['gst_number.max'] = 'GST number cannot exceed 15 characters.';
            $customMessages['gst_certificate.max'] = 'GST certificate file size should not exceed 5MB.';
        }

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please fix the validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $professional = Professional::findOrFail(Auth::guard('professional')->id());
        $profile = Profile::where('professional_id', $professional->id)->first();

        // If no profile exists, create a new one
        if (!$profile) {
            $profile = new Profile();
            $profile->professional_id = $professional->id;
            $profile->name = $professional->name;
            $profile->email = $professional->email;
            $profile->phone = $professional->phone;
            $profile->save();
        }

        // Update professional data only if provided
        $professionalUpdates = [];
        if ($request->filled('name')) {
            $professionalUpdates['name'] = $request->name;
        }
        if ($request->filled('phone')) {
            $professionalUpdates['phone'] = $request->phone;
        }
        
        // Always update status to pending when resubmitting
        $professionalUpdates['status'] = 'pending';
        
        $professional->update($professionalUpdates);

        // Handle file uploads - only update if new files are uploaded
        $qualificationPath = $request->hasFile('qualification_document')
            ? $this->uploadImage($request, 'qualification_document', 'uploads/professionals/documents')
            : ($profile->qualification_document ?? null);

        $idProofPath = $request->hasFile('id_proof_document')
            ? $this->uploadImage($request, 'id_proof_document', 'uploads/professionals/identity')
            : ($profile->id_proof_document ?? null);

        $photoPath = $request->hasFile('profile_photo')
            ? $this->uploadImage($request, 'profile_photo', 'uploads/professionals/photo')
            : ($profile->photo ?? null);

        $galleryPath = $request->hasFile('gallery')
            ? json_encode($this->uploadMultipleImage($request, 'gallery', 'uploads/professionals/gallery'))
            : ($profile->gallery ?? null);
            
        // Handle GST certificate
        $gstCertificatePath = $request->hasFile('gst_certificate')
            ? $this->uploadImage($request, 'gst_certificate', 'uploads/professionals/documents')
            : ($profile->gst_certificate ?? null);

        // Prepare profile updates - only update fields that have values
        $profileUpdates = [
            'qualification_document' => $qualificationPath,
            'id_proof_document'      => $idProofPath,
            'photo'                  => $photoPath,
            'gallery'                => $galleryPath,
            'gst_certificate'        => $gstCertificatePath,
        ];

        // Add text fields only if they have values (bio removed)
        $textFields = ['name', 'specialization', 'experience', 'starting_price', 'address', 'education', 'education2', 'gst_number', 'gst_address', 'state_code', 'state_name'];
        
        foreach ($textFields as $field) {
            if ($request->filled($field)) {
                $profileUpdates[$field] = $request->$field;
            }
        }

        $profile->update($profileUpdates);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully. It is now under admin review.',
        ]);
    }

    /**
     * Generate a 6-digit OTP
     */
    private function generateOTP()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send OTP for verification
     */
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:professionals,email',
        ]);

        $otp = $this->generateOTP();
        
        // Store OTP in session
        Session::put('registration_otp', $otp);
        Session::put('registration_email', $request->email);
        Session::put('otp_expiry', now()->addMinutes(10));
        
        // Send OTP email
        try {
            Mail::to($request->email)->send(new OtpVerificationMail($otp));
            return response()->json([
                'status' => 'success',
                'message' => 'Verification code sent to your email address.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send verification code. Please try again.'
            ], 500);
        }
    }

    /**
     * Verify OTP entered by user
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $storedOTP = Session::get('registration_otp');
        $otpExpiry = Session::get('otp_expiry');
        
        if (!$storedOTP || !$otpExpiry) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired or was never generated. Please request a new code.'
            ], 400);
        }

        if (now()->isAfter($otpExpiry)) {
            // Clear expired OTP data
            Session::forget(['registration_otp', 'otp_expiry']);
            
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new code.'
            ], 400);
        }

        if ($request->otp === $storedOTP) {
            Session::put('email_verified', true);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Email verified successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid verification code. Please try again.'
        ], 400);
    }
}
