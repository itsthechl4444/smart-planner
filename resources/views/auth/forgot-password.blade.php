<!-- resources/views/auth/forgot-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    
    <!-- Link to Forgot Password CSS -->
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <img src="{{ asset('images/signin.png') }}" alt="Forgot Password Illustration" class="illustration">

        <div class="content">
            <p class="description">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>

            <!-- Session Status -->
            <div class="session-status">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <div class="floating-label">
                        <input type="email" name="email" id="email" class="form-control" placeholder=" " required autofocus value="{{ old('email') }}">
                        <label for="email">Email</label>
                    </div>
                    <!-- Field-specific Error Message -->
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">Email Password Link</button>
            </form>
        </div>

        <!-- Back to Login Link -->
        <p class="back-to-login">
            Remember your password? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</body>
</html>
