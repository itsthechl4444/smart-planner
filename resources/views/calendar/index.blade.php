<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 1. Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Planner Calendar</title>

    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 2. External Stylesheets -->
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- 3. Custom CSS -->
    <style>
        /* Theme Colors */
        :root {
            --primary-color: #6c757d;       /* Gray */
            --secondary-color: #adb5bd;     /* Light Gray */
            --light-color: #f8f9fa;         /* Very Light Gray */
            --dark-color: #343a40;          /* Darker Gray */
            --background-color: #f9f9f9;    /* Light Gray Background */
            --button-color: #adb5bd;        /* Light Gray for buttons */
            --button-hover-color: #ced4da;  /* Lighter Gray on hover */
            --list-event-bg: #f8f9fa;       /* Light Gray for list view events */
            --list-event-text: #495057;     /* Dark Gray text for list view events */
            --text-gray: #808080;           /* Gray for day numbers and week titles */
            --no-underline: none;           /* Remove underlines */
            --event-hover-bg: #495057;      /* Darker background on event hover */
            --transition-speed: 0.3s;       /* Transition duration */
        }

        /* Global Styles */
        body {
            font-family: "Open Sans", sans-serif;
            margin: 0;
            background: var(--background-color) !important;
            color: #808080;
        }

        /* Header Styles */
        .header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #f5f5f5;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 60px;
        }

        .menu-icon {
            font-size: 24px;
            cursor: pointer;
            color: #333;
            transition: transform var(--transition-speed);
        }

        .menu-icon:hover {
            transform: rotate(90deg);
        }

        .title {
            font-size: 20px;
            font-weight: 500;
            flex: 1;
            text-align: center;
            color: #333;
        }

        /* Calendar Container */
        .calendar-container {
            padding: 80px 20px 20px;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Section Divider */
        .section-divider {
            margin: 40px 0;
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #ccc, transparent);
        }

        /* Illustration Image */
        .illustration-image {
            display: block;
            margin: 0 auto 20px auto; /* Center horizontally with bottom margin */
            max-width: 30%; /* Adjust as needed */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            animation: float 5s ease-in-out infinite;
            transition: transform var(--transition-speed);
        }

        .illustration-image:hover {
            transform: scale(1.05);
        }

        /* Animation for the illustration */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Organized Container for Filter and Cards */
        .filter-and-cards-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            /* White container styles */
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Cards Section */
        .cards-section {
            padding: 20px 0;
        }

        .cards-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the cards horizontally */
            width: 100%;
        }

        .card {
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px; /* Adjust the max-width as needed */
            height: 150px; /* Fixed height for consistency */
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            position: relative;
            background-color: #ffffff; /* White background */
            border: 1px solid #ddd;    /* Light border */
            border-radius: 8px;        /* Rounded corners */
            overflow: hidden;          /* Prevent content overflow */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* "Nothing here" Message Styles */
        .no-data-message {
            text-align: center;
            color: #6c757d;
            font-size: 1.2rem;
            margin-top: 40px;
        }

        /* =========================================
           FullCalendar Customizations
        ========================================= */
        /* Toolbar Title */
        .fc .fc-toolbar-title {
            color: var(--secondary-color);
            font-size: 1.5rem;
        }

        /* Adjust FullCalendar button colors to lighter gray */
        .fc .fc-button {
            background-color: var(--button-color) !important;
            border-color: var(--button-color) !important;
            color: #333 !important; /* Dark text for readability */
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 4px;
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
        }

        .fc .fc-button:hover,
        .fc .fc-button:focus {
            background-color: var(--button-hover-color) !important;
            border-color: var(--button-hover-color) !important;
        }

        /* Today's date background */
        .fc .fc-day-today {
            background-color: #e9ecef;
        }

        /* Change day numbers and week titles to gray and remove underlines */
        .fc .fc-col-header-cell-cushion,
        .fc .fc-daygrid-day-number {
            color: var(--text-gray) !important; /* Gray color */
            text-decoration: var(--no-underline) !important; /* Remove underlines */
            transition: color var(--transition-speed);
        }

        /* Remove underlines on hover */
        .fc .fc-col-header-cell-cushion:hover,
        .fc .fc-daygrid-day-number:hover {
            text-decoration: var(--no-underline) !important;
            color: var(--primary-color) !important; /* Slight color change on hover */
        }

        /* Adjust the day cell height and limit events per day */
        .fc .fc-daygrid-day-frame {
            height: 130px !important; /* Fixed height with !important to override defaults */
            overflow: hidden;
            position: relative;
        }

        .fc .fc-daygrid-day-events {
            max-height: 100px; /* Adjust based on max events you want to display */
            overflow: hidden;
        }

        /* Style the "more" link */
        .fc .fc-more-link {
            position: absolute;
            bottom: 2px;
            left: 2px;
            color: var(--secondary-color) !important; /* Gray color */
            font-size: 0.8rem;
            text-decoration: none;
            cursor: pointer;
            background-color: transparent;
            padding: 2px 4px;
            border-radius: 4px;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .fc .fc-more-link:hover {
            text-decoration: underline;
            background-color: rgba(173, 181, 189, 0.2); /* Light gray background on hover */
            color: var(--primary-color) !important;
        }

        /* Event Styles */
        .fc-event {
            background-color: var(--dark-color);
            border: none;
            color: #ffffff;
            font-size: 0.85rem;
            padding: 2px 4px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            border-radius: 2px;
            transition: background-color var(--transition-speed);
        }

        .fc-event:hover {
            background-color: var(--event-hover-bg);
        }

        /* Ensure events stack vertically without overlapping */
        .fc-daygrid-event {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* =========================================
           Responsive Styles
        ========================================= */
        @media (max-width: 992px) {
            .illustration-image {
                max-width: 35%; /* Further reduced size for medium screens */
            }
        }

        @media (max-width: 768px) {
            /* Adjust calendar container padding for tablets and below */
            .calendar-container {
                padding: 70px 10px 10px;
            }

            .illustration-image {
                max-width: 30%; /* Further reduced size for smaller screens */
            }
        }

        @media (max-width: 576px) {
            .calendar-container {
                padding: 70px 10px 10px;
            }

            /* Adjust toolbar elements to fit in one line */
            .fc .fc-toolbar.fc-header-toolbar {
                flex-wrap: nowrap;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 0 5px;
            }

            /* Adjust the toolbar chunks */
            .fc .fc-toolbar-chunk {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Adjust the title font size */
            .fc .fc-toolbar-title {
                font-size: 1rem;
                margin: 0 5px;
            }

            /* Adjust button sizes */
            .fc .fc-button {
                padding: 4px 6px;
                font-size: 0.8rem;
                margin: 0 2px;
            }

            /* Adjust event font size */
            .fc-event {
                font-size: 0.75rem;
                padding: 1px 2px;
            }

            /* Adjust illustration image on small screens */
            .illustration-image {
                max-width: 50%; /* Increase size for better visibility */
            }
        }

        @media (max-width: 400px) {
            /* Further adjustments for very small screens */
            .fc .fc-toolbar.fc-header-toolbar {
                padding: 0 2px;
            }

            .fc .fc-toolbar-title {
                font-size: 0.9rem;
                margin: 0 3px;
            }

            .fc .fc-button {
                padding: 3px 5px;
                font-size: 0.7rem;
                margin: 0 1px;
            }

            /* Adjust event font size */
            .fc-event {
                font-size: 0.65rem;
            }

            /* Ensure illustration remains visible */
            .illustration-image {
                max-width: 40%; /* Adjusted to fit smaller screens */
            }
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1001; /* Above other elements */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #ffffff;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
            animation: fadeIn var(--transition-speed);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            transition: color var(--transition-speed);
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Loading Spinner */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Error Message */
        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        /* Card Link Styles */
        .card a.stretched-link {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            text-decoration: none;
            pointer-events: auto; /* Ensure the link is clickable */
        }

        /* =========================================
           10. Bottom Navbar Styles
        ========================================= */

        /* Base styles for Bottom Navbar (Visible on both Desktop and Mobile) */
        .bottom-navbar {
            position: fixed;
            bottom: 20px; /* 20px margin from bottom */
            left: 50%;
            transform: translateX(-50%);
            background-color: #808080; /* Gray background */
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 20px;
            z-index: 999; /* Below FAB */
            width: 300px; /* Default width for desktop */
            transition:
                background-color 0.3s ease,
                box-shadow 0.3s ease;
        }

        /* Adjust Navbar Items */
        .bottom-navbar .navbar-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ffffff; /* White icon and text color */
            text-decoration: none;
            font-size: 12px;
            transition:
                color 0.3s ease,
                transform 0.2s ease;
        }

        .bottom-navbar .navbar-item i {
            font-size: 24px;
            color: #ffffff; /* Ensure icons are white */
            transition:
                color 0.3s ease,
                transform 0.2s ease;
        }

        .bottom-navbar .navbar-item:hover {
            color: #dddddd; /* Lighten icon and text color on hover */
            transform: translateY(-3px); /* Slight lift on hover */
        }

        .bottom-navbar .navbar-item:hover i {
            color: #ffffff; /* Keep icon color white on hover */
            transform: scale(1.1); /* Slight scale-up on hover */
        }

        /* Responsive Adjustments */

        /* Mobile Styles */
        @media (max-width: 768px) {
            .bottom-navbar {
                width: calc(100% - 40px); /* 20px margin on each side */
                bottom: 20px; /* Maintain 20px margin from bottom */
            }

            /* Adjust FAB position to be above the bottom navbar with 15px space */
            .fab {
                bottom: calc(
                    20px + 15px
                ); /* Navbar bottom (20px) + 15px space = 35px */
            }

            /* FAB Options Position Adjustment */
            .fab-options {
                bottom: calc(35px + 10px); /* FAB bottom (35px) + 10px space = 45px */
            }
        }

        @media (max-width: 480px) {
            .bottom-navbar {
                width: calc(100% - 40px); /* Maintain margins */
                bottom: 20px; /* Adjusted to 20px from the bottom */
            }

            /* FAB Position Adjustment for Mobile */
            .fab {
                margin-bottom: 60px;
            }

            /* FAB Options Position Adjustment */
            .fab-options {
                margin-bottom: 120px;
            }
        }

        /* Desktop Styles */
        @media (min-width: 769px) {
            .bottom-navbar {
                width: 400px; /* Adjusted width for better aesthetics */
                bottom: 20px; /* Maintain bottom spacing */
            }

            /* FAB remains at bottom-right corner */
            .fab {
                bottom: 20px;
                right: 20px;
            }

            /* Ensure icons have enough space */
            .bottom-navbar .navbar-item {
                font-size: 14px; /* Increased font-size for desktop */
            }

            .bottom-navbar .navbar-item i {
                font-size: 26px; /* Increased icon size for desktop */
            }
        }

        /* =========================================
           11. Loading Overlay Styles
        ========================================= */

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1003; /* Above FAB and Navbar */
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid #808080;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* =========================================
           12. Form and Button Styles
        ========================================= */

        /* Spacing between form fields */
        .modal-body .form-group {
            margin-bottom: 20px; /* Adjust the value as needed for spacing */
        }

        /* Icon button styles */
        .icon-button {
            width: 40px;
            height: 40px;
            border: 1px solid #808080; /* Added border for outline */
            background-color: #ffffff; /* White background */
            color: #808080; /* Gray icon color */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px; /* Slight rounding of corners */
            cursor: pointer;
            transition:
                background-color 0.3s ease,
                color 0.3s ease;
            margin-left: 8px; /* Space between buttons */
        }

        .icon-button:hover {
            background-color: #808080; /* Gray background on hover */
            color: #ffffff; /* White icon color on hover */
        }

        .icon-button .material-icons-outlined {
            font-size: 24px; /* Adjust icon size as needed */
        }

    </style>
</head>
<body>
    <!-- 1. Header Section -->
    <header class="header">
        <!-- Menu Icon to Toggle Sidebar -->
        <div class="menu-icon" id="menu-icon" aria-label="Toggle Sidebar" role="button" tabindex="0" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </div>
        <!-- Title of the Calendar -->
        <div class="title">Calendar</div>
    </header>

    <!-- 2. Sidebar Inclusion -->
    @include('partials.sidebar')

    <!-- 3. Main Content Area -->
    <div class="calendar-container">
        <!-- Calendar Element -->
        <div id="calendar" aria-label="Calendar"></div>

        <!-- Line Divider -->
        <hr class="section-divider">

        <!-- Illustration Image (Placed Above the Filter and Cards Container) -->
        <img src="{{ asset('images/calendar.png') }}" alt="Calendar Illustration" class="illustration-image" data-bs-toggle="tooltip" data-bs-placement="top" title="Your personal calendar">

        <!-- Combined Container for Filter and Cards -->
        <div class="filter-and-cards-container">
            <!-- Filter Dropdown -->
            <div class="d-flex justify-content-end mb-3">
                <select id="filter-select" class="form-select w-auto" aria-label="Filter Calendar">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month" selected>This Month</option>
                </select>
            </div>

            <!-- Cards Section -->
            <div class="cards-section">
                <!-- Loading Spinner -->
                <div id="loading-spinner" class="text-center my-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="error-message" class="error-message" role="alert" aria-live="assertive"></div>

                <!-- Cards Container -->
                <div id="cards-container" class="cards-container">
                    <!-- Cards will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Bottom Navbar Integration -->
    <!-- Bottom Navbar -->
    <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
        <a href="{{ route('dashboard') }}" class="navbar-item" aria-label="Dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-house-door" aria-hidden="true"></i>
        </a>
        <a href="{{ route('taskmanagement.index') }}" class="navbar-item active" aria-label="Task Management" title="Task Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-list-task" aria-hidden="true"></i>
        </a>
        <a href="{{ route('financemanagement.index') }}" class="navbar-item" aria-label="Finance Management" title="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-currency-dollar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('calendar.index') }}" class="navbar-item" aria-label="Calendar" title="Calendar" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-calendar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('notifications.index') }}" class="navbar-item" aria-label="Notifications" title="Notifications" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bell" aria-hidden="true"></i>
        </a>
        <a href="{{ route('tips') }}" class="navbar-item" aria-label="Tips & Best Practices" title="Tips & Best Practices" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-lightbulb" aria-hidden="true"></i>
        </a>
        <a href="{{ route('reports') }}" class="navbar-item" aria-label="Reports" title="Reports" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bar-chart" aria-hidden="true"></i>
        </a>
    </nav>
    <!-- End of Bottom Navbar Integration -->

    <!-- 5. Add Task Modal -->
    <div id="add-task-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="add-task-title" aria-describedby="add-task-body">
        <div class="modal-content">
            <!-- Close Button for Modal -->
            <span id="add-task-close" class="modal-close" aria-label="Close Modal" role="button" tabindex="0">&times;</span>
            <!-- Modal Title -->
            <h4 id="add-task-title">Add New Task</h4>
            <!-- Task Form -->
            <form id="add-task-form">
                @csrf
                <div class="mb-3">
                    <label for="task-title" class="form-label">Title</label>
                    <input type="text" id="task-title" name="title" class="form-control" required aria-required="true" data-bs-toggle="tooltip" data-bs-placement="right" title="Enter the task title">
                </div>
                <div class="mb-3">
                    <label for="task-due-date" class="form-label">Due Date</label>
                    <input type="date" id="task-due-date" name="due_date" class="form-control" required aria-required="true" data-bs-toggle="tooltip" data-bs-placement="right" title="Select the due date">
                </div>
                <div class="mb-3">
                    <label for="task-description" class="form-label">Description</label>
                    <textarea id="task-description" name="description" class="form-control" aria-describedby="descriptionHelp" data-bs-toggle="tooltip" data-bs-placement="right" title="Provide a description for the task"></textarea>
                </div>
                <button type="submit" id="save-task-button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save the task">Save Task</button>
            </form>
        </div>
    </div>

    <!-- 6. External Scripts -->
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>

    <!-- 7. Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Get references to DOM elements
            var calendarEl = document.getElementById('calendar');

            // Get Filter Elements
            var filterSelect = document.getElementById('filter-select');
            var cardsContainer = document.getElementById('cards-container');
            var loadingSpinner = document.getElementById('loading-spinner');
            var errorMessage = document.getElementById('error-message');

            // Initialize FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: getInitialView(),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                dayMaxEvents: 5, // Limit to 5 events per day
                moreLinkText: '...', // Display three dots when there are more events
                eventSources: [
                    {
                        url: '{{ route("calendar.tasks") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value // Dynamic filter parameter
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching tasks!', 'danger');
                        },
                        color: '#6c757d', // Gray color for tasks
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.debts") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value // Dynamic filter parameter
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching debts!', 'danger');
                        },
                        color: '#495057', // Dark Gray color for debts
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.expenses") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value // Dynamic filter parameter
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching expenses!', 'danger');
                        },
                        color: '#adb5bd', // Light Gray color for expenses
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.savings") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value // Dynamic filter parameter
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching savings!', 'danger');
                        },
                        color: '#868e96', // Medium Gray color for savings
                        textColor: '#ffffff'
                    }
                ],
                eventClick: function(info) {
                    // Prevent default behavior
                    info.jsEvent.preventDefault();

                    // Redirect to the event's URL
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    } else {
                        showToast('No URL found for this event.', 'warning');
                    }
                },
                height: 'auto',
                navLinks: true,
                editable: false,
                dayMaxEventRows: true, // Enable the "more" link
                selectable: false,
                windowResize: function(view) {
                    var newView = getInitialView();
                    if (calendar.view.type !== newView) {
                        calendar.changeView(newView);
                    }
                }
            });

            calendar.render();

            function getInitialView() {
                return window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth';
            }

            // Add Task Modal Logic
            var addTaskModal = document.getElementById('add-task-modal');
            var addTaskClose = document.getElementById('add-task-close');
            var addTaskForm = document.getElementById('add-task-form');

            addTaskClose.onclick = function() {
                addTaskModal.style.display = 'none';
                addTaskModal.setAttribute('aria-hidden', 'true');
            }

            // Close modal when clicking outside the modal content
            window.onclick = function(event) {
                if (event.target == addTaskModal) {
                    addTaskModal.style.display = 'none';
                    addTaskModal.setAttribute('aria-hidden', 'true');
                }
            }

            addTaskForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(addTaskForm);

                fetch('{{ route("tasks.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else if (response.status === 422) {
                        return response.json().then(data => {
                            var errors = data.errors;
                            var errorMessages = '';
                            for (var field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessages += errors[field].join('<br>') + '<br>';
                                }
                            }
                            var errorDiv = document.getElementById('form-error-message');
                            if (errorDiv) {
                                errorDiv.innerHTML = errorMessages;
                                errorDiv.classList.remove('d-none');
                            } else {
                                showToast(errorMessages, 'danger');
                            }
                            throw new Error('Validation error');
                        });
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })
                .then(data => {
                    addTaskModal.style.display = 'none';
                    addTaskModal.setAttribute('aria-hidden', 'true');
                    addTaskForm.reset();
                    showToast(data.message, 'success');
                    calendar.refetchEvents();
                    loadCards(); // Refresh cards after adding a new task
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message !== 'Validation error') {
                        showToast('An error occurred while adding the task.', 'danger');
                    }
                });
            });

            // Load Cards Function
            function loadCards() {
                var filter = filterSelect.value;
                loadingSpinner.style.display = 'block';
                errorMessage.textContent = '';
                cardsContainer.innerHTML = '';

                // Define the URLs for fetching each type of reminder
                var urls = [
                    '{{ route("calendar.tasks") }}?filter=' + filter,
                    '{{ route("calendar.debts") }}?filter=' + filter,
                    '{{ route("calendar.expenses") }}?filter=' + filter,
                    '{{ route("calendar.savings") }}?filter=' + filter
                ];

                // Create an array of fetch Promises
                var fetchPromises = urls.map(url => fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok for ' + url);
                    }
                    return response.json();
                }));

                // Wait for all fetches to complete
                Promise.all(fetchPromises)
                    .then(results => {
                        // Combine all results into one array
                        var combinedData = [].concat(...results);
                        // Sort the combined data by start date
                        combinedData.sort((a, b) => new Date(a.start) - new Date(b.start));
                        // Render the combined cards
                        loadingSpinner.style.display = 'none';
                        renderCards(combinedData);
                    })
                    .catch(error => {
                        loadingSpinner.style.display = 'none';
                        errorMessage.textContent = 'Failed to load reminders. Please try again later.';
                        console.error('Error fetching reminders:', error);
                    });
            }

            // Render Cards Function
            function renderCards(data) {
                cardsContainer.innerHTML = '';
                if (!Array.isArray(data) || data.length === 0) {
                    cardsContainer.innerHTML = '<p class="no-data-message">Nothing here.</p>';
                    return;
                }
                data.forEach(item => {
                    var card = document.createElement('div');
                    card.className = 'card';

                    var cardBody = document.createElement('div');
                    cardBody.className = 'card-body';

                    var type = document.createElement('span');
                    type.className = 'badge mb-2';
                    type.textContent = capitalizeFirstLetter(item.type);

                    switch (item.type) {
                        case 'task':
                            type.classList.add('bg-secondary');
                            break;
                        case 'debt':
                            type.classList.add('bg-dark');
                            break;
                        case 'expense':
                            type.classList.add('bg-light', 'text-dark');
                            break;
                        case 'saving':
                            type.classList.add('bg-muted');
                            break;
                        default:
                            type.classList.add('bg-secondary');
                    }

                    var title = document.createElement('h5');
                    title.className = 'card-title';
                    title.textContent = item.title || 'Untitled';

                    var date = document.createElement('p');
                    date.className = 'card-text';
                    // Use the 'start' field for the date
                    var dueDate = item.start;

                    if (dueDate && !isNaN(new Date(dueDate))) {
                        date.textContent = 'Due Date: ' + formatDate(dueDate);
                    } else {
                        date.textContent = 'Due Date: N/A';
                    }

                    // Optional: Add Description if available
                    if (item.extendedProps && item.extendedProps.description) {
                        var description = document.createElement('p');
                        description.className = 'card-text';
                        description.textContent = item.extendedProps.description;
                        cardBody.appendChild(description);
                    }

                    cardBody.appendChild(type);
                    cardBody.appendChild(title);
                    cardBody.appendChild(date);

                    // Create a link that covers the entire card using the 'url' field directly
                    var link = document.createElement('a');
                    link.href = item.url; // Directly use the 'url' from event data
                    link.className = 'stretched-link';
                    link.setAttribute('aria-label', 'View ' + capitalizeFirstLetter(item.type));
                    link.setAttribute('title', 'View ' + capitalizeFirstLetter(item.type));
                    link.setAttribute('role', 'button');
                    link.setAttribute('tabindex', '0');
                    link.setAttribute('data-bs-toggle', 'tooltip');
                    link.setAttribute('data-bs-placement', 'top');
                    link.setAttribute('title', 'View ' + capitalizeFirstLetter(item.type));

                    card.appendChild(cardBody);
                    card.appendChild(link);
                    cardsContainer.appendChild(card);
                });

                // Re-initialize Bootstrap Tooltips for dynamically added elements
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Helper Function to Capitalize First Letter
            function capitalizeFirstLetter(string) {
                if (!string) return '';
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // Helper Function to Format Date (YYYY-MM-DD to readable format)
            function formatDate(dateString) {
                var date = new Date(dateString);
                if (isNaN(date)) {
                    return 'Invalid Date';
                }
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString(undefined, options);
            }

            // Event Listener for Filter Change
            filterSelect.addEventListener('change', function() {
                loadCards();
                // Update FullCalendar event sources with the new filter
                calendar.getEventSources().forEach(source => {
                    source.setParams({ filter: filterSelect.value });
                    source.refetch();
                });
            });

            // Initial Load
            loadCards();

            // Function to Show Bootstrap Toasts
            function showToast(message, type = 'primary') {
                // Create toast container if it doesn't exist
                if (!document.querySelector('.toast-container')) {
                    var toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }

                // Create the toast element
                var toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center text-bg-${type} border-0`;
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');

                var toastBody = document.createElement('div');
                toastBody.className = 'd-flex';
                toastBody.innerHTML = `
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                `;

                toastEl.appendChild(toastBody);
                document.querySelector('.toast-container').appendChild(toastEl);

                // Initialize and show the toast
                var toast = new bootstrap.Toast(toastEl);
                toast.show();

                // Remove the toast from DOM after it hides
                toastEl.addEventListener('hidden.bs.toast', function () {
                    toastEl.remove();
                });
            }
        });
    </script>
</body>
</html>
