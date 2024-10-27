<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        // Validate the form data
        $request->validate([
            'current_password'      => ['required', 'current_password'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Update the password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.index')->with('status', 'Password updated successfully!');
    }
}
