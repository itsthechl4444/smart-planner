<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Planner Calendar</title>

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <style>
        /* Global Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            color: #808080;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Header Styles */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f5f5f5;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .menu-icon {
            font-size: 24px;
            cursor: pointer;
            color: #333;
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
            flex-grow: 1;
            background-color: #fff;
            padding: 80px 20px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        #calendar {
            flex-grow: 1;
            padding: 0;
            box-sizing: border-box;
            width: 100%;
        }

        /* Floating Action Button (FAB) */
        .fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #808080;
            color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease;
            z-index: 1001;
        }

        .fab:hover {
            background-color: #555;
        }

        .fab-options {
            display: none;
            position: fixed;
            bottom: 90px;
            right: 30px;
            background-color: #F5F5F5;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 10px;
            z-index: 1000;
        }

        .fab-options.show {
            display: block;
        }

        .fab-option {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .fab-option i {
            font-size: 18px;
            margin-right: 10px;
        }

        .fab-option:hover {
            background-color: #e0e0e0;
        }

        /* FullCalendar Customizations */
        .fc-toolbar.fc-header-toolbar {
            background-color: #f5f5f5;
            padding: 10px 20px;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .fc-button {
            background-color: #f5f5f5;
            border: none;
            color: #555;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .fc-button:hover {
            background-color: #e0e0e0;
        }

        /* Preventing boxes from adjusting to text */
        .fc-daygrid-day-frame {
            min-width: 80px; /* Adjust the minimum width */
            min-height: 80px; /* Fixed height for day boxes */
            height: 80px; /* Ensure fixed height */
            overflow: hidden; /* Prevent overflow */
            box-sizing: border-box;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header {
                padding: 10px;
                font-size: 16px;
            }

            .title {
                font-size: 18px;
            }

            .calendar-container {
                padding: 70px 10px 10px;
            }

            .fab {
                width: 50px;
                height: 50px;
                bottom: 15px;
                right: 15px;
            }

            .fab-options {
                bottom: 75px;
                right: 20px;
            }

            /* Flexbox for day grid to prevent overlap */
            .fc-daygrid {
                display: flex;
                flex-wrap: wrap;
            }

            .fc-daygrid-day {
                flex: 1 0 14%; /* Each day takes up 1/7 of the row */
                min-width: 80px; /* Minimum width to maintain responsiveness */
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 8px;
            }

            .title {
                font-size: 16px;
            }

            .fab {
                width: 45px;
                height: 45px;
                bottom: 10px;
                right: 10px;
            }

            .fab-options {
                bottom: 65px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" id="menu-icon">
            <i class="bi bi-list"></i>
        </div>
        <div class="title">Calendar</div>
    </header>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    <!-- Floating Action Button (FAB) -->
    <div class="fab" id="fab">
        <i class="bi bi-plus"></i>
    </div>
    <div class="fab-options" id="fab-options">
        <div class="fab-option">
            <i class="bi bi-calendar-plus"></i> Add Task
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventSources: [
                    {
                        url: '/calendar/tasks',
                        method: 'GET',
                        failure: function() {
                            alert('There was an error while fetching tasks!');
                        },
                        color: 'blue',
                        textColor: 'white'
                    }
                ],
                eventContent: function(arg) {
                    let eventElement = document.createElement('div');
                    eventElement.innerHTML = `<span>${arg.event.title}</span>`;
                    return { domNodes: [eventElement] };
                },
                height: 'auto',
                aspectRatio: 2,
                navLinks: true,
                editable: false,
                dayMaxEvents: true
            });
            calendar.render();

            // Sidebar toggle
            var sidebar = document.getElementById('sidebar');
            var menuIcon = document.getElementById('menu-icon');
            menuIcon.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                document.querySelector('.calendar-container').classList.toggle('sidebar-active');
            });

            // FAB toggle
            var fab = document.getElementById('fab');
            var fabOptions = document.getElementById('fab-options');
            fab.addEventListener('click', function(e) {
                e.stopPropagation();
                fabOptions.classList.toggle('show');
            });

            // Close FAB options when clicking outside
            document.addEventListener('click', function(event) {
                if (!fab.contains(event.target) && !fabOptions.contains(event.target)) {
                    fabOptions.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
