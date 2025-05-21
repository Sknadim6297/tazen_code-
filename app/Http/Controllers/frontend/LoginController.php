<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('frontend.login.login');
    }

    // Handle login request
 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->filled('remember');

    if (Auth::guard('user')->attempt($credentials, $remember)) {
        $request->session()->regenerate();

        $redirectUrl = $request->input('redirect', route('user.dashboard'));

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




    public function showRegisterForm()
    {
        return view('frontend.login.register');
    }

    public function register(Request $request)
{
    // Validation
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|min:6|confirmed',
    ]);

    // Create user
    $user = User::create([
        'name'     => $request->first_name . ' ' . $request->last_name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Log in the user
    Auth::login($user);

    // Return success response
    return response()->json([
        'status'  => 'success',
        'message' => 'Registration successful, you are now logged in.',
    ]);
}

    

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
