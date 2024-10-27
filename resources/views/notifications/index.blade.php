<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications - Smart Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

    <!-- Material Icons (Google) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" id="menu-icon">
            <i class="bi bi-list"></i>
        </div>
        <div class="title">Notifications</div>
    </header>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content container">
        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="card-panel green lighten-4 green-text text-darken-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="card-panel red lighten-4 red-text text-darken-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Buttons -->
        <div class="task-filter">
            <button class="filter-btn active" onclick="filterNotifications('all')">All</button>
            <button class="filter-btn" onclick="filterNotifications('read')">Read</button>
            <button class="filter-btn" onclick="filterNotifications('unread')">Unread</button>
        </div>

        @if($notifications->isEmpty())
            <div class="no-notifications center-align">
                <img src="{{ asset('images/no-notifications.png') }}" alt="No Notifications">
                <h5>No Notifications Yet</h5>
                <p>You're all caught up!</p>
            </div>
        @else
            <div class="notification-cards" id="notification-list">
                @foreach($notifications as $notification)
                    @php
                        $type = class_basename($notification->type);
                    @endphp
                    <div class="card notification-card @if(is_null($notification->read_at)) unread @endif" 
                         data-status="{{ is_null($notification->read_at) ? 'unread' : 'read' }}"
                         onclick="markAsRead({{ $notification->id }}, this)">
                        <div class="card-content">
                            <div class="notification-header">
                                <div class="icon-wrapper">
                                    <i class="material-icons">
                                        @switch($type)
                                            @case('TaskReminderNotification')
                                                task_alt
                                                @break
                                            @case('DebtDeadlineNotification')
                                                account_balance
                                                @break
                                            @case('OverspendingNotification')
                                                error
                                                @break
                                            @case('ProjectInvitationNotification')
                                                person_add_alt
                                                @break
                                            @default
                                                notifications
                                        @endswitch
                                    </i>
                                </div>
                                <span class="card-title">{{ str_replace('Notification', '', $type) }}</span>
                            </div>
                            <p>{{ data_get($notification->data, 'message', 'You have a new notification.') }}</p>
                            <p class="grey-text text-darken-2">{{ $notification->created_at->diffForHumans() }}</p>

                           <!-- Within your notifications loop -->

@if($type === 'ProjectInvitationNotification')
<div class="notification-actions" onclick="event.stopPropagation();">
    <form action="{{ route('collaborations.accept', ['project' => $notification->data['project_id']]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-small green lighten-1 waves-effect">Accept</button>
    </form>
    <form action="{{ route('collaborations.decline', ['project' => $notification->data['project_id']]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-small red lighten-1 waves-effect">Decline</button>
    </form>
</div>
@endif

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu toggle functionality
            var menuIcon = document.getElementById('menu-icon');
            var sidebar = document.getElementById('sidebar');
            menuIcon.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });

            // Initialize any Materialize components if needed
            var elems = document.querySelectorAll('.tooltipped');
            var instances = M.Tooltip.init(elems, {});
        });

        // Filter notifications
        function filterNotifications(status) {
            const cards = document.querySelectorAll('.notification-card');
            cards.forEach(card => {
                if (status === 'all') {
                    card.style.display = 'block';
                } else if (status === 'read' && card.getAttribute('data-status') === 'read') {
                    card.style.display = 'block';
                } else if (status === 'unread' && card.getAttribute('data-status') === 'unread') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            // Update active class for filter buttons
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.trim().toLowerCase() === status) {
                    btn.classList.add('active');
                }
            });
        }

        // Mark notification as read
        function markAsRead(notificationId, cardElement) {
            // Mark the notification as read in the database (using AJAX or a form submission)
            fetch(`/notifications/${notificationId}/read`, { method: 'POST' })
                .then(response => {
                    if (response.ok) {
                        // Change the card's appearance
                        cardElement.classList.remove('unread');
                        cardElement.setAttribute('data-status', 'read');
                    } else {
                        console.error('Failed to mark notification as read');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>
