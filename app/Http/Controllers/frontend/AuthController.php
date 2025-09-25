<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\Service;

class AuthController extends Controller
{
    public function showForgotForm()
    {

        $services = Service::latest()->get();
        return view('frontend.login.forgot-password', compact('services'));
    }
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');
        $services = Service::latest()->get();

        return view('frontend.login.reset-password', compact('token', 'email','services'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:4',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password reset successful.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
