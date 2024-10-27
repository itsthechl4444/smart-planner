<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('dashboard');
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'email' => 'These credentials do not match our records.', // General error message
            'password' => 'The provided password is incorrect.' // More specific error message for password
        ])->withInput($request->only('email')); // Retain the email input
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('welcome');
    }
}
