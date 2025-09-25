<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActiveSession;
use App\Models\OtpVerification;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $otpService;
    
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    
    // Show login form
    public function showLoginForm()
    {
        return view('frontend.login.login');
    }

    // Handle login request with device check
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Check if credentials are valid without actually logging in
        if (Auth::guard('user')->validate($credentials)) {
            // Get user
            $user = User::where('email', $request->email)->first();
            
            // Check if user is already logged in on another device
            $activeSessions = ActiveSession::where('user_id', $user->id)->count();
            if ($activeSessions > 0 && !$request->has('force_login')) {
                // Return response indicating user needs to confirm logout from other devices
                return response()->json([
                    'status' => 'confirm_logout',
                    'message' => 'You are currently logged in on another device. Would you like to log out from all other devices?',
                ]);
            }
            
            // Perform the login first - this creates a session
            // BUT FIRST: Preserve booking data before session regeneration
            $bookingData = session('booking_data');
            $selectedServiceName = session('selected_service_name');
            
            Auth::guard('user')->login($user, $remember);
            $request->session()->regenerate();
            
            // Restore booking data after session regeneration
            if ($bookingData) {
                session(['booking_data' => $bookingData]);
            }
            if ($selectedServiceName) {
                session(['selected_service_name' => $selectedServiceName]);
            }
            
            // Get the new session ID
            $newSessionId = Session::getId();
            
            // IMPORTANT: Only after successful login and getting new session ID,
            // invalidate other sessions
            if ($request->has('force_login')) {
                $this->invalidateOtherSessions($user->id, $newSessionId);
            }
            
            // Register this session
            $this->registerUserSession($user->id, $request);

            // Determine redirect URL priority:
            // 1. Explicit redirect parameter from request
            // 2. Laravel's intended URL (from middleware)
            // 3. If user has booking data, go to booking page
            // 4. Default to dashboard
            $redirectUrl = $request->input('redirect');
            
            if (!$redirectUrl) {
                $redirectUrl = session()->pull('url.intended');
            }
            
            if (!$redirectUrl) {
                if (session()->has('booking_data')) {
                    $redirectUrl = route('user.booking');
                } else {
                    $redirectUrl = route('user.dashboard');
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'You are successfully logged in!',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }
    
    /**
     * Register the user's current session
     */
    private function registerUserSession($userId, Request $request)
    {
        // Get current session ID
        $sessionId = Session::getId();
        
        // Get device information
        $agent = new Agent();
        $browser = $agent->browser();
        $platform = $agent->platform();
        $deviceInfo = "$browser on $platform";
        
        // Create a new session record (don't use updateOrCreate here)
        $session = ActiveSession::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'device_info' => $deviceInfo,
            'ip_address' => $request->ip(),
            'last_active_at' => now(),
        ]);
    }

    /**
     * Invalidate all other sessions for a user EXCEPT the current session
     */
    private function invalidateOtherSessions($userId, $currentSessionId)
    {
        // Use a transaction for consistency
        DB::beginTransaction();
        try {
            // 1. Find all sessions other than the current one
            $otherSessions = ActiveSession::where('user_id', $userId)
                ->where('session_id', '!=', $currentSessionId)
                ->get();
            
            foreach ($otherSessions as $session) {

                DB::table('sessions')
                    ->where('id', $session->session_id)
                    ->delete();
                
                // Delete the active session record
                $session->delete();
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    
    /**
     * Force login endpoint - handles the confirmation from SweetAlert
     */
    public function forceLogin(Request $request)
    {
        $request->merge(['force_login' => true]);
        return $this->login($request);
    }

    public function showRegisterForm()
    {
        return view('frontend.login.register');
    }

    /**
     * Send OTP verification code
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'This email address is already registered.'
            ], 422);
        }

        try {
            // Generate and send OTP
            $otp = $this->otpService->generate($request->email);
            
            return response()->json([
                'status' => 'success',
                'message' => 'OTP has been sent to your email address.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OTP: ' . $e->getMessage(), [
                'email' => $request->email
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send verification code. Please try again later.'
            ], 500);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6', // Changed to string|size:6 to handle leading zeros
        ]);

        $result = $this->otpService->verify($request->email, $request->otp);

        if ($result['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
            'error_type' => $result['error_type'] ?? 'unknown'
        ], 422);
    }
    
    /**
     * Register a new user after OTP verification
     */
    public function register(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'otp'        => 'required|string|size:6', // Changed to string|size:6
        ]);

        // Verify OTP code
        $verification = $this->otpService->verify($request->email, $request->otp);
        if (!$verification['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $verification['message'],
                'error_type' => $verification['error_type'] ?? 'unknown'
            ], 422);
        }

        try {
            // Create user
            $user = User::create([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Return success response with redirect to login
            return response()->json([
                'status'  => 'success',
                'message' => 'Your account has been created. Please login.',
                'redirect_url' => route('login'),
                'registered_email' => $request->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage(), [
                'email' => $request->email
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create your account. Please try again later.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('user')->user();
        
        // Remove this session from active_sessions if the user is logged in
        if ($user) {
            ActiveSession::where('user_id', $user->id)
                ->where('session_id', Session::getId())
                ->delete();
        }
        
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
