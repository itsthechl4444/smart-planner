<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
            margin-bottom: 20px; /* Spacing below heading */
        }

        /* Card styles */
        .card {
            background-color: #fff; /* White background for card */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
            padding: 20px; /* Padding inside card */
            width: 100%; /* Full width of the container */
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 15px; /* Spacing between form groups */
            text-align: left; /* Align text to the left */
            width: 100%; /* Full width */
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
        <h1>Reset Password</h1>
        <div class="card"> <!-- Card for form content -->
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="error-message" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="error-message" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <button type="submit" class="submit-button">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
