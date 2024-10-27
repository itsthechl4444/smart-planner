<?php

// app/Http/Controllers/OnboardingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function showOnboarding()
    {
        return view('onboarding');
    }

    public function showWelcome()
    {
        return view('welcome');
    }
}
