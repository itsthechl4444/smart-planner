<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <img src="{{ asset('images/Illustration.png') }}" alt="Reset Password Illustration" class="illustration">
        <div class="content">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="Email">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group mt-4">
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group mt-4">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-4 flex items-center justify-end">
                    <button type="submit" class="submit-button">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
