<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; // Redirect to dashboard after verification

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['verify', 'show']);
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Override the default verify method to redirect to dashboard with session message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = \App\Models\User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/dashboard')->with('message', 'Email already verified.');
        }

        $user->markEmailAsVerified();

        event(new \Illuminate\Auth\Events\Verified($user));

        // Optionally, log the user in automatically
        Auth::login($user);

        return redirect('/dashboard')->with('verified', true);
    }

    /**
     * Show the email verification notice.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('auth.verify');
    }
}
