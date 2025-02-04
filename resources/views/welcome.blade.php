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
            position: relative; /* Required for overlay layering */
            background-color: #f5f5f5; /* Base background color */
            color: #808080;
            font-family: "Open Sans", sans-serif;
            height: 100vh;
            overflow: hidden;
            margin: 0; /* Remove default margin */
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
        
        /* Content container to appear above the layers */
        .container {
            position: relative;
            z-index: 2; /* Place content above the background image */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribute space between elements */
            align-items: center;
            text-align: center;
            height: 100vh;
            padding: 40px 20px; /* Added padding for better spacing */
            box-sizing: border-box; /* Include padding in height calculations */
        }
        
        /* Top section (heading) */
        .top-section {
            margin-top: 20px;
        }
        
        /* Heading styles */
        .container h1 {
            font-size: 2.5rem; /* Consistent with Onboarding Page */
            font-weight: 700; /* Consistent with Onboarding Page */
            color: #333; /* Changed to match Onboarding Page */
            margin-bottom: 10px;
        }
        
        /* Floating animation keyframes */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* Illustration styles */
        .illustration {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            max-height: 400px; /* Increased max-height for better visibility on mobile */
            margin: 20px 0;
            flex-grow: 1; /* Allow illustration to take available space */
            animation: float 6s ease-in-out infinite; /* Add animation here */
        }
        
        /* Sign Up/Get Started button styles */
        .btn-signup {
            background-color: #666;
            border: none;
            color: white;
            padding: 0; /* Reset padding to use Flexbox for centering */
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px;
            width: 300px; /* Consistent width with Onboarding Page */
            height: 56px; /* Consistent height with Onboarding Page */
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
            margin-bottom: 20px; /* Add space below the button */
        }
        
        /* Hover state for Sign Up/Get Started button */
        .btn-signup:hover {
            background-color: #333; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow */
            color: white;
        }
        
        /* Login paragraph styles */
        .container p.login {
            font-size: 1rem; /* Increased font size for better readability */
            margin-top: 10px;
            color: #666;
            margin-bottom: 20px; /* Add space below the login prompt */
        }
        
        /* Styles for the Login link */
        .text-link {
            color: #333333; /* Consistent with button hover color */
            cursor: pointer; /* Change cursor to pointer */
            text-decoration: none; /* Remove underline */
            font-weight: 600; /* Slightly bolder for emphasis */
        }
        
        .text-link:hover {
            text-decoration: underline; /* Add underline on hover */
        }
        
        /* Media queries for responsiveness */
        @media (max-width: 767px) {
            /* Mobile styles */
            .container h1 {
                font-size: 1.8rem; /* Adjusted for smaller screens */
            }

            .illustration {
                max-height: 300px; /* Enlarged from 200px to 300px */
            }

            .btn-signup {
                width: 300px; /* Match onboarding button width */
                height: 56px; /* Match onboarding button height */
                font-size: 1.25rem; /* Match onboarding button font size */
            }
        }
        
        @media (min-width: 768px) and (max-width: 1024px) {
            /* Tablet styles */
            .container h1 {
                font-size: 2.2rem; /* Adjusted for tablet screens */
            }
        
            .illustration {
                max-height: 350px; /* Adjust height for tablet screens */
            }

            .btn-signup {
                width: 300px; /* Consistent width */
                height: 56px; /* Consistent height */
                font-size: 1.15rem; /* Slightly adjusted font size */
            }
        }
        
        @media (min-width: 1025px) {
            /* Desktop styles */
            .container h1 {
                font-size: 2.5rem; /* Maintain consistent size on large screens */
            }
        
            .illustration {
                max-height: 400px; /* Maintain reasonable size on large screens */
            }

            .btn-signup {
                width: 300px; /* Consistent width */
                height: 56px; /* Consistent height */
                font-size: 1.25rem; /* Consistent font size */
            }
        }
    </style>
</head>
<body>
    <!-- Main container with full view height and spaced content -->
    <div class="container d-flex flex-column justify-content-between align-items-center text-center">
        <!-- Top section with heading -->
        <div class="top-section">
            <h1>Welcome to Smart Planner!</h1>
        </div>
        
        <!-- Illustration image -->
        <img src="{{ asset('images/signin.png') }}" alt="Illustration representing Smart Planner features" class="illustration" loading="lazy">
        
        <!-- Bottom section with buttons and login prompt -->
        <div class="bottom-section">
            <!-- "Sign Up" button linking to the register page -->
            <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
            
            <!-- Login prompt -->
            <p class="login">Already have an account? <a href="{{ route('login') }}" class="text-link">Login</a></p>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
