<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <img src="{{ asset('images/Illustration.png') }}" alt="Forgot Password Illustration" class="illustration">
        <div class="content">
            <p class="description">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <!-- Session Status -->
            <div class="session-status">
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="forgot-password-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                    <label for="email" class="form-label">Email:</label>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">Email Password Reset Link</button>
            </form>
        </div>
    </div>
</body>
</html>
