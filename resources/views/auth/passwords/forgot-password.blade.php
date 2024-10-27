<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

        /* Content styles */
        .content {
            width: 100%; /* Full width */
            margin-top: 15px; /* Spacing above content */
        }

        /* Description styles */
        .description {
            font-size: 14px; /* Font size for description */
            color: #666; /* Text color for description */
            margin-bottom: 15px; /* Spacing below description */
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 15px; /* Spacing between form groups */
            text-align: left; /* Align text to the left */
            width: 100%; /* Full width */
            position: relative; /* Position for the label */
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
        .form-label {
            position: absolute;
            top: 12px;
            left: 10px;
            font-size: 14px;
            color: #808080; /* Gray color for default state */
            pointer-events: none; /* Prevent interaction */
            transition: all 0.2s ease-in-out; /* Smooth transition for floating */
        }

        /* Floating label animation */
        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #666; /* Darker gray for the active state */
        }

        /* Change border color on focus */
        .form-control:focus {
            border-color: #666; /* Change border color on focus */
        }

        /* Error message styles */
        .error-message {
            color: red; /* Red text for errors */
            font-size: 12px; /* Font size */
            margin-top: 5px; /* Margin above error message */
        }

        /* Submit button styles */
        .submit-button {
            font-family: 'Open Sans', sans-serif; /* Font family for button */
            background-color: #666; /* Button background color */
            border: none; /* No border */
            color: white; /* Text color */
            padding: 10px 20px; /* Padding inside button */
            font-size: 16px; /* Font size */
            font-weight: bold; /* Bold text */
            border-radius: 5px; /* Rounded corners */
            width: 100%; /* Full width */
            height: 56px; /* Fixed height */
            cursor: pointer; /* Pointer cursor on hover */
        }

        /* Hover state for Submit button */
        .submit-button:hover {
            background-color: #555; /* Darker background on hover */
        }

        /* Small text styles for login link */
        .login {
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

            .submit-button {
                font-size: 18px; /* Adjust button font size */
                height: 48px; /* Adjust button height */
            }
        }
    </style>
</head>
<body>
    <div class="container"> <!-- Main container for centering content -->
        <h1>Forgot Password</h1>
        <img src="{{ asset('images/Illustration.png') }}" alt="Forgot Password Illustration" class="illustration">
        <div class="content">
            <p class="description">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

            <!-- Session Status -->
            <div class="session-status">
                @if (session('status'))
                    <div class="status-message">{{ session('status') }}</div>
                @endif
            </div>

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="forgot-password-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder=" " required autofocus>
                    <label for="email" class="form-label">Email:</label>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">Email Password Reset Link</button>
            </form>

            <p class="login">Remembered your password? <a href="{{ route('login') }}">Login</a></p> <!-- Link to login page -->
        </div>
    </div>
</body>
</html>
