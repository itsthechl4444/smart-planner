<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link rel="icon" href="/images/LogoPNG.png" type="image/png">

    <title>Smart Planner - Onboarding</title>
    
    <!-- Bootstrap 5 CSS (Minified) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    
    <!-- Google Fonts: Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome (Minified) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    
    <!-- AOS (Animate On Scroll) CSS (Minified) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    
    <!-- Embedded CSS -->
    <style>
        /* General Styles */
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #ffffff;
            color: #333333;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            background: url("/images/done.png") no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-align: center;
            padding: 0 20px;
            overflow: hidden;
        }
        
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            width: 100%;
            padding: 20px;
            animation: fadeIn 2s ease-in-out;
        }
        
        /* Logo Styling with Floating Animation */
        .hero-content .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px auto; /* Center the logo and add spacing below */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
            animation: float 4s ease-in-out infinite;
        }
        
        .hero-content .logo img {
            width: 100%;
            height: auto;
        }
        
        .hero-content .logo:hover {
            transform: scale(1.05);
        }
        
        /* Floating Animation for Logo */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            animation: slideInDown 1s ease-out;
        }
        
        .hero-content p.lead {
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 40px;
            animation: fadeIn 2s ease-in-out 0.5s;
        }
        
        .btn-get-started {
            background-color: #f5f5f5;
            border: none;
            color: #333333;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            animation: bounceIn 1s ease-out 1s;
            position: relative;
            z-index: 2;
        }
        
        .btn-get-started:hover {
            background-color: #e0e0e0;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        /* Carousel Section */
        .carousel-container {
            background-color: #f9f9f9;
            padding: 60px 20px;
        }
        
        /* Carousel Customizations */
        .carousel-item {
            text-align: center;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        
        .carousel-item.active {
            opacity: 1;
        }
        
        .carousel-item img {
            max-width: 40%;
            height: auto;
            margin-bottom: 20px;
            animation: zoomIn 0.4s ease-out;
        }
        
        .carousel-item p {
            font-size: 1.1rem;
            font-weight: 500;
            color: #555555;
            margin-top: 10px;
            animation: fadeInUp 0.4s ease-out;
        }
        
        /* Carousel Indicators */
        .carousel-indicators.custom-indicators {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            list-style: none;
            padding: 0;
        }
        
        .carousel-indicators.custom-indicators li {
            width: 12px;
            height: 12px;
            background-color: #cccccc;
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .carousel-indicators.custom-indicators .active {
            background-color: #888888;
        }
        
        .carousel-inner {
            padding-bottom: 40px;
        }
        
        /* Feature Section */
        .features-section {
            background-color: #f0f0f0;
            padding: 60px 20px;
        }
        
        .features-section .feature {
            text-align: center;
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .features-section .feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .features-section .feature i {
            font-size: 2.5rem;
            color: #808080;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }
        
        .features-section .feature:hover i {
            color: #a9a9a9;
        }
        
        .features-section .feature h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333333;
        }
        
        .features-section .feature p {
            font-size: 1rem;
            color: #666666;
            margin-bottom: 0;
            flex-grow: 1;
        }
        
        /* Footer Section */
        .footer {
            padding: 20px;
            background-color: #f1f1f1;
            text-align: center;
            font-size: 0.9rem;
            color: #666666;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
            80% { transform: translateY(-2px); }
        }
        
        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .hero {
                text-align: center;
            }
            
            .hero-content {
                max-width: 100%;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p.lead {
                font-size: 1rem;
            }
            
            .btn-get-started {
                font-size: 1rem;
                padding: 12px 25px;
            }
            
            .carousel-item img {
                max-width: 70%;
            }
            
            .carousel-item p {
                font-size: 1rem;
                margin-top: 15px;
            }
            
            .carousel-indicators.custom-indicators {
                margin-top: 30px;
            }
            
            .carousel-inner {
                padding-bottom: 30px;
            }
            
            .features-section .feature {
                margin-bottom: 20px;
            }
            
            .features-section .feature i {
                font-size: 2rem;
            }
            
            /* Adjust logo size on smaller screens */
            .hero-content .logo {
                width: 80px;
                height: 80px;
                margin-bottom: 15px;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .carousel-item img {
                max-width: 60%;
            }
            
            .carousel-indicators.custom-indicators {
                margin-top: 30px;
            }
            
            .carousel-inner {
                padding-bottom: 30px;
            }
            
            .features-section .feature {
                margin-bottom: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content" data-aos="fade-up">
            <!-- Logo Placement -->
            <div class="logo">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/LogoPNG.png') }}" alt="Smart Planner Logo">
                </a>
            </div>

            <h1 class="display-3">Welcome to Smart Planner</h1>
            <p class="lead">Take charge of your tasks and finances with ease</p>
            
            <a href="{{ route('welcome') }}" class="btn btn-get-started" data-aos="zoom-in">
                <i class="fas fa-rocket"></i> Get Started
            </a>
        </div>
    </section>
    
    <!-- Carousel Section -->
    <section class="carousel-container">
        <div id="onboardingCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1500">
            <div class="carousel-inner">
                
                <!-- First carousel slide (active) -->
                <div class="carousel-item active">
                    <div class="onboarding">
                        <img src="{{ asset('images/done.png') }}" alt="Manage your tasks efficiently with Smart Planner" class="img-fluid" loading="lazy">
                        <p>"Take control of your tasks and finances, all in one place!"</p>
                    </div>
                </div>
                
                <!-- Second carousel slide -->
                <div class="carousel-item">
                    <div class="onboarding">
                        <img src="{{ asset('images/grow.png') }}" alt="Stay organized and productive with Smart Planner" class="img-fluid" loading="lazy">
                        <p>"Stay organized and productive with Smart Planner!"</p>
                    </div>
                </div>
                
                <!-- Third carousel slide -->
                <div class="carousel-item">
                    <div class="onboarding">
                        <img src="{{ asset('images/todo.png') }}" alt="Achieve your goals effortlessly with Smart Planner" class="img-fluid" loading="lazy">
                        <p>"Achieve your goals effortlessly with Smart Planner!"</p>
                    </div>
                </div>
            </div>
            
            <!-- Carousel Indicators -->
            <ol class="carousel-indicators custom-indicators">
                <li data-bs-target="#onboardingCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></li>
                <li data-bs-target="#onboardingCarousel" data-bs-slide-to="1" aria-label="Slide 2"></li>
                <li data-bs-target="#onboardingCarousel" data-bs-slide-to="2" aria-label="Slide 3"></li>
            </ol>
            
            <!-- Carousel Controls (Optional for Better Navigation) -->
            <button class="carousel-control-prev" type="button" data-bs-target="#onboardingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#onboardingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Our Features</h2>
            <div class="row g-5">
                <!-- Feature 1: Create & Manage Tasks -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-tasks"></i>
                        <h3>Create & Manage Tasks</h3>
                        <p>Allows users to create, categorize, and prioritize tasks efficiently.</p>
                    </div>
                </div>
                <!-- Feature 2: Create Labels -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-tags"></i>
                        <h3>Create Labels</h3>
                        <p>Organize your tasks with customizable labels for better clarity.</p>
                    </div>
                </div>
                <!-- Feature 3: Manage Projects & Collaborate -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-project-diagram"></i>
                        <h3>Manage Projects & Collaborate</h3>
                        <p>Manage projects seamlessly and collaborate with team members effectively.</p>
                    </div>
                </div>
                <!-- Feature 4: Track Finances -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-dollar-sign"></i>
                        <h3>Track Finances</h3>
                        <p>Monitor your finances by managing accounts, recording income and expenses, and setting financial goals.</p>
                    </div>
                </div>
                <!-- Sub-Feature 4.1: Manage Accounts -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-wallet"></i>
                        <h3>Manage Accounts</h3>
                        <p>Keep track of all your financial accounts in one place.</p>
                    </div>
                </div>
                <!-- Sub-Feature 4.2: Record Income & Expenses -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-chart-pie"></i>
                        <h3>Record Income & Expenses</h3>
                        <p>Log your income and expenses to stay on top of your financial health.</p>
                    </div>
                </div>
                <!-- Sub-Feature 4.3: Manage Debts -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-credit-card"></i>
                        <h3>Manage Debts</h3>
                        <p>Track and manage your debts effectively to achieve financial freedom.</p>
                    </div>
                </div>
                <!-- Sub-Feature 4.4: Set Financial Goals -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-bullseye"></i>
                        <h3>Set Financial Goals</h3>
                        <p>Define and pursue your financial objectives with clear targets.</p>
                    </div>
                </div>
                <!-- Sub-Feature 4.5: Create Budgets -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-chart-line"></i>
                        <h3>Create Budgets</h3>
                        <p>Establish budgets to manage your spending and save more effectively.</p>
                    </div>
                </div>
                <!-- Feature 5: Calendar & Notifications -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Calendar & Notifications</h3>
                        <p>View your personal calendar with built-in reminders and receive alerts for tasks and financial deadlines.</p>
                    </div>
                </div>
                <!-- Feature 6: Time & Finance Tips -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-lightbulb"></i>
                        <h3>Time & Finance Tips</h3>
                        <p>Access valuable tips and best practices for financial literacy and productivity.</p>
                    </div>
                </div>
                <!-- Feature 7: Detailed Reports -->
                <div class="col-md-4 d-flex">
                    <div class="feature" data-aos="fade-up">
                        <i class="fas fa-chart-bar"></i>
                        <h3>Detailed Reports</h3>
                        <p>Generate comprehensive reports on task completion, task distribution, expense summary, income overview, and budget progress.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer Section -->
        <footer class="footer">
            &copy; 2024 Smart Planner. All rights reserved.
        </footer>

        <!-- Bootstrap 5 JS Bundle (Minified, includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous" defer></script>
        
        <!-- AOS (Animate On Scroll) JS (Minified) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha384-..." crossorigin="anonymous" defer></script>
        
        <!-- Initialize Carousel and AOS -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Bootstrap Carousel
                var onboardingCarousel = document.querySelector('#onboardingCarousel');
                var carousel = new bootstrap.Carousel(onboardingCarousel, {
                    interval: 1500, // 1.5 seconds interval
                    pause: 'hover',  // Pause on hover
                    ride: 'carousel' // Start automatically
                });

                // Initialize AOS
                AOS.init({
                    duration: 800, // 0.8 seconds animation duration
                    once: true     // Animation occurs only once
                });
            });
        </script>
</body>
</html>
