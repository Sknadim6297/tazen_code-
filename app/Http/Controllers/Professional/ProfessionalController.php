<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
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

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:professionals,email',
            'password'              => 'required|min:6|confirmed',
        ]);

        $professional = Professional::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('professional')->login($professional);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful, you are now logged in.',
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
