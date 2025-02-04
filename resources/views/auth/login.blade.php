<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Ensure proper scaling on different devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

     <!-- Favicon -->
     <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    <title>Login</title>
    
    <!-- Google Fonts: Open Sans for text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> 
    <!-- Material Icons for password visibility toggle -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    
    <!-- Embedded CSS for Login Page -->
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
                display: flex;
                flex-direction: column; /* Arrange items vertically */
                justify-content: center; /* Center content vertically */
            }

            .left-section {
                align-items: center; /* Center items horizontally */
                text-align: left; /* Align text to the left */
            }

            .right-section {
                align-items: center;
                text-align: center;
            }

            .container h1 {
                font-size: 2rem; /* Smaller title for desktop */
                text-align: left; /* Align title to the left */
                margin-bottom: 20px; /* Increased spacing below heading */
            }

            .illustration {
                max-width: 100%; /* Ensure illustration fits within its section */
                height: auto; /* Maintain aspect ratio */
                margin: 20px 0; /* Spacing around illustration */
            }
        }

        /* Heading styles */
        .container h1 {
            font-size: 2.5rem; /* Consistent with Register Page on mobile */
            font-weight: 700; /* Bold font */
            color: #333; /* Dark color for contrast */
            margin-bottom: 10px; /* Spacing below heading */
        }

        /* Illustration styles */
        .illustration {
            max-width: 70%; /* Enlarge illustration on mobile */
            height: auto; /* Maintain aspect ratio */
            margin: 15px 0; /* Spacing around illustration */
        }

        /* Form styles */
        .auth-form {
            width: 100%; /* Full width */
            max-width: 300px; /* Match Register Page's form width */
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

        /* Change icon color on focus */
        .form-control:focus + label + .toggle-password {
            color: #666; /* Change icon color when input is focused */
        }

        /* Sign-In button styles */
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
            width: 300px; /* Match Register Page's button width */
            height: 56px; /* Consistent height with Register Page */
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

        /* Hover state for Sign-In button */
        .btn-login:hover {
            background-color: #333; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow */
            color: white;
        }

        /* Error message styles */
        .error-message {
            color: #dc3545; /* Bright red for errors */
            font-size: 12px; /* Font size */
            margin-top: 5px; /* Margin above error message */
        }

        /* Small text styles for sign-up and forgot password link */
        .container p {
            font-size: small; /* Reduced font size for better balance */
            margin-top: 10px;
            color: #666;
        }

        /* Forgot password link styles */
        .forgotpassword {
            font-size: small;
            color: #666;
            text-decoration: none;
        }

        .forgotpassword:hover {
            text-decoration: underline;
        }

        /* Align Forgot Password to the Right */
        .forgot-password-container {
            width: 100%; /* Ensure it takes full width of the container */
            text-align: right; /* Align text to the right */
            margin-top: -10px; /* Optional: Adjust spacing as needed */
        }

        /* Sign-Up link styles */
        .container p.signup-link {
            font-size: small; /* Maintain original size */
            margin-top: 10px;
            color: #333; /* Changed color only */
        }

        .container p.signup-link a {
            color: #333333; /* Changed link color only */
            cursor: pointer; /* Change cursor to pointer */
            text-decoration: none; /* Remove underline */
            font-weight: 600; /* Slightly bolder for emphasis */
        }

        .container p.signup-link a:hover {
            text-decoration: underline; /* Add underline on hover */
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

            /* Enlarge illustration on mobile */
            .illustration {
                max-width: 80%; /* Increased from 70% to 80% */
                margin: 20px 0; /* Increased spacing */
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

            /* Adjust Sign-Up link alignment for smaller screens if needed */
            .signup-link {
                text-align: center;
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
            <h1>Login</h1> <!-- Main heading -->
            <img src="{{ asset('images/signin.png') }}" alt="Login Illustration" class="illustration"> <!-- Illustration for visual appeal -->
        </div>
        
        <div class="right-section">
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="auth-form"> <!-- Login form -->
                @csrf <!-- CSRF token for security -->
                <div class="form-group floating-label"> <!-- Form group for email input -->
                    <input type="email" name="email" id="email" class="form-control" placeholder=" " required autofocus value="{{ old('email') }}"> <!-- Email input field -->
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
                <div class="forgot-password-container"> <!-- Forgot Password Link Container -->
                    <a href="{{ route('password.request') }}" class="forgotpassword">Forgot Password?</a> <!-- Forgot Password link -->
                </div>
                <button type="submit" class="btn-login">Login</button> <!-- Submit button for login -->
            </form>

            <!-- Sign-Up Link -->
            <p class="signup-link">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p> <!-- Link to sign-up page -->
        </div>
    </div>

    <!-- Password Visibility Toggle Script -->
    <script>
        // Password visibility toggle for password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off'; // Toggle icon
        });
    </script>
</body>
</html>
