<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========================
         1. Meta and Title
    ========================= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Favicon -->
     <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    <title>Smart Planner Calendar</title>

    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- =========================
         2. External Stylesheets
    ========================== -->
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Sidebar CSS (if you have a sidebar) -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- =======================
         3. Custom CSS Section
    ======================== -->
    <style>
        /* -----------------------------------------------------
           THEME COLORS & GLOBAL VARIABLES
           ----------------------------------------------------- */
        :root {
            --primary-color: #6c757d;       /* Gray for highlights */
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
            --transition-speed: 0.3s;       /* Transition duration for hovers */
        }

        /* --------------------------------------
           GLOBAL STYLES & BODY BACKGROUND
           -------------------------------------- */
        body {
            font-family: "Open Sans", sans-serif;
            margin: 0;
            background: linear-gradient(to right, #f9f9f9, #f5f5f5);
            color: #808080; /* Default text color */
        }

        /* --------------------------------------
           HEADER STYLES
           -------------------------------------- */
        .header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(to right, #f9f9f9, #f5f5f5);
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 60px; /* Fixed header height */
        }

        .title {
            font-size: 20px;
            font-weight: 500;
            flex: 1;
            text-align: center;
            color: #333;
        }

        /* --------------------------------------
           CALENDAR CONTAINER
           -------------------------------------- */
        .calendar-container {
            /*
             * Reduced top padding to move the content
             * closer to the header, plus added extra
             * bottom padding (80px) so the bottom navbar 
             * doesn't overlap the container content.
             */
            padding: 50px 20px 80px; 
            max-width: 100%;
            box-sizing: border-box;
        }

        /* --------------------------------------
           SECTION DIVIDER
           -------------------------------------- */
        .section-divider {
            margin: 40px 0;
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #ccc, transparent);
        }

        /* --------------------------------------
           ILLUSTRATION IMAGE
           -------------------------------------- */
        .illustration-image {
            display: block;
            margin: 0 auto 20px auto;  /* Center horizontally with bottom margin */
            max-width: 30%;            /* Adjust as needed */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            animation: float 5s ease-in-out infinite;
            transition: transform var(--transition-speed);
        }

        .illustration-image:hover {
            transform: scale(1.05);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* --------------------------------------
           FILTER AND CARDS CONTAINER
           -------------------------------------- */
        .filter-and-cards-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .cards-section {
            padding: 20px 0;
        }

        /* Cards Container for dynamic data */
        .cards-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the cards horizontally */
            width: 100%;
        }

        /* Card Styles */
        .card {
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;   /* Adjust the max-width as needed */
            height: 150px;      /* Fixed height for consistency */
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            position: relative;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Message when no data is available */
        .no-data-message {
            text-align: center;
            color: #6c757d;
            font-size: 1.2rem;
            margin-top: 40px;
        }

        /* --------------------------------------
           FULLCALENDAR CUSTOMIZATION
           -------------------------------------- */
        /* Calendar Toolbar Title */
        .fc .fc-toolbar-title {
            color: #333;
            font-size: 1.5rem;
            align-self: center;
        }

        /* Calendar Buttons (previous, next, today, etc.) */
        .fc .fc-button {
            background-color: #6f6868 !important;
            border-color: var(--button-color) !important;
            color: #f0f0f0 !important;
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

        /* Highlight Today's Date */
        .fc .fc-day-today {
            background-color: #e9ecef;
        }

        /* Gray color for day numbers and week titles, remove underlines */
        .fc .fc-col-header-cell-cushion,
        .fc .fc-daygrid-day-number {
            color: var(--text-gray) !important;
            text-decoration: var(--no-underline) !important;
            transition: color var(--transition-speed);
        }

        /* Subtle hover change */
        .fc .fc-col-header-cell-cushion:hover,
        .fc .fc-daygrid-day-number:hover {
            color: var(--primary-color) !important;
            text-decoration: var(--no-underline) !important;
        }

        /* Fixed day cell height and limiting events */
        .fc .fc-daygrid-day-frame {
            height: 130px !important; /* Fix the height for a consistent grid */
            overflow: hidden;
            position: relative;
        }

        .fc .fc-daygrid-day-events {
            max-height: 100px; /* Adjust to allow more or fewer events */
            overflow: hidden;
        }

        /* Styling the 'more' link in day cells */
        .fc .fc-more-link {
            position: absolute;
            bottom: 2px;
            left: 2px;
            color: var(--secondary-color) !important;
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
            background-color: rgba(173, 181, 189, 0.2); /* Light gray background */
            color: var(--primary-color) !important;
        }

        /* Event blocks on the calendar */
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

        /* Ensure events stack without overlapping */
        .fc-daygrid-event {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* --------------------------------------
           RESPONSIVE STYLES
           -------------------------------------- */
        @media (max-width: 992px) {
            .illustration-image {
                max-width: 35%;
            }
        }

        @media (max-width: 768px) {
            .calendar-container {
                padding: 40px 10px 80px; /* 80px bottom padding remains for nav */
            }

            .illustration-image {
                max-width: 40%;
            }

            .fc .fc-toolbar.fc-header-toolbar {
                flex-wrap: nowrap;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 0 5px;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .fc .fc-toolbar-title {
                font-size: 1rem;
                margin: 0 5px;
            }

            .fc .fc-button {
                padding: 4px 6px;
                font-size: 0.8rem;
                margin: 0 2px;
            }

            .fc-event {
                font-size: 0.75rem;
                padding: 1px 2px;
            }
        }

        @media (max-width: 576px) {
            .calendar-container {
                padding: 40px 10px 80px;
            }

            .illustration-image {
                max-width: 50%;
            }

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

            .fc-event {
                font-size: 0.65rem;
            }
        }

        /* --------------------------------------
           MODAL STYLES (FOR ADD TASK)
           -------------------------------------- */
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
            margin: 10% auto; /* 10% from the top, centered */
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

        /* --------------------------------------
           LOADING SPINNER
           -------------------------------------- */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* --------------------------------------
           ERROR MESSAGE
           -------------------------------------- */
        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        /* --------------------------------------
           CARD LINK (COVERS WHOLE CARD)
           -------------------------------------- */
        .card a.stretched-link {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            text-decoration: none;
            pointer-events: auto; /* Make sure link is clickable */
        }

        /* --------------------------------------
           BOTTOM NAVBAR
           -------------------------------------- */
        .bottom-navbar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #808080; /* Gray background */
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 20px;
            z-index: 999;  /* Below FAB if you have a FAB */
            width: 300px;  /* Default width for desktop */
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .bottom-navbar .navbar-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .bottom-navbar .navbar-item i {
            font-size: 24px;
            color: #ffffff;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .bottom-navbar .navbar-item:hover {
            color: #dddddd;
            transform: translateY(-3px);
        }

        .bottom-navbar .navbar-item:hover i {
            color: #ffffff;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .bottom-navbar {
                width: calc(100% - 40px); /* 20px margin each side */
                bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .bottom-navbar {
                width: calc(100% - 40px);
                bottom: 20px;
            }
        }

        @media (min-width: 769px) {
            .bottom-navbar {
                width: 400px; /* Slightly wider for desktop aesthetic */
                bottom: 20px;
            }
        }

        /* --------------------------------------
           LOADING OVERLAY (IF USED)
           -------------------------------------- */
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
            z-index: 1003;
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

        /* --------------------------------------
           FORM & BUTTON STYLES
           -------------------------------------- */
        .modal-body .form-group {
            margin-bottom: 20px;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border: 1px solid #808080;
            background-color: #ffffff;
            color: #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-left: 8px;
        }

        .icon-button:hover {
            background-color: #808080;
            color: #ffffff;
        }

        .icon-button .material-icons-outlined {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <!-- =========================
         CUSTOM LOADER (OPTIONAL)
         ========================= -->
    @include('partials.loader')

    <!-- =========================
         1. HEADER SECTION
         ========================= -->

    <!-- =========================
         2. MAIN CONTENT AREA
         ========================= -->
    <div class="calendar-container">
        <!-- FullCalendar Element -->
        <div id="calendar" aria-label="Calendar"></div>

        <!-- Section Divider -->
        <hr class="section-divider">

        <!-- Illustration Image -->
        <img 
            src="{{ asset('images/calendar.png') }}" 
            alt="Calendar Illustration" 
            class="illustration-image" 
            data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Your personal calendar"
        >

        <!-- Combined Container for Filter and Cards -->
        <div class="filter-and-cards-container">
            <!-- Filter (Dropdown) -->
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

                <!-- Container for dynamically loaded cards -->
                <div id="cards-container" class="cards-container">
                    <!-- Cards will be inserted here via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- =========================
         3. BOTTOM NAVBAR
         ========================= -->
    <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
        <!-- Example Navbar Items -->
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

    <!-- =========================
         4. ADD TASK MODAL
         ========================= -->
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
                    <input 
                        type="text" 
                        id="task-title" 
                        name="title" 
                        class="form-control" 
                        required 
                        aria-required="true"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="right" 
                        title="Enter the task title"
                    >
                </div>
                <div class="mb-3">
                    <label for="task-due-date" class="form-label">Due Date</label>
                    <input 
                        type="date" 
                        id="task-due-date" 
                        name="due_date" 
                        class="form-control" 
                        required 
                        aria-required="true"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="right" 
                        title="Select the due date"
                    >
                </div>
                <div class="mb-3">
                    <label for="task-description" class="form-label">Description</label>
                    <textarea 
                        id="task-description" 
                        name="description" 
                        class="form-control" 
                        aria-describedby="descriptionHelp"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="right" 
                        title="Provide a description for the task"
                    ></textarea>
                </div>
                <button 
                    type="submit" 
                    id="save-task-button" 
                    class="btn btn-primary"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="Click to save the task"
                >
                    Save Task
                </button>
            </form>
        </div>
    </div>

    <!-- =========================
         5. EXTERNAL SCRIPTS
         ========================= -->
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Loader JS (if used) -->
    <script src="{{ asset('js/loader.js') }}"></script>

    <!-- =========================
         6. CUSTOM SCRIPTS
         ========================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---------------------------------------
            // 1. BOOTSTRAP TOOLTIP INITIALIZATION
            // ---------------------------------------
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // DOM Elements for Calendar
            var calendarEl = document.getElementById('calendar');

            // DOM Elements for Filtering & Cards
            var filterSelect = document.getElementById('filter-select');
            var cardsContainer = document.getElementById('cards-container');
            var loadingSpinner = document.getElementById('loading-spinner');
            var errorMessage = document.getElementById('error-message');

            // ---------------------------------------
            // 2. FULLCALENDAR INITIALIZATION
            // ---------------------------------------
            var calendar = new FullCalendar.Calendar(calendarEl, {
                /*
                 * Dynamic initial view: 
                 * Use listMonth on smaller screens 
                 * and dayGridMonth on larger screens.
                 */
                initialView: getInitialView(),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                /*
                 * Limit events per day and set text 
                 * for "more" link in day cells.
                 */
                dayMaxEvents: 5,
                moreLinkText: '...',
                
                /*
                 * Event Sources 
                 * (Tasks, Debts, Expenses, Savings)
                 */
                eventSources: [
                    {
                        url: '{{ route("calendar.tasks") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching tasks!', 'danger');
                        },
                        color: '#6c757d',  // Gray color
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.debts") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching debts!', 'danger');
                        },
                        color: '#495057',  // Dark Gray color
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.expenses") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching expenses!', 'danger');
                        },
                        color: '#adb5bd', // Light Gray color
                        textColor: '#ffffff'
                    },
                    {
                        url: '{{ route("calendar.savings") }}',
                        method: 'GET',
                        extraParams: function() {
                            return {
                                filter: filterSelect.value
                            };
                        },
                        failure: function() {
                            showToast('There was an error while fetching savings!', 'danger');
                        },
                        color: '#868e96', // Medium Gray color
                        textColor: '#ffffff'
                    }
                ],
                /*
                 * On event click, if it has a URL,
                 * go to that URL. Otherwise, show a warning.
                 */
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    } else {
                        showToast('No URL found for this event.', 'warning');
                    }
                },
                height: 'auto',
                navLinks: true,
                editable: false,
                dayMaxEventRows: true,
                selectable: false,

                /*
                 * Listen to window resize 
                 * and switch view type if needed.
                 */
                windowResize: function(view) {
                    var newView = getInitialView();
                    if (calendar.view.type !== newView) {
                        calendar.changeView(newView);
                    }
                }
            });

            // Render the calendar
            calendar.render();

            /*
             * Decide which initial view to use
             * based on the screen width.
             */
            function getInitialView() {
                return window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth';
            }

            // ---------------------------------------
            // 3. ADD TASK MODAL LOGIC
            // ---------------------------------------
            var addTaskModal = document.getElementById('add-task-modal');
            var addTaskClose = document.getElementById('add-task-close');
            var addTaskForm = document.getElementById('add-task-form');

            // Close the modal on close icon click
            addTaskClose.onclick = function() {
                addTaskModal.style.display = 'none';
                addTaskModal.setAttribute('aria-hidden', 'true');
            }

            // Close the modal if user clicks outside the modal content
            window.onclick = function(event) {
                if (event.target == addTaskModal) {
                    addTaskModal.style.display = 'none';
                    addTaskModal.setAttribute('aria-hidden', 'true');
                }
            }

            // Handle form submission to add a new task
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
                    // Close modal on success
                    addTaskModal.style.display = 'none';
                    addTaskModal.setAttribute('aria-hidden', 'true');
                    addTaskForm.reset();

                    // Show success message
                    showToast(data.message, 'success');

                    // Refresh the calendar events
                    calendar.refetchEvents();

                    // Refresh the cards list
                    loadCards();
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message !== 'Validation error') {
                        showToast('An error occurred while adding the task.', 'danger');
                    }
                });
            });

            // ---------------------------------------
            // 4. LOADING CARDS (TASKS/DEBTS/ETC.)
            // ---------------------------------------
            function loadCards() {
                var filter = filterSelect.value;
                loadingSpinner.style.display = 'block';
                errorMessage.textContent = '';
                cardsContainer.innerHTML = '';

                /*
                 * We'll fetch data for tasks, debts, expenses,
                 * and savings from separate endpoints, then
                 * combine them into a single array.
                 */
                var urls = [
                    '{{ route("calendar.tasks") }}?filter=' + filter,
                    '{{ route("calendar.debts") }}?filter=' + filter,
                    '{{ route("calendar.expenses") }}?filter=' + filter,
                    '{{ route("calendar.savings") }}?filter=' + filter
                ];

                var fetchPromises = urls.map(url => 
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok for ' + url);
                        }
                        return response.json();
                    })
                );

                Promise.all(fetchPromises)
                    .then(results => {
                        // Combine all data from each endpoint
                        var combinedData = [].concat(...results);
                        
                        // Sort the data by start date (ascending)
                        combinedData.sort((a, b) => new Date(a.start) - new Date(b.start));

                        // Hide the spinner and render the cards
                        loadingSpinner.style.display = 'none';
                        renderCards(combinedData);
                    })
                    .catch(error => {
                        loadingSpinner.style.display = 'none';
                        errorMessage.textContent = 'Failed to load reminders. Please try again later.';
                        console.error('Error fetching reminders:', error);
                    });
            }

            /*
             * renderCards(data)
             * Dynamically create card elements for each item.
             */
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

                    // Badge to indicate type of item (task, debt, etc.)
                    var type = document.createElement('span');
                    type.className = 'badge mb-2';
                    type.textContent = capitalizeFirstLetter(item.type);

                    // Switch color based on item type
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

                    // Title
                    var title = document.createElement('h5');
                    title.className = 'card-title';
                    title.textContent = item.title || 'Untitled';

                    // Date
                    var date = document.createElement('p');
                    date.className = 'card-text';
                    var dueDate = item.start;
                    if (dueDate && !isNaN(new Date(dueDate))) {
                        date.textContent = 'Due Date: ' + formatDate(dueDate);
                    } else {
                        date.textContent = 'Due Date: N/A';
                    }

                    // Optional: Description
                    if (item.extendedProps && item.extendedProps.description) {
                        var description = document.createElement('p');
                        description.className = 'card-text';
                        description.textContent = item.extendedProps.description;
                        cardBody.appendChild(description);
                    }

                    cardBody.appendChild(type);
                    cardBody.appendChild(title);
                    cardBody.appendChild(date);

                    // Link covering the entire card
                    var link = document.createElement('a');
                    link.href = item.url; // Directly use the 'url' from the event data
                    link.className = 'stretched-link';
                    link.setAttribute('aria-label', 'View ' + capitalizeFirstLetter(item.type));
                    link.setAttribute('title', 'View ' + capitalizeFirstLetter(item.type));
                    link.setAttribute('role', 'button');
                    link.setAttribute('tabindex', '0');
                    link.setAttribute('data-bs-toggle', 'tooltip');
                    link.setAttribute('data-bs-placement', 'top');
                    link.setAttribute('title', 'View ' + capitalizeFirstLetter(item.type));

                    // Add the body and the link to the card
                    card.appendChild(cardBody);
                    card.appendChild(link);

                    // Append the card to the container
                    cardsContainer.appendChild(card);
                });

                // Re-initialize Bootstrap Tooltips for new elements
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Helper function: Capitalize first letter
            function capitalizeFirstLetter(string) {
                if (!string) return '';
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // Helper function: Format date from YYYY-MM-DD
            function formatDate(dateString) {
                var date = new Date(dateString);
                if (isNaN(date)) {
                    return 'Invalid Date';
                }
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString(undefined, options);
            }

            /*
             * On change of filter (today, week, month),
             * reload the cards and refresh the event sources.
             */
            filterSelect.addEventListener('change', function() {
                loadCards();
                calendar.getEventSources().forEach(source => {
                    source.setParams({ filter: filterSelect.value });
                    source.refetch();
                });
            });

            // Initial call to load cards when the page loads
            loadCards();

            // ---------------------------------------
            // 5. BOOTSTRAP TOAST NOTIFICATION
            // ---------------------------------------
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

                // Remove the toast element once hidden
                toastEl.addEventListener('hidden.bs.toast', function () {
                    toastEl.remove();
                });
            }
        });
    </script>
</body>
</html>
