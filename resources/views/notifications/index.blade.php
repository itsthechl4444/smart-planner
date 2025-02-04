<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications - Smart Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS (for tooltips and consistent styling) -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        integrity="sha384-rbsA2VBKQfE3UHGbwD4BumPEz9F7B4ZK1rxFKe3T2YdY8FNCAZ0FctnX8KZw1T3N" 
        crossorigin="anonymous"
    >

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
        <div class="menu-icon" id="menu-icon" tabindex="0" aria-label="Toggle Sidebar" role="button">
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
            <div class="card-panel grey lighten-4 grey-text text-darken-4">
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
            <a href="{{ route('notifications.index', ['filter' => 'all']) }}" class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('notifications.index', ['filter' => 'read']) }}" class="filter-btn {{ $filter === 'read' ? 'active' : '' }}">Read</a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="filter-btn {{ $filter === 'unread' ? 'active' : '' }}">Unread</a>
        </div>

        @if(!$notifications->isEmpty())
            <!-- Mark All as Read Link -->
            <div class="mark-all-container">
                <a href="#" id="mark-all-read" class="mark-all-link">
                    Mark All as Read
                </a>
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
                    @endphp
                    <div class="card notification-card modal-trigger 
                         {{ is_null($notification->read_at) ? 'unread' : 'read' }}"
                         data-target="modal-notification-{{ $notification->id }}"
                         data-status="{{ is_null($notification->read_at) ? 'unread' : 'read' }}"
                         data-type="{{ $type }}"
                         data-notification-id="{{ $notification->id }}"
                         tabindex="0" 
                         aria-label="Notification: {{ data_get($notification->data, 'message', 'You have a new notification.') }}"
                         role="button">
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
                                <span class="card-title">{{ $displayType }}</span>
                                
                                <!-- More Options Dropdown Trigger -->
                                <a class='dropdown-trigger more-options' href='#' data-target='dropdown-{{ $notification->id }}' tabindex="0" aria-label="More options for this notification" role="button">
                                    <i class="material-icons">more_vert</i>
                                </a>

                                <!-- Dropdown Menu -->
                                <ul id='dropdown-{{ $notification->id }}' class='dropdown-content'>
                                    <li>
                                        <a href="#!" class="delete-notification" data-notification-id="{{ $notification->id }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <p class="notification-message">{{ data_get($notification->data, 'message', 'You have a new notification.') }}</p>
                            <p class="grey-text text-darken-2 notification-time">{{ $notification->created_at->diffForHumans() }}</p>

                            @if(in_array($type, ['ProjectInvitationNotification']))
                                <div class="notification-actions" onclick="event.stopPropagation();">
                                    <form action="{{ route('collaborations.accept', ['project' => $notification->data['project_id'], 'user' => Auth::id()]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <!-- Updated button class for Accept -->
                                        <button type="submit" class="btn-small accept-btn waves-effect">Accept</button>
                                    </form>
                                    <form action="{{ route('collaborations.decline', ['project' => $notification->data['project_id'], 'user' => Auth::id()]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <!-- Updated button class for Decline -->
                                        <button type="submit" class="btn-small decline-btn waves-effect">Decline</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Notification Modal -->
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
                        <!-- Modal footer removed as requested -->
                    </div>
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

    <!-- Bottom Navbar (Copied Exactly from Tips) -->
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
    <!-- End of Bottom Navbar -->

    <!-- Scripts -->
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- Bootstrap 5 JS Bundle (for tooltips) -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ENjdO4Dr2bkBIFxQpeo/ej3V0y4R6/HM0n6pGHrh9W/wPRp74Phb32Dd3HPFjqD" 
        crossorigin="anonymous">
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalElems = document.querySelectorAll('.modal');
            // Center modals in the middle; keep top at 50% so it's vertically centered
            var modalInstances = M.Modal.init(modalElems, {
                startingTop: '50%',
                endingTop: '50%'
            });

            var dropdownElems = document.querySelectorAll('.dropdown-trigger');
            var dropdownInstances = M.Dropdown.init(dropdownElems, {
                constrainWidth: false,
                coverTrigger: false,
                alignment: 'right',
                hover: false,
                inDuration: 250,
                outDuration: 200
            });

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
                    const deleteModalInstance = M.Modal.getInstance(deleteModal);
                    deleteModalInstance.open();
                });
            });

            const confirmDeleteButton = document.getElementById('confirm-delete');
            confirmDeleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (notificationIdToDelete) {
                    deleteNotification(notificationIdToDelete);
                    const deleteModal = document.getElementById('delete-confirmation-modal');
                    const deleteModalInstance = M.Modal.getInstance(deleteModal);
                    deleteModalInstance.close();
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

            const notificationCards = document.querySelectorAll('.notification-card');
            notificationCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    const modalId = card.getAttribute('data-target');
                    openModal(modalId);
                });

                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const modalId = card.getAttribute('data-target');
                        openModal(modalId);
                    }
                });
            });

            function openModal(modalId) {
                const modalElement = document.getElementById(modalId);
                const modalInstance = M.Modal.getInstance(modalElement);
                modalInstance.open();

                const notificationId = modalId.replace('modal-notification-', '');
                const notificationCard = document.querySelector(`.notification-card[data-notification-id="${notificationId}"]`);

                if (notificationCard && notificationCard.classList.contains('unread')) {
                    fetch(`/notifications/mark-as-read/${notificationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notificationCard.classList.remove('unread');
                            notificationCard.classList.add('read');
                            notificationCard.setAttribute('data-status', 'read');
                            notificationCard.style.borderLeft = '5px solid #757575';
                            M.toast({html: 'Notification marked as read.', classes: 'grey'});
                        } else {
                            M.toast({html: data.message || 'Failed to mark as read.', classes: 'red'});
                        }
                    })
                    .catch(error => {
                        console.error('Error marking as read:', error);
                        M.toast({html: 'An error occurred.', classes: 'red'});
                    });
                }
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
