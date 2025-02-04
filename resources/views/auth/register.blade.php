<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Ensure proper scaling on different devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

     <!-- Favicon -->
     <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    <title>Register</title>
    
    <!-- Google Fonts: Open Sans for text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> 
    <!-- Material Icons for password visibility toggle -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    
    <!-- Embedded CSS for Register Page -->
    <style>
        /* Body styles */
        body {
            position: relative; /* Required for overlay layering */
            background-color: #F5F5F5; /* Base background color */
            color: #808080; /* Text color */
            font-family: 'Open Sans', sans-serif; /* Font family */
            height: 100vh; /* Full viewport height */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            overflow: hidden; /* Hide overflow */
            display: flex; /* Flexbox for centering */
            justify-content: center;
            align-items: center;
            text-align: center; /* Center text alignment */
        }

        /* Background image with reduced opacity */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("/images/signin.png") no-repeat center center; /* Add the background image */
            background-size: cover; /* Ensure it covers the entire viewport */
            opacity: 0.1; /* Adjust opacity for the background image (10% visibility) */
            z-index: 1; /* Layer it behind content */
        }

        /* Container styles */
        .container {
            position: relative; /* Position relative to place content above background */
            z-index: 2; /* Place content above the background image */
            display: flex;
            flex-direction: column; /* Default to column for mobile */
            justify-content: center;
            align-items: center;
            height: 100%; /* Full height */
            max-width: 400px; /* Max width for the container on mobile */
            width: 100%; /* Full width */
            padding: 20px; /* Padding for spacing */
            box-sizing: border-box; /* Include padding in width calculations */
        }

        /* Desktop layout adjustments */
        @media (min-width: 1025px) {
            .container {
                flex-direction: row; /* Change to row for desktop */
                max-width: 800px; /* Increased max width for desktop */
                justify-content: space-between; /* Space between left and right sections */
                padding: 40px; /* Increased padding for desktop */
            }

            .left-section, .right-section {
                width: 48%; /* Split the container into two sections */
            }

            .left-section {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left; /* Align text to the left */
            }

            .right-section {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .container h1 {
                font-size: 2rem; /* Smaller title for desktop */
                text-align: left; /* Align title to the left */
            }

            .illustration {
                max-width: 100%; /* Ensure illustration fits within its section */
                height: auto; /* Maintain aspect ratio */
                margin: 20px 0; /* Spacing around illustration */
                animation: float 6s ease-in-out infinite; /* Add animation here */
            }
        }

        /* Heading styles */
        .container h1 {
            font-size: 2.5rem; /* Consistent with Welcome Page on mobile */
            font-weight: 700; /* Bold font */
            color: #333; /* Dark color for contrast */
            margin-bottom: 10px; /* Spacing below heading */
        }

        /* Floating animation keyframes */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* Illustration styles */
        .illustration {
            max-width: 50%; /* Responsive width */
            height: auto; /* Maintain aspect ratio */
            margin: 15px 0; /* Spacing around illustration */
            animation: float 6s ease-in-out infinite; /* Add animation here */
        }

        /* Form styles */
        .register-form {
            width: 100%; /* Full width */
            max-width: 300px; /* Match Welcome Page's button width */
            margin-top: 15px; /* Spacing above the form */
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 15px; /* Spacing between form groups */
            text-align: left; /* Align text to the left */
            width: 100%; /* Full width */
            position: relative; /* For positioning toggle icons */
        }

        /* Floating label styles */
        .floating-label {
            position: relative;
            margin-top: 20px;
        }

        /* Form control styles */
        .form-control {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding inside inputs */
            font-size: 14px; /* Font size for inputs */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #ccc; /* Border style */
            box-sizing: border-box; /* Include padding in width calculations */
            background: #fff; /* Change background to white */
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
        }

        /* Toggle password icon */
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 12px; /* Adjusted for better alignment */
            cursor: pointer;
            font-size: 18px; /* Icon size */
            color: #808080; /* Icon color */
        }

        /* Sign-Up button styles */
        .btn-signup {
            margin-top: 15px;
            margin-bottom: 20px;
            background-color: #666;
            border: none;
            color: white;
            padding: 0; /* Reset padding to use Flexbox for centering */
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px;
            width: 300px; /* Match Welcome Page's button width */
            height: 56px; /* Consistent height with Welcome Page */
            font-family: "Open Sans", sans-serif;
            transition:
                transform 0.2s ease,
                background-color 0.2s ease;
            cursor: pointer;
            text-decoration: none; /* Remove underline for anchor tags */
            display: flex; /* Use Flexbox to center content */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            text-align: center; /* Center text inside the button */
        }

        /* Hover state for Sign-Up button */
        .btn-signup:hover {
            background-color: #333; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow */
            color: white;
        }

        /* Error message styles */
        .error-message {
            color: red; /* Red text for errors */
            font-size: 12px; /* Font size */
            margin-top: 5px; /* Margin above error message */
        }

        /* Small text styles for login link */
        .container p.login {
            font-size: small; /* Maintain original size */
            margin-top: 10px;
            color: #333; /* Changed color only */
        }

        /* Styles for the Login link */
        .container p.login a {
            color: #333333; /* Changed link color only */
            cursor: pointer; /* Change cursor to pointer */
            text-decoration: none; /* Remove underline */
            font-weight: 600; /* Slightly bolder for emphasis */
        }

        .container p.login a:hover {
            text-decoration: underline; /* Add underline on hover */
        }

        /* Media queries for responsiveness */
        @media (max-width: 800px) {
            .container {
                padding: 15px; /* Adjust padding for mobile */
            }

            .container h1 {
                font-size: 1.8rem; /* Adjusted for smaller screens */
            }

            /* Ensure illustration size remains unchanged */
            /* .illustration {
                max-height: 300px; /* Do not change illustration size */ 
            /* } */

            .register-form {
                max-width: 300px; /* Match Welcome Page's form width */
            }

            .form-control {
                height: 45px; /* Adjust input height */
                padding: 8px; /* Adjust input padding */
                font-size: 12px; /* Font size */
            }

            .btn-signup {
                width: 300px; /* Match Welcome Page's button width */
                height: 56px; /* Match Welcome Page's button height */
                font-size: 1.25rem; /* Match Welcome Page's button font size */
            }

            .illustration {
                max-width: 50%; /* Responsive width */
                height: auto; /* Maintain aspect ratio */
                margin: 15px 0; /* Spacing around illustration */
                animation: float 6s ease-in-out infinite; /* Add animation here */
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
        <!-- Desktop layout: Left and Right sections -->
        <div class="left-section">
            <h1>Sign Up</h1> <!-- Main heading -->
            <img src="{{ asset('images/signin.png') }}" alt="Register Illustration" class="illustration"> <!-- Illustration for visual appeal -->
        </div>
        
        <div class="right-section">
            <form method="POST" action="{{ route('register') }}" class="register-form"> <!-- Registration form -->
                @csrf <!-- CSRF token for security -->
                <div class="form-group floating-label"> <!-- Form group for name input -->
                    <input type="text" name="name" id="name" class="form-control" placeholder=" " required autofocus> <!-- Name input field -->
                    <label for="name">Name</label> <!-- Floating label for name -->
                    @error('name')
                        <span class="error-message">{{ $message }}</span> <!-- Display name error message -->
                    @enderror
                </div>
                <div class="form-group floating-label"> <!-- Form group for email input -->
                    <input type="email" name="email" id="email" class="form-control" placeholder=" " required> <!-- Email input field -->
                    <label for="email">Email</label> <!-- Floating label for email -->
                    @error('email')
                        <span class="error-message">{{ $message }}</span> <!-- Display email error message -->
                    @enderror
                </div>
                <div class="form-group floating-label"> <!-- Form group for password input -->
                    <input type="password" name="password" id="password" class="form-control" placeholder=" " required> <!-- Password input field -->
                    <label for="password">Password</label> <!-- Floating label for password -->
                    <span class="material-icons toggle-password" id="togglePassword">visibility</span> <!-- Eye icon for password -->
                    @error('password')
                        <span class="error-message">{{ $message }}</span> <!-- Display password error message -->
                    @enderror
                </div>
                <div class="form-group floating-label"> <!-- Form group for password confirmation -->
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder=" " required> <!-- Confirm Password input field -->
                    <label for="password_confirmation">Confirm Password</label> <!-- Floating label for confirm password -->
                    <span class="material-icons toggle-password" id="toggleConfirmPassword">visibility</span> <!-- Eye icon for confirm password -->
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span> <!-- Display confirm password error message -->
                    @enderror
                </div>
                <button type="submit" class="btn-signup">Sign Up</button> <!-- Submit button for signup -->
            </form>

            <p class="login">Already have an account? <a href="{{ route('login') }}">Login</a></p> <!-- Link to login page -->
        </div>
    </div>

    <script>
        // Password visibility toggle for password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off'; // Toggle icon
        });

        // Password visibility toggle for confirm password
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off'; // Toggle icon
        });
    </script>
</body>
</html>
