<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Show the password reset request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.forgot-password'); // Change to your view path
    }

    /**
     * Send a password reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        // Send the password reset link
        $response = Password::sendResetLink(
            $request->only('email')
        );

        // Check the response and return the appropriate message
        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }
}
