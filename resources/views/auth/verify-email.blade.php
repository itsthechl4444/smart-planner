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
    <!-- Material Icons for any icon usage -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    
    <!-- Embedded CSS for Verification Page -->
    <style>
        /* =========================================
           Custom CSS for Email Verification Page
        ========================================= */

        /* Reset margins and paddings, ensure full height */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Ensure html and body cover the full viewport height */
        html, body {
            height: 100vh; /* Full viewport height */
            width: 100%;
            font-family: "Open Sans", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative; /* Required for layering content */
            overflow: hidden; /* Hide any overflow */
            background-color: #f5f5f5; /* Base background color */
            color: #808080; /* Gray color for body text */
        }

        /* Container styles */
        .container {
            position: relative;
            z-index: 1; /* Ensure content is above any potential overlays */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 400px; /* Consistent max-width with Login and Forgot Password pages */
            width: 90%; /* Responsive width */
            padding: 20px;
            box-sizing: border-box;
            background-color: #ffffff; /* Optional: Add a white background to the container */
            border-radius: 10px; /* Optional: Rounded corners for a modern look */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Optional: Subtle shadow for depth */
        }

        /* Heading styles */
        .container h1 {
            font-size: 2.5rem; /* Consistent with Login Page */
            font-weight: 700; /* Bold font */
            color: #333; /* Dark color for contrast */
            margin-bottom: 10px; /* Spacing below heading */
        }

        /* Illustration styles */
        .illustration {
            max-width: 80%; /* Responsive size */
            height: auto;
            margin: 15px 0; /* Spacing around illustration */
        }

        /* Content area styles */
        .content {
            width: 100%;
            max-width: 400px;
            margin-top: 15px;
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
            text-align: left;
        }

        /* Paragraph styles */
        .content p {
            font-size: 14px;
            color: #808080;
            margin-bottom: 10px;
        }

        /* Resend form styles */
        .auth-form {
            width: 100%;
            margin-top: 15px;
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
                padding: 15px;
            }

            .container h1 {
                font-size: 1.8rem; /* Adjusted for smaller screens */
            }

            .illustration {
                max-width: 80%; /* Increased from 70% to 80% */
                margin: 20px 0; /* Increased spacing */
            }

            .auth-form {
                max-width: 300px; /* Match Login Page's form width */
                margin-bottom: 20px; /* Additional spacing below the form */
            }

            .btn-login {
                width: 300px; /* Match Login Page's button width */
                height: 56px; /* Match Login Page's button height */
                font-size: 1.25rem; /* Match Login Page's button font size */
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
</body>
</html>
