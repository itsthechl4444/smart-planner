<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Planner - Welcome</title>
    <!-- Link to the custom stylesheet for the welcome page -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <!-- Link to the Google Fonts Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Main container that holds the entire content -->
    <div class="container">
        <!-- Main heading of the welcome page -->
        <h1>Welcome to Smart Planner!</h1>
        <!-- Subtitle or lead text of the application -->
        <p class="lead">Take charge of your tasks and finances</p>
        <!-- Illustration image placed in the center for visual appeal -->
        <img src="{{ asset('images/Illustration.png') }}" alt="Welcome Illustration" class="illustration">
        <!-- Additional message or quote encouraging users -->
        <p class="text-muted mb-4">Take control of your tasks and finances, all in one place!</p>
        <!-- Sign Up button that directs to the registration page -->
        <a href="{{ route('register') }}"><button class="btn btn-signup" type="button">Sign Up</button></a>
        <!-- Login link for returning users -->
        <p class="login">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>

    <!-- JavaScript for any necessary interactions or Bootstrap dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
