<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('dashboard.auth.reset-password');
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('dashboard.auth.reset-password-form')->with(['token' => $token, 'email' => $request->email]);
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', 'We have e-mailed your password reset link!')
            : back()->withErrors(['email' => 'Unable to send reset link. Please try again.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset!')
            : back()->withErrors(['email' => 'There was an error resetting your password.']);
    }
}
