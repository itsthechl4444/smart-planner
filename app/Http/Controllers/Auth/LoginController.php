<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\CustomVerifyEmail; // Import the CustomVerifyEmail notification

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            Log::info('User authenticated: ' . Auth::user()->email);
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if the user's email is verified
            if (!$user->hasVerifiedEmail()) {
                Log::warning('Unverified user attempted to log in: ' . $user->email);

                // Send a new verification email
                $user->notify(new CustomVerifyEmail());

                // Log out the unverified user
                Auth::logout();

                // Redirect to the verification notice page with a success message
                return redirect()->route('verification.notice')
                    ->with('resent', true)
                    ->with('warning', 'A new verification link has been sent to your email address.');
            }

            Log::info('User logged in successfully: ' . $user->email);
            return redirect()->intended('dashboard');
        }

        Log::warning('Failed login attempt for email: ' . $request->input('email'));
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
