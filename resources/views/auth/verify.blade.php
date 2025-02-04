<!-- resources/views/auth/verify.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Ensure proper scaling on different devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <!-- Favicon -->
    <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    <title>Verify Your Email Address</title>
    
    <!-- Google Fonts: Open Sans for text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> 
    <!-- Material Icons for any icons if needed -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    
    <!-- Embedded CSS for Verify Email Page -->
    <style>
        /* =========================================
           Custom CSS for Email Verification Page
        ========================================= */

        /* Reset and base styles */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
            color: #808080; /* Gray color for body text */
        }

        /* Body styles with background image */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative; /* Required for overlay layering */
            overflow: hidden;
            background-color: #f5f5f5;
        }

        /* Background image with reduced opacity */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/signin.png') }}") no-repeat center center; /* Ensure correct path */
            background-size: cover; /* Ensure it covers the entire viewport */
            background-attachment: fixed; /* Keeps the background fixed during scroll */
            opacity: 0.1; /* Adjust opacity for the background image (10% visibility) */
            z-index: 1; /* Layer it behind content */
        }

        /* Container styles */
        .container {
            position: relative;
            z-index: 2; /* Place content above the background image */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 400px; /* Consistent max-width with Login page */
            width: 90%; /* Responsive width */
            padding: 20px;
            box-sizing: border-box;
        }

        /* Heading styles */
        .container h1 {
            font-size: 2rem; /* Adjusted font size */
            font-weight: 700; /* Bold font */
            color: #333; /* Dark color for contrast */
            margin-bottom: 20px; /* Spacing below heading */
        }

        /* Illustration styles */
        .illustration {
            max-width: 50%; /* Further reduced size for better spacing */
            height: auto; /* Maintain aspect ratio */
            margin: 10px 0; /* Reduced spacing around illustration */
        }

        /* Success message styles */
        .success-message {
            font-size: 14px;
            color: #155724; /* Dark green for success messages */
            background-color: #d4edda; /* Light green background */
            border: 1px solid #c3e6cb; /* Green border */
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
            text-align: left;
        }

        /* Paragraph styles */
        .container p {
            font-size: 14px;
            color: #808080;
            margin-bottom: 10px;
        }

        /* Resend form styles */
        .auth-form {
            width: 100%;
            margin-top: 15px;
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 15px;
            width: 100%;
            position: relative; /* For positioning toggle icons if needed */
        }

        /* Floating label styles */
        .floating-label {
            position: relative;
            margin-top: 20px;
        }

        /* Form control styles */
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background: #fff; /* White background */
            transition: border 0.2s ease-in-out; /* Smooth border transition */
        }

        /* Label styles */
        .floating-label label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 14px;
            color: #808080; /* Gray color for default state */
            transition: all 0.2s ease-in-out;
            pointer-events: none; /* Prevent interaction */
        }

        /* Floating label animation */
        .form-control:focus + label,
        .form-control:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #666; /* Darker gray for the active state */
        }

        /* Change border color on focus */
        .form-control:focus {
            border-color: #666; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }

        /* Sign-In / Submit button styles */
        .btn-login {
            margin-top: 15px;
            margin-bottom: 20px;
            background-color: #666;
            border: none;
            color: white;
            padding: 0; /* Reset padding to use Flexbox for centering */
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px;
            width: 100%;
            max-width: 350px;
            height: 50px;
            font-family: "Open Sans", sans-serif;
            transition:
                transform 0.2s ease,
                background-color 0.2s ease;
            cursor: pointer;
            text-decoration: none; /* Remove underline for anchor tags */
            display: inline-block; /* Ensure proper padding and hover effects */
            text-align: center; /* Center text inside the button */
        }

        .btn-login:hover {
            background-color: #333; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow */
            color: white;
        }

        /* Small text styles for links */
        .back-to-login,
        .container p {
            font-size: small; /* Reduced font size for better balance */
            margin-top: 10px;
            color: #666;
            text-align: center;
        }

        /* Link styles */
        .back-to-login a,
        .forgotpassword {
            font-size: small;
            color: #666;
            text-decoration: none;
        }

        .back-to-login a:hover,
        .forgotpassword:hover {
            text-decoration: underline;
        }

        /* Align Forgot Password to the Right */
        .forgot-password-container {
            width: 100%; /* Ensure it takes full width of the container */
            text-align: right; /* Align text to the right */
            margin-top: -10px; /* Optional: Adjust spacing as needed */
        }

        /* Media queries for responsiveness */
        @media (max-width: 800px) {
            .container {
                padding: 15px; /* Adjust padding for mobile */
            }

            .container h1 {
                font-size: 1.8rem; /* Adjusted for smaller screens */
                display: block; /* Ensure h1 is visible on mobile */
            }

            /* Adjust illustration size on mobile */
            .illustration {
                max-width: 60%; /* Further reduced for better spacing */
                margin: 15px 0; /* Reduced spacing */
            }

            /* Move login button to the bottom by adding more margin below the form */
            .auth-form {
                max-width: 300px; /* Match Register Page's form width */
                margin-bottom: 20px; /* Additional spacing below the form */
            }

            .form-control {
                height: 45px; /* Adjust input height */
                padding: 8px; /* Adjust input padding */
                font-size: 12px; /* Font size */
            }

            .btn-login {
                width: 300px; /* Match Register Page's button width */
                height: 56px; /* Match Register Page's button height */
                font-size: 1.25rem; /* Match Register Page's button font size */
                margin-top: 30px; /* Increased margin-top to move button lower */
            }

            /* Adjust Forgot Password alignment for smaller screens if needed */
            .forgot-password-container {
                text-align: right;
            }
        }

        @media (min-width: 1025px) {
            .form-control {
                height: 45px; /* Adjust input height */
                padding: 8px; /* Adjust input padding */
                font-size: 14px; /* Font size */
            }

            .btn-login {
                font-size: 1.25rem;
                height: 50px;
                max-width: 350px;
            }

            .illustration {
                max-width: 50%; /* Maintain reduced size on large screens */
                height: auto; /* Maintain aspect ratio */
                margin: 20px 0; /* Spacing around illustration */
            }
        }
    </style>
</head>
<body>
    <div class="container"> <!-- Main container for centering content -->
        <h1>Verify Your Email Address</h1> <!-- Main heading -->
        <img src="{{ asset('images/signin.png') }}" alt="Email Verification Illustration" class="illustration"> <!-- Illustration for visual appeal -->
        <div class="content">
            @if (session('resent'))
                <div class="success-message">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="success-message">
                    {{ session('warning') }}
                </div>
            @endif

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p>{{ __('If you did not receive the email') }},</p>
            <form method="POST" action="{{ route('verification.resend') }}" class="auth-form">
                @csrf
                <button type="submit" class="btn-login">New Verification Link</button>
            </form>
        </div>

        <!-- Back to Login Link -->
        <p class="back-to-login">
            Remember your password? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>

    <!-- Optional: Add any additional scripts here -->
</body>
</html>
