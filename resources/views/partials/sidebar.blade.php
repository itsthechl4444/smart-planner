<!-- partials/sidebar.blade.php -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <h1>Smart Planner</h1>
        <div class="sidebar-item">
            <i class="bi bi-house-door"></i> <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <hr>
        <div class="sidebar-item">
            <i class="bi bi-list-task"></i> <a href="{{ route('taskmanagement.index') }}">Task Management</a>
        </div>
        <div class="sidebar-item">
            <i class="bi bi-currency-dollar"></i> <a href="{{ route('financemanagement.index') }}">Finance Management</a>
        </div>
        <hr>
        <div class="sidebar-item">
            <i class="bi bi-calendar"></i> <a href="{{ route('calendar.index') }}">Calendar</a>
        </div>
        <div class="sidebar-item">
            <i class="bi bi-bell"></i> <a href="{{ route('notifications.index') }}">Notifications</a>
        </div>
        <div class="sidebar-item">
            <i class="bi bi-lightbulb"></i> <a href="{{ route('tips') }}">Tips & Best Practices</a>
        </div>
        <hr>
        <div class="sidebar-item">
            <i class="bi bi-bar-chart"></i> <a href="{{ route('reports') }}">Reports</a>
        </div>
        <hr>
    </div>
</aside>
