<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <img src="{{ asset('images/Illustration3.png') }}" alt="Login Illustration" class="illustration">

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <div class="floating-label">
                    <input type="email" name="email" id="email" class="form-control" placeholder=" " required autofocus value="{{ old('email') }}">
                    <label for="email">Email</label>
                </div>
                <span class="error-message">{{ $errors->first('email') }}</span> <!-- Display email error message -->
            </div>

            <div class="form-group">
                <div class="floating-label">
                    <input type="password" name="password" id="password" class="form-control" placeholder=" " required>
                    <label for="password">Password</label>
                    <span class="material-icons toggle-password" id="togglePassword">visibility</span>
                </div>
                <span class="error-message">{{ $errors->first('password') }}</span> <!-- Display password error message -->
            </div>

            <p><a href="{{ route('password.request') }}" class="forgotpassword">Forgot Password?</a></p>
            <button type="submit" class="btn-login">Login</button>
        </form>

        <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
    </div>

    <script>
        // Password visibility toggle
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
