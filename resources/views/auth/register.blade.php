<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensure proper scaling on different devices -->
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- Material Icons -->
    <style>
        /* Body styles */
        html,
        body {
            height: 100%; /* Full height for centering */
            margin: 0;
            padding: 0;
            background-color: #F5F5F5; /* Background color */
            color: #808080; /* Text color */
            font-family: 'Open Sans', sans-serif; /* Font family */
            display: flex; /* Flexbox for centering */
            justify-content: center;
            align-items: center;
            text-align: center; /* Center text alignment */
        }

        /* Container styles */
        .container {
            display: flex;
            flex-direction: column; /* Vertical alignment */
            justify-content: center;
            align-items: center;
            height: 100%; /* Full height */
            max-width: 400px; /* Max width for small devices */
            padding: 20px; /* Padding for spacing */
            box-sizing: border-box; /* Include padding in width calculations */
        }

        /* Heading styles */
        .container h1 {
            font-size: 30px; /* Heading size */
            font-weight: 700; /* Bold font */
            color: #333; /* Dark color for contrast */
            margin-bottom: 10px; /* Spacing below heading */
        }

        /* Illustration styles */
        .illustration {
            max-width: 50%; /* Responsive width */
            height: auto; /* Auto height for maintaining aspect ratio */
            margin: 15px 0; /* Spacing around illustration */
        }

        /* Form styles */
        .register-form {
            width: 100%; /* Full width */
            margin-top: 15px; /* Spacing above the form */
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 15px; /* Spacing between form groups */
            text-align: left; /* Align text to the left */
            width: 100%; /* Full width */
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
            font-family: 'Open Sans', sans-serif; /* Font family for button */
            margin-top: 15px; /* Spacing above button */
            background-color: #666; /* Button background color */
            border: none; /* No border */
            color: white; /* Text color */
            padding: 10px 20px; /* Padding inside button */
            font-size: 20px; /* Font size */
            font-weight: bold; /* Bold text */
            border-radius: 10px; /* Rounded corners */
            text-transform: none; /* Default text transformation */
            width: 100%; /* Full width */
            height: 56px; /* Fixed height */
        }

        /* Hover state for Sign-Up button */
        .btn-signup:hover {
            background-color: #555; /* Darker background on hover */
        }

        /* Error message styles */
        .error-message {
            color: red; /* Red text for errors */
            font-size: 12px; /* Font size */
            margin-top: 5px; /* Margin above error message */
        }

        /* Small text styles for login link */
        .container p.login {
            font-size: 12px; /* Font size for small text */
            margin-top: 15px; /* Spacing above */
        }

        /* Media query for mobile devices */
        @media (max-width: 800px) {
            .container {
                padding: 15px; /* Adjust padding for mobile */
            }

            .container h1 {
                font-size: 22px; /* Smaller heading size on mobile */
            }

            .form-control {
                height: 45px; /* Adjust input height */
                padding: 8px; /* Adjust input padding */
                font-size: 12px; /* Font size */
            }

            .btn-signup {
                font-size: 18px; /* Adjust button font size */
                height: 48px; /* Adjust button height */
            }
        }
    </style>
</head>
<body>
    <div class="container"> <!-- Main container for centering content -->
        <h1>Create a new account</h1> <!-- Main heading -->
        <img src="{{ asset('images/Illustration3.png') }}" alt="Register Illustration" class="illustration"> <!-- Illustration for visual appeal -->
        
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
