<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications - Smart Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Favicon -->
     <link rel="icon" href="/images/LogoPNG.png" type="image/png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Material Icons (Google) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Material Symbols Outlined (for "more_horiz") -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- Inline Custom CSS -->
    <style>
        /* =========================================
           1. Global / Body / Header
        ========================================= */
        body {
            font-family: "Open Sans", sans-serif;
            margin: 0;
            background: linear-gradient(to right, #f9f9f9, #f5f5f5);
            color: #808080;
            line-height: 1.6;
        }

        /* Header Container */
        .header {
            display: flex;
            align-items: center;
            justify-content: center; /* Center items horizontally */
            padding: 10px 20px;
            background: linear-gradient(to right, #f9f9f9, #f5f5f5);
            position: fixed; /* Fixed at the top */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 65px; /* Set consistent height */
            transition:
                background-color 0.3s ease,
                color 0.3s ease;
        }

        .title {
            font-size: 20px;
            font-weight: 500;
            text-align: center;
            color: #555;
        }

        .main-content {
            padding: 80px 20px 120px; /* space so bottom navbar won't overlap content */
        }

        /* =========================================
           2. Notification List & Cards
        ========================================= */
        .notification-cards {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 100%;
            margin: 0 auto;
        }

        .notification-card {
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            animation: fadeIn 0.5s forwards;
            height: auto;
            border-radius: 8px;
            margin: 3px 0; /* minimal space between cards */
            width: 100%;
        }
        .notification-card:focus,
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .notification-card.unread {
            background-color: #fafafa;
            border-left: 5px solid #757575;
        }
        .notification-card.read {
            background-color: #ffffff;
            border-left: 5px solid transparent;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; height: auto; margin-bottom: 5px; }
            to   { opacity: 0; height: 0; margin-bottom: 0; }
        }
        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        /* Reduced padding to keep the card more compact */
        .card-content {
            padding: 6px;
        }

        .notification-header {
            display: flex;
            align-items: flex-start; /* top-align the texts */
        }

        /* Left icon block */
        .icon-wrapper {
            width: 30px;
            height: 30px;
            background-color: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .icon-wrapper i {
            font-size: 18px;
            color: #424242;
        }

        /* Middle text column */
        .title-and-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex: 1; /* Expand to use leftover space */
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #424242;
            margin: 0 0 3px; /* small spacing to separate from description */
            line-height: 1.2;
        }
        .notification-message {
            font-size: 13px;
            color: #757575;
            margin: 0 0 3px; 
            line-height: 1.4;
        }
        .notification-time {
            font-size: 12px;
            color: #a0a0a0;
            margin: 0 0 2px;
        }

        /* Right "more" icon */
        .more-options {
            margin-left: 10px; 
            cursor: pointer;
            position: relative;
        }
        .more-options .material-symbols-outlined {
            font-size: 20px;
            color: #757575;
        }
        .more-options:hover .material-symbols-outlined,
        .more-options:focus .material-symbols-outlined {
            color: #424242;
        }

        .dropdown-content {
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .dropdown-content a.delete-notification {
            color: #757575;
            font-weight: 500;
            transition: color 0.3s;
        }
        .dropdown-content a.delete-notification:hover,
        .dropdown-content a.delete-notification:focus {
            color: #424242;
        }

        .notification-actions {
            margin-top: 8px;
        }
        .notification-actions form {
            display: inline-block;
            margin-right: 8px;
        }
        .accept-btn {
            background-color: #424242 !important;
            color: #fff !important;
            padding: 4px 4px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .decline-btn {
            background-color: #9e9e9e !important;
            color: #fff !important;
            padding: 4px 8px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .notification-card:hover {
            background-color: #f9f9f9;
        }

        /* =========================================
           3. "No Notifications" Empty State
        ========================================= */
        .no-notifications {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 50px;
        }
        .no-notifications img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
        }
        .no-notifications h5 {
            margin-bottom: 8px;
            color: #555;
            font-size: 18px;
        }
        .no-notifications p {
            color: #757575;
            font-size: 14px;
        }

        /* =========================================
           4. Filter Buttons & Mark-All
           (Using dashboard styles)
        ========================================= */
        .task-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .filter-btn {
            padding: 8px 12px;
      margin-right: 10px;
      cursor: pointer;
      border: 1px solid #ddd;
      background-color: #fff;
      border-radius: 4px;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 14px;
      color: #808080;
        }
        .filter-btn.active {
            background-color: #808080;
      color: #fff;
      border-color: #808080;
        }
        .filter-btn:hover {
            background-color: #e0e0e0;
        }
        .filter-btn:not(.active):hover {
            background-color: #f0f0f0;
        }

        .mark-all-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .mark-all-link {
            color: #757575;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .mark-all-link:hover,
        .mark-all-link:focus {
            color: #424242;
            text-decoration: underline;
        }

        /* =========================================
           5. Modals
        ========================================= */
        .modal {
            top: 50% !important;
            transform: translateY(-50%) !important;
            max-height: 90% !important; 
            overflow-y: auto;
            border-radius: 10px;
        }
        .modal-content {
            padding: 20px;
        }
        .modal-content h4 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        .modal-content p {
            font-size: 14px;
            line-height: 1.4;
        }
        .modal-footer {
            text-align: right;
        }

        /* =========================================
           6. Snackbar
        ========================================= */
        .snackbar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 250px;
            z-index: 9999;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .snackbar.hide {
            display: none;
        }
        .snackbar .close-snackbar {
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 16px;
        }

        /* =========================================
           7. Bottom Navbar Styles
        ========================================= */
        .bottom-navbar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #808080; 
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 20px;
            z-index: 999;
            width: 300px;
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
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .bottom-navbar {
                width: calc(100% - 40px);
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
                width: 400px;
                bottom: 20px;
            }
            .bottom-navbar .navbar-item {
                font-size: 14px;
            }
            .bottom-navbar .navbar-item i {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <!-- Include the loader (spinner) from the dashboard -->
    @include('partials.loader')

    <!-- Header -->
    <header class="header">
        <div class="title">Notifications</div>
    </header>

    <!-- Main Content -->
    <main class="main-content container">
        <!-- Success and Error Messages -->
        @if(session('success'))
            <div id="snackbar" class="snackbar">
                <span>{{ session('success') }}</span>
                <button class="close-snackbar" onclick="document.getElementById('snackbar').classList.add('hide');">x</button>
            </div>
        @endif

        @if(session('error'))
            <div id="snackbar" class="snackbar">
                <span>{{ session('error') }}</span>
                <button class="close-snackbar" onclick="document.getElementById('snackbar').classList.add('hide');">x</button>
            </div>
        @endif

        <!-- Filter Buttons (Dashboard Style using <button> elements) -->
        <div class="task-filter" role="group" aria-label="Notification Filters">
            <button type="button" class="filter-btn {{ $filter === 'all' ? 'active' : '' }}" onclick="location.href='{{ route('notifications.index', ['filter' => 'all']) }}'">
                All
            </button>
            <button type="button" class="filter-btn {{ $filter === 'read' ? 'active' : '' }}" onclick="location.href='{{ route('notifications.index', ['filter' => 'read']) }}'">
                Read
            </button>
            <button type="button" class="filter-btn {{ $filter === 'unread' ? 'active' : '' }}" onclick="location.href='{{ route('notifications.index', ['filter' => 'unread']) }}'">
                Unread
            </button>
        </div>

        @if(!$notifications->isEmpty())
            <!-- Mark All as Read Link -->
            <div class="mark-all-container">
                <a href="#" id="mark-all-read" class="mark-all-link">Mark All as Read</a>
            </div>
        @endif

        @if($notifications->isEmpty())
            @if($filter === 'all')
                <div class="no-notifications center-align" id="empty-all">
                    <img src="{{ asset('images/notification.png') }}" alt="No Notifications">
                    <h5>🧚 No Notifications Yet 🪄</h5>
                    <p>You're all caught up!</p>
                </div>
            @elseif($filter === 'read')
                <div class="no-notifications center-align" id="empty-read">
                    <img src="{{ asset('images/notification.png') }}" alt="No Read Messages">
                    <h5>🧚 No Read Messages Yet 🪄</h5>
                    <p>You haven't read any notifications.</p>
                </div>
            @elseif($filter === 'unread')
                <div class="no-notifications center-align" id="empty-unread">
                    <img src="{{ asset('images/notification.png') }}" alt="No Unread Messages">
                    <h5>🧚 No Unread Messages Yet 🪄</h5>
                    <p>You're up to date with all notifications.</p>
                </div>
            @endif
        @else
            <div class="notification-cards" id="notification-list">
                @foreach($notifications as $notification)
                    @php
                        $type = class_basename($notification->type);
                        $displayType = preg_replace('/(?<!^)([A-Z])/', ' $1', str_replace('Notification', '', $type));

                        // Build a redirect URL for tasks/debts; else we'll use modal
                        $redirectUrl = "#modal-notification-{$notification->id}";
                        $hasModal = true;  // By default, we open a modal

                        // If it's a task or debt, we direct to the show page instead
                        if ($type === 'TaskReminderNotification' && isset($notification->data['task_id'])) {
                            $redirectUrl = route('tasks.show', ['task' => $notification->data['task_id']]);
                            $hasModal = false;
                        } elseif ($type === 'DebtDeadlineNotification' && isset($notification->data['debt_id'])) {
                            $redirectUrl = route('debts.show', ['debt' => $notification->data['debt_id']]);
                            $hasModal = false;
                        }
                    @endphp

                    <!-- Notification Card -->
                    <div 
                        class="card notification-card {{ is_null($notification->read_at) ? 'unread' : 'read' }}"
                        data-notification-id="{{ $notification->id }}"
                        data-type="{{ $type }}"
                        data-has-modal="{{ $hasModal ? 'true' : 'false' }}"
                        data-redirect-url="{{ $redirectUrl }}"
                        tabindex="0"
                        role="button"
                        aria-label="Notification: {{ data_get($notification->data, 'message', 'You have a new notification.') }}"
                    >
                        <div class="card-content">
                            <div class="notification-header">
                                <!-- Left Icon -->
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
                                            @case('CollaboratorRemovedNotification')
                                                remove_circle
                                                @break
                                            @case('ProjectInvitationResponseNotification')
                                                reply
                                                @break
                                            @default
                                                notifications
                                        @endswitch
                                    </i>
                                </div>

                                <!-- Middle: Title + Description + Time -->
                                <div class="title-and-text">
                                    <span class="card-title">{{ $displayType }}</span>
                                    <p class="notification-message">
                                        {{ data_get($notification->data, 'message', 'You have a new notification.') }}
                                    </p>
                                    <p class="grey-text text-darken-2 notification-time">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <!-- More Options (top-right) -->
                                <a 
                                    class="dropdown-trigger more-options" 
                                    href="#" 
                                    data-target="dropdown-{{ $notification->id }}" 
                                    tabindex="0" 
                                    aria-label="More options for this notification" 
                                    role="button"
                                >
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </a>

                                <!-- Dropdown Menu -->
                                <ul id="dropdown-{{ $notification->id }}" class="dropdown-content">
                                    <li>
                                        <a href="#!" class="delete-notification" data-notification-id="{{ $notification->id }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- If there's an Accept/Decline for Project Invitations, place them below -->
                            @if($type === 'ProjectInvitationNotification')
                                <div class="notification-actions" onclick="event.stopPropagation();">
                                    <form action="{{ route('collaborations.accept', ['project' => $notification->data['project_id'], 'user' => Auth::id()]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-small accept-btn waves-effect">Accept</button>
                                    </form>
                                    <form action="{{ route('collaborations.decline', ['project' => $notification->data['project_id'], 'user' => Auth::id()]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-small decline-btn waves-effect">Decline</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- For other notifications, show the modal -->
                    @if(!in_array($type, ['TaskReminderNotification','DebtDeadlineNotification']))
                        <div id="modal-notification-{{ $notification->id }}" class="modal" aria-labelledby="modal-title-{{ $notification->id }}" role="dialog">
                            <div class="modal-content">
                                <h4 id="modal-title-{{ $notification->id }}">{{ $displayType }}</h4>
                                @php
                                    $message = data_get($notification->data, 'message', 'You have a new notification.');
                                    $projectName = data_get($notification->data, 'project_name', '');
                                    $inviterName = data_get($notification->data, 'inviter_name', '');
                                    $removedByName = data_get($notification->data, 'removed_by_name', '');
                                    $collaboratorName = data_get($notification->data, 'collaborator_name', '');
                                    $response = data_get($notification->data, 'response', '');
                                @endphp
                                <p><strong>Message:</strong> {{ $message }}</p>

                                @if($projectName)
                                    <p><strong>Project:</strong> {{ $projectName }}</p>
                                @endif

                                @if($inviterName)
                                    <p><strong>Inviter:</strong> {{ $inviterName }}</p>
                                @endif

                                @if($removedByName)
                                    <p><strong>Removed By:</strong> {{ $removedByName }}</p>
                                @endif

                                @if($collaboratorName)
                                    <p><strong>Collaborator:</strong> {{ $collaboratorName }}</p>
                                @endif

                                @if($response)
                                    <p><strong>Response:</strong> {{ ucfirst($response) }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
        <div class="modal-content">
            <h4 id="delete-modal-title">Confirm Deletion</h4>
            <p>Are you sure you want to delete this notification?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <a href="#!" id="confirm-delete" class="waves-effect waves-grey btn-flat">Delete</a>
        </div>
    </div>

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
        <a href="{{ route('dashboard') }}" class="navbar-item" aria-label="Dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-house-door" aria-hidden="true"></i>
        </a>
        <a href="{{ route('taskmanagement.index') }}" class="navbar-item" aria-label="Task Management" title="Task Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-list-task" aria-hidden="true"></i>
        </a>
        <a href="{{ route('financemanagement.index') }}" class="navbar-item" aria-label="Finance Management" title="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-currency-dollar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('calendar.index') }}" class="navbar-item" aria-label="Calendar" title="Calendar" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-calendar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('notifications.index') }}" class="navbar-item active" aria-label="Notifications" title="Notifications" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bell" aria-hidden="true"></i>
        </a>
        <a href="{{ route('tips') }}" class="navbar-item" aria-label="Tips & Best Practices" title="Tips & Best Practices" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-lightbulb" aria-hidden="true"></i>
        </a>
        <a href="{{ route('reports') }}" class="navbar-item" aria-label="Reports" title="Reports" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bar-chart" aria-hidden="true"></i>
        </a>
    </nav>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading-overlay" style="display: none;"></div>

    <!-- Scripts -->
    <script src="{{ asset('js/loader.js') }}"></script>
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Bootstrap 5 JS (for tooltips) -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ENjdO4Dr2bkBIFxQpeo/ej3V0y4R6/HM0n6pGHrh9W/wPRp74Phb32Dd3HPFjqD" 
        crossorigin="anonymous">
    </script>
    <!-- Custom JS (Notification handling, etc.) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modals
            const modalElems = document.querySelectorAll('.modal');
            M.Modal.init(modalElems, {
                startingTop: '50%',
                endingTop: '50%'
            });

            // Initialize dropdowns
            const dropdownElems = document.querySelectorAll('.dropdown-trigger');
            const dropdownInstances = M.Dropdown.init(dropdownElems, {
                constrainWidth: false,
                coverTrigger: false,
                alignment: 'right',
                hover: false,
                inDuration: 250,
                outDuration: 200
            });

            // Prevent dropdown link from opening modal or redirect
            dropdownElems.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                dropdown.addEventListener('keydown', function(e) {
                    e.stopPropagation();
                });
            });

            let notificationIdToDelete = null;
            const deleteLinks = document.querySelectorAll('.delete-notification');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    notificationIdToDelete = this.getAttribute('data-notification-id');
                    const deleteModal = document.getElementById('delete-confirmation-modal');
                    M.Modal.getInstance(deleteModal).open();
                });
            });

            const confirmDeleteButton = document.getElementById('confirm-delete');
            confirmDeleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (notificationIdToDelete) {
                    deleteNotification(notificationIdToDelete);
                    const deleteModal = document.getElementById('delete-confirmation-modal');
                    M.Modal.getInstance(deleteModal).close();
                    notificationIdToDelete = null;
                } else {
                    M.toast({html: 'No notification selected for deletion.', classes: 'red'});
                }
            });

            const markAllLink = document.getElementById('mark-all-read');
            if (markAllLink) {
                markAllLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetch('{{ route("notifications.markAllAsRead") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const unreadCards = document.querySelectorAll('.notification-card.unread');
                            unreadCards.forEach(card => {
                                card.classList.remove('unread');
                                card.classList.add('read');
                                card.setAttribute('data-status', 'read');
                                card.style.borderLeft = '5px solid #757575';
                            });
                            M.toast({html: 'All notifications marked as read!', classes: 'grey'});
                        } else {
                            M.toast({html: 'Failed to mark all as read.', classes: 'red'});
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all as read:', error);
                        M.toast({html: 'An error occurred.', classes: 'red'});
                    });
                });
            }

            // Handle card clicks (either open modal or redirect)
            const notificationCards = document.querySelectorAll('.notification-card');
            notificationCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const notificationId = card.getAttribute('data-notification-id');
                    const hasModal = card.getAttribute('data-has-modal') === 'true';
                    const redirectUrl = card.getAttribute('data-redirect-url');

                    // Mark as read, then proceed (modal or redirect)
                    markNotificationAsRead(notificationId)
                        .then(() => {
                            if (hasModal) {
                                // open the modal
                                const modalId = redirectUrl.replace('#', '');
                                const modalElement = document.getElementById(modalId);
                                const modalInstance = M.Modal.getInstance(modalElement);
                                modalInstance.open();
                            } else {
                                // redirect to tasks.show or debts.show
                                window.location.href = redirectUrl;
                            }
                        })
                        .catch(err => {
                            console.error('Error marking as read:', err);
                        });
                });

                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        card.click();
                    }
                });
            });

            function markNotificationAsRead(notificationId) {
                return fetch(`/notifications/mark-as-read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notifCard = document.querySelector(`.notification-card[data-notification-id="${notificationId}"]`);
                        if (notifCard) {
                            notifCard.classList.remove('unread');
                            notifCard.classList.add('read');
                            notifCard.setAttribute('data-status', 'read');
                            notifCard.style.borderLeft = '5px solid #757575';
                        }
                        return true;
                    } else {
                        M.toast({html: data.message || 'Failed to mark as read.', classes: 'red'});
                        throw new Error(data.message || 'Failed to mark as read.');
                    }
                });
            }

            function deleteNotification(notificationId) {
                fetch(`/notifications/delete/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationCard = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notificationCard) {
                            notificationCard.classList.add('fade-out');
                            setTimeout(() => {
                                notificationCard.remove();
                                M.toast({html: 'Notification deleted.', classes: 'grey'});
                            }, 500);
                        }
                    } else {
                        M.toast({html: data.message || 'Failed to delete notification.', classes: 'red'});
                    }
                })
                .catch(error => {
                    console.error('Error deleting notification:', error);
                    M.toast({html: 'An error occurred.', classes: 'red'});
                });
            }

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
