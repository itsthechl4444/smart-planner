<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the profile management page.
     */
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information (e.g., name).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the form data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Add other fields as necessary
        ]);

        // Update the user's name (and other fields if added)
        $user->update([
            'name' => $request->name,
            // Add other fields as necessary
        ]);

        // Log the profile update
        Log::info('User Profile Updated', ['user_id' => $user->id, 'name' => $user->name]);

        return redirect()->route('profile.index')->with('status', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Log that the method has been called
        Log::info('updatePassword method called for user ID: ' . $user->id);

        // Validate the form data
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Adjust password policies as needed
        ]);

        // Log validation passed
        Log::info('Validation passed for password update for user ID: ' . $user->id);

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Log password update
        Log::info('Password updated for user ID: ' . $user->id);

        return redirect()->route('profile.index')->with('status', 'Password updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Log that the destroy method has been called
        Log::info('destroy method called for user ID: ' . $user->id);

        // Validate the password
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Log validation passed
        Log::info('Password validation passed for account deletion for user ID: ' . $user->id);

        // Log out the user
        Auth::logout();

        // Delete the user's account
        $user->delete();

        // Log account deletion
        Log::info('User account deleted for user ID: ' . $user->id);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Your account has been deleted successfully.');
    }
}
