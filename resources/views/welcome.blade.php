<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Setting the viewport for responsiveness across mobile, tablet, and desktop -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    
    <title>Welcome</title>

    <!-- Bootstrap 5 CSS for styling and responsive layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

    <!-- Google Fonts: Open Sans for text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Embedded CSS for welcome page -->
    <style>
        /* Body styles */
        body {
            position: relative;
            background-color: #f5f5f5;
            color: #808080;
            font-family: "Open Sans", sans-serif;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }
        
        /* Background image with reduced opacity */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("/images/signin.png") no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: 1;
        }
        
        /* Content container to appear above the layers */
        .container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            height: 100vh;
            padding: 40px 20px;
            box-sizing: border-box;
        }
        
        /* Top section (heading) */
        .top-section {
            margin-top: 20px;
        }
        
        /* Heading styles */
        .container h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        /* Floating animation keyframes */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Illustration styles */
        .illustration {
            max-width: 100%;
            height: auto;
            max-height: 400px;
            margin: 20px 0;
            flex-grow: 1;
            animation: float 6s ease-in-out infinite;
        }
        
        /* Sign Up/Get Started button styles */
        .btn-signup {
            background-color: #666;
            border: none;
            color: white;
            padding: 0;
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px;
            width: 300px;
            height: 56px;
            font-family: "Open Sans", sans-serif;
            transition: transform 0.2s ease, background-color 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .btn-signup:hover {
            background-color: #333;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        /* Login paragraph styles */
        .container p.login {
            font-size: 1rem;
            margin-top: 10px;
            color: #666;
            margin-bottom: 20px;
        }
        
        /* Styles for the Login link */
        .text-link {
            color: #333333;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }
        
        .text-link:hover {
            text-decoration: underline;
        }
        
        /* Media queries for responsiveness */
        @media (max-width: 767px) {
            .container h1 {
                font-size: 1.8rem;
            }

            .illustration {
                max-height: 300px;
            }

            .btn-signup {
                width: 300px;
                height: 56px;
                font-size: 1.25rem;
            }
        }
        
        @media (min-width: 768px) and (max-width: 1024px) {
            .container h1 {
                font-size: 2.2rem;
            }
        
            .illustration {
                max-height: 350px;
            }

            .btn-signup {
                width: 300px;
                height: 56px;
                font-size: 1.15rem;
            }
        }
        
        @media (min-width: 1025px) {
            .container h1 {
                font-size: 3rem; /* Enlarged logo/title size */
            }
        
            .illustration {
                max-height: 350px; /* Minimized a bit from 400px */
            }

            .btn-signup {
                width: 300px;
                height: 56px;
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-between align-items-center text-center">
        <!-- Top section with heading -->
        <div class="top-section">
            <h1>Welcome to Smart Planner!</h1>
        </div>
        
        <!-- Illustration image -->
        <img src="{{ asset('images/signin.png') }}" alt="Illustration representing Smart Planner features" class="illustration" loading="lazy">
        
        <!-- Bottom section with buttons and login prompt -->
        <div class="bottom-section">
            <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
            <p class="login">Already have an account? <a href="{{ route('login') }}" class="text-link">Login</a></p>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
