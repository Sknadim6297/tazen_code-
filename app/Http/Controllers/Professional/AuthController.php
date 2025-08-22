<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showForgotForm()
    {
        return view('professional.login.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('professionals')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request)
    {
        return view('professional.login.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('professionals')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($professional, $password) {
                $professional->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($professional));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('professional.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
