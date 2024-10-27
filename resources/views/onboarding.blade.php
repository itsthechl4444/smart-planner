<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Setting the viewport for responsiveness across mobile, tablet, and desktop -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Smart Planner - Onboarding</title>
    
    <!-- Bootstrap CSS for styling and responsive layout -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Google Fonts: Open Sans for text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Linking to custom stylesheet for onboarding page -->
    <link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
</head>
<body>
    <!-- Main container with full view height and centered content both vertically and horizontally -->
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
        
        <!-- Fixed header section with app title and subtitle -->
        <div class="fixed-header">
            <h1 class="display-4">Smart Planner</h1>
            <p class="lead">Take charge of your tasks and finances</p>
        </div>
        
        <!-- Bootstrap carousel for onboarding illustrations and text -->
        <div id="onboardingCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                
                <!-- First carousel slide (active) with image and quote -->
                <div class="carousel-item active">
                    <div class="onboarding">
                        <img src="{{ asset('images/illustration1.png') }}" alt="Illustration 1" class="img-fluid">
                        <p>"Take control of your tasks and finances, all in one place!"</p>
                    </div>
                </div>
                
                <!-- Second carousel slide -->
                <div class="carousel-item">
                    <div class="onboarding">
                        <img src="{{ asset('images/illustration2.png') }}" alt="Illustration 2" class="img-fluid">
                        <p>"Stay organized and productive with Smart Planner!"</p>
                    </div>
                </div>
                
                <!-- Third carousel slide -->
                <div class="carousel-item">
                    <div class="onboarding">
                        <img src="{{ asset('images/illustration3.png') }}" alt="Illustration 3" class="img-fluid">
                        <p>"Achieve your goals effortlessly with Smart Planner!"</p>
                    </div>
                </div>
            </div>
            
            <!-- Carousel indicators (dots) to navigate between slides -->
            <ol class="carousel-indicators custom-indicators">
                <li data-target="#onboardingCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#onboardingCarousel" data-slide-to="1"></li>
                <li data-target="#onboardingCarousel" data-slide-to="2"></li>
            </ol>
        </div>
        
        <!-- "Get Started" button linking to the welcome page -->
        <a href="{{ route('welcome') }}"><button class="btn btn-get-started" type="button">Get Started</button></a>
    </div>

    <!-- jQuery for Bootstrap functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <!-- Popper.js for tooltips and positioning in Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    
    <!-- Bootstrap JS for enabling carousel and other components -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
