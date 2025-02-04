<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Planner Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Include canvas-confetti library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</head>
<body>

    <!-- Welcome Message with Confetti -->
    @if(session('verified'))
        <div id="welcome-message" class="welcome-message" aria-live="assertive" role="alert" style="position: fixed; top: 20px; right: 20px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 2000; display: none;">
            <h4>🎉 Welcome to Smart Planner!</h4>
            <p>Your email has been successfully verified.</p>
        </div>
    @endif

    <!-- Header -->
    <header class="header" role="banner">
        <!-- Header Right: Notification and Profile Icons -->
        <div class="header-right">
            <!-- Notification Bell Icon -->
            <div class="notification-icon" role="button" aria-label="Notifications" title="View Notifications" data-bs-toggle="tooltip" data-bs-placement="top">
                <a href="{{ route('notifications.index') }}" class="text-dark {{ Auth::user()->unreadNotifications->count() > 0 ? 'has-notifications' : '' }}" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </div>

            <!-- Profile Icon -->
            <div class="profile-icon" role="button" aria-label="Profile" title="View Profile" data-bs-toggle="tooltip" data-bs-placement="top">
                <a href="{{ route('profile.index') }}" class="text-dark" aria-label="Profile">
                    <i class="bi bi-person-circle"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="main-content" role="main">
        <!-- Tabs for Task and Finance -->
        <div class="tabs" role="tablist">
            <button class="tab-link active" onclick="openTab(event, 'Task')" role="tab" aria-selected="true" aria-controls="Task" aria-label="Task Management" data-bs-toggle="tooltip" data-bs-placement="top" title="Task Management Tab">
                <i class="material-icons tab-icon" aria-hidden="true">assignment</i>
                Task Management
            </button>
            <button class="tab-link" onclick="openTab(event, 'Finance')" role="tab" aria-selected="false" aria-controls="Finance" aria-label="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top" title="Finance Management Tab">
                <i class="material-icons tab-icon" aria-hidden="true">account_balance</i>
                Finance Management
            </button>
        </div>
        
        <!-- Task Management Section -->
        <div id="Task" class="tab-content active" role="tabpanel" aria-labelledby="Task">
            <div class="task-filter" role="group" aria-label="Task Filters">
                <button class="filter-btn active" onclick="filterTasks('today', event)" aria-pressed="true" aria-label="Filter Tasks for Today" title="Filter Tasks for Today" data-bs-toggle="tooltip" data-bs-placement="top">Today</button>
                <button class="filter-btn" onclick="filterTasks('week', event)" aria-pressed="false" aria-label="Filter Tasks for This Week" title="Filter Tasks for This Week" data-bs-toggle="tooltip" data-bs-placement="top">This Week</button>
                <button class="filter-btn" onclick="filterTasks('month', event)" aria-pressed="false" aria-label="Filter Tasks for This Month" title="Filter Tasks for This Month" data-bs-toggle="tooltip" data-bs-placement="top">This Month</button>
            </div>

            <!-- Task List Container -->
            <div class="task-list" id="task-list">
                <!-- Dynamically injected task cards -->
            </div>
        </div>

        <!-- Finance Tab -->
        <div id="Finance" class="tab-content" role="tabpanel" aria-labelledby="Finance">
            <div class="illustration-container">
                <img src="{{ asset('images/nofinances.png') }}" alt="No Finances Illustration" class="illustration" data-bs-toggle="tooltip" data-bs-placement="top" title="No Finances Available">
            </div>
            <div class="finance-summary">
                <div class="finance-card card" role="region" aria-label="Total Income">
                    <h3>Total Income</h3>
                    <p>${{ number_format($totalIncome, 2) }}</p>
                </div>
                <div class="finance-card card" role="region" aria-label="Total Expenses">
                    <h3>Total Expenses</h3>
                    <p>${{ number_format($totalExpense, 2) }}</p>
                </div>
            </div>

            <hr class="divider">

            <div class="expense-tracker" role="region" aria-labelledby="Expense Distribution">
                <div class="tracker-header">
                    <h2 id="Expense Distribution">Expense Distribution</h2>
                    <select id="expense-filter" onchange="updateChart()" aria-label="Filter Expense Distribution" title="Filter Expense Distribution" data-bs-toggle="tooltip" data-bs-placement="top">
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>

                <div class="chart-wrapper">
                    <div id="loading-spinner" class="loading-spinner" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                    <canvas id="expenseChart" aria-label="Expense Distribution Chart" role="img" data-bs-toggle="tooltip" data-bs-placement="top" title="Expense Distribution Chart"></canvas>
                    <div class="no-data-illustration-container" id="no-data-illustration" aria-hidden="true">
                        <img src="{{ asset('images/expenses.png') }}" alt="No Expense Data" class="no-data-illustration" data-bs-toggle="tooltip" data-bs-placement="top" title="No Expense Data Available">
                        <p id="no-data-text">Nothing this week.</p>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <!-- Budget Planner Section -->
            <div class="budget-planner-section" role="region" aria-labelledby="Budget Planner">
                <div class="tracker-header">
                    <h2 id="Budget Planner">Budget Planner</h2>
                    <select id="budget-filter" onchange="updateBudgetList()" aria-label="Filter Budget Planner" title="Filter Budget Planner" data-bs-toggle="tooltip" data-bs-placement="top">
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
                <!-- Match the size with expense distribution: height fixed to 400px -->
                <div class="white-container" style="background:#fff; padding:20px; border-radius:8px; margin-top:20px; height:400px; display:flex; justify-content:center; align-items:center;">
                    <div id="budget-list-container" class="budget-list-container" style="width:100%;">
                        @if($budgetDataWeek->count() > 0)
                            <div class="budget-list scrollable-horizontal" id="budget-list">
                                @foreach($budgetDataWeek as $budget)
                                    @php
                                        $spentVal = (isset($budget->spent) && is_numeric($budget->spent)) ? floatval($budget->spent) : 0;
                                        $remainingVal = (isset($budget->remaining) && is_numeric($budget->remaining)) ? floatval($budget->remaining) : 0;
                                        $amountVal = (isset($budget->amount) && is_numeric($budget->amount)) ? floatval($budget->amount) : 0;
                                    @endphp
                                    <a href="{{ route('budgets.show', $budget) }}" class="budget-item card" role="article" aria-label="Budget Item" title="View Budget: {{ $budget->category }}">
                                        <h3>{{ $budget->category }}</h3>
                                        <p><strong>Budget:</strong> ${{ number_format($amountVal, 2) }}</p>
                                        <p><strong>Spent:</strong> ${{ number_format($spentVal, 2) }}</p>
                                        <p><strong>Remaining:</strong> ${{ number_format($remainingVal, 2) }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="no-data-white-container" data-bs-toggle="tooltip" data-bs-placement="top" title="No Budget Data" style="display:flex; align-items:center; justify-content:center; flex-direction:column; height:100%;">
                                <div class="no-data-illustration-container">
                                    <img src="{{ asset('images/budgets.png') }}" alt="No Budget Data Illustration" class="no-data-illustration">
                                    <p>No budget data available for this week.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="divider">

            <!-- Financial Goals Overview -->
            <div class="financial-goals-section" role="region" aria-labelledby="Financial Goals">
                <h2 id="Financial Goals">Financial Goals</h2>
                <!-- Match size with expense distribution: height fixed to 400px -->
                <div class="white-container" style="background:#fff; padding:20px; border-radius:8px; margin-top:20px; height:400px; display:flex; justify-content:center; align-items:center;">
                    <div class="goals-container" style="width:100%;">
                        @if($savings->count() > 0)
                            <div class="goals-list scrollable-horizontal">
                                @foreach($savings as $goal)
                                    @php
                                        $progress = $goal->desired_amount > 0 ? ($goal->amount_saved / $goal->desired_amount) * 100 : 0;
                                    @endphp
                                    <a href="{{ route('savings.show', $goal) }}" class="goal-card card" role="article" aria-label="Financial Goal" title="View Financial Goal: {{ $goal->name }}">
                                        <h3>{{ $goal->name }}</h3>
                                        <p>Amount Saved: ${{ number_format($goal->amount_saved, 2) }}</p>
                                        <p>Desired Amount: ${{ number_format($goal->desired_amount, 2) }}</p>
                                        <div class="progress mt-2">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ min($progress, 100) }}%;" aria-valuenow="{{ min($progress, 100) }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format(min($progress, 100), 2) }}%
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="no-data-container" data-bs-toggle="tooltip" data-bs-placement="top" title="No Financial Goals" style="display:flex; align-items:center; justify-content:center; flex-direction:column; height:100%;">
                                <div class="no-data-message">
                                    <img src="{{ asset('images/savings.png') }}" alt="No Financial Goals Illustration" class="no-data-illustration">
                                    <p id="no-data-text">No financial goals available for this week.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>

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

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loading-overlay" style="display: none;">
            <div class="loading-spinner"></div>
        </div>

        <!-- Bootstrap 5 JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Sidebar Script -->
        <script src="{{ asset('js/sidebar.js') }}"></script>

        <!-- Custom JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const menuIcon = document.getElementById('menu-icon');
                const bottomNavbar = document.querySelector('.bottom-navbar');

                if (menuIcon) {
                    menuIcon.addEventListener('click', () => {
                        document.body.classList.toggle('sidebar-open');
                    });
                }

                function checkViewport() {
                    if (window.innerWidth <= 768) {
                        bottomNavbar.style.display = 'flex';
                    } else {
                        bottomNavbar.style.display = 'flex';
                    }
                }

                checkViewport();
                window.addEventListener('resize', checkViewport);
            });

            let currentFilter = 'today';

            function showLoading() {
                document.getElementById('loading-overlay').style.display = 'flex';
            }

            function hideLoading() {
                document.getElementById('loading-overlay').style.display = 'none';
            }

            function openTab(evt, tabName) {
                const tabLinks = document.getElementsByClassName("tab-link");
                const tabContent = document.getElementsByClassName("tab-content");

                for (let i = 0; i < tabContent.length; i++) {
                    tabContent[i].classList.remove("active");
                }

                for (let i = 0; i < tabLinks.length; i++) {
                    tabLinks[i].classList.remove("active");
                }

                document.getElementById(tabName).classList.add("active");
                evt.currentTarget.classList.add("active");

                // When switching to the Task tab, default to 'today'
                if (tabName === 'Task') {
                    currentFilter = 'today';
                    filterTasks(currentFilter);
                } else if (tabName === 'Finance') {
                    updateChart();
                    updateBudgetList();
                }
            }

            const taskShowUrl = "{{ url('tasks') }}/";
            const tasksToday = @json($tasksToday);
            const tasksThisWeek = @json($tasksThisWeek);
            const tasksThisMonth = @json($tasksThisMonth);

            // Group tasks by filter
            const tasks = {
                today: tasksToday,
                week: tasksThisWeek,
                month: tasksThisMonth
            };

            /**
             * Returns true if the task is overdue (strictly before today's date).
             * A task due "today" is not considered overdue.
             */
            function isOverdue(task) {
                if (task.status.toLowerCase() !== 'pending' || !task.due_date) {
                    return false;
                }
                const dueDateTime = new Date(task.due_date);

                // Zero out hours/mins/secs for accurate comparison
                const todayStart = new Date();
                todayStart.setHours(0, 0, 0, 0);

                // Overdue if the due date is strictly before today's date
                return dueDateTime < todayStart;
            }

            /**
             * Populates the .task-list div with task cards,
             * according to the chosen period (today/week/month).
             */
            function filterTasks(period, event, searchQuery = '') {
                currentFilter = period;
                const taskList = document.getElementById("task-list");
                taskList.innerHTML = '';

                // Update filter button states
                const filterBtns = document.querySelectorAll(".filter-btn");
                filterBtns.forEach(btn => {
                    btn.classList.remove("active");
                    btn.setAttribute('aria-pressed', 'false');
                });

                if (event && event.currentTarget) {
                    event.currentTarget.classList.add("active");
                    event.currentTarget.setAttribute('aria-pressed', 'true');
                }

                // If there are no tasks for the chosen period
                if (!tasks[period] || tasks[period].length === 0) {
                    let message = '';
                    if (period === 'today') message = 'No tasks today';
                    else if (period === 'week') message = 'No tasks this week';
                    else if (period === 'month') message = 'No tasks this month';

                    taskList.innerHTML = `
                        <div class="no-data-message" data-bs-toggle="tooltip" data-bs-placement="top" title="${message}">
                            <img src="{{ asset('images/notasks.png') }}" alt="No Tasks Illustration" class="no-data-illustration">
                            <p>${message}</p>
                        </div>
                    `;
                    return;
                }

                // Build and inject task cards
                tasks[period].forEach(task => {
                    const overdueClass = isOverdue(task) ? 'overdue' : '';
                    const taskStatus = task.status.toLowerCase();
                    const isCompleted = (taskStatus === 'completed');

                    // Format date
                    let dueDateStr = '';
                    if (task.due_date) {
                        const dateObj = new Date(task.due_date);
                        dueDateStr = dateObj.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });
                    } else {
                        dueDateStr = 'No due date';
                    }

                    const labelName = task.label ? task.label.name : '';
                    const labelColor = task.label ? task.label.color : '#808080';
                    const priority = task.priority || 'None';

                    const taskCardHtml = `
                        <div class="card task-card ${overdueClass}"
                             data-task-id="${task.id}"
                             data-task-status="${taskStatus}"
                             data-task-priority="${priority.toLowerCase()}"
                             data-task-duedate="${task.due_date || ''}"
                             data-task-label="${labelName}"
                             role="button"
                             tabindex="0"
                             title="View Task: ${task.title}"
                             data-bs-toggle="tooltip"
                             data-bs-placement="top"
                        >
                            <!-- Top-right checkbox to toggle completion -->
                            <div class="task-checkbox">
                                <input type="checkbox"
                                       class="task-complete-checkbox"
                                       data-task-id="${task.id}"
                                       ${isCompleted ? 'checked' : ''}
                                       aria-label="Mark as Completed"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Mark task as completed." />
                            </div>

                            <div class="card-content">
                                <div class="task-info">
                                    <span class="card-title">${task.title}</span>
                                    <p>Due Date: ${dueDateStr}</p>
                                    <p>Priority: ${priority}</p>
                                    <p>
                                        Status:
                                        ${
                                            (taskStatus === 'pending' && overdueClass)
                                            ? '<span class="overdue-status">Overdue</span>'
                                            : task.status
                                        }
                                    </p>
                                    ${
                                        labelName
                                        ? `<span class="label-pill" style="background-color: ${labelColor};">${labelName}</span>`
                                        : ''
                                    }
                                </div>
                            </div>
                        </div>
                    `;
                    taskList.innerHTML += taskCardHtml;
                });

                initTaskCardListeners();
            }

            /**
             * Attach event listeners to each card (navigate on click)
             * and each checkbox (mark complete/incomplete).
             */
            function initTaskCardListeners() {
                // 1. Clicking on a card navigates to the Task show page
                const cards = document.querySelectorAll('.task-card');
                cards.forEach(card => {
                    card.addEventListener('click', () => {
                        const taskId = card.getAttribute('data-task-id');
                        const url = taskShowUrl + taskId;
                        if (url) {
                            window.location.href = url;
                        }
                    });

                    card.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            card.click();
                        }
                    });
                });

                // 2. Checkbox logic: update completion status via Ajax
                const checkboxes = document.querySelectorAll('.task-complete-checkbox');
                checkboxes.forEach(checkbox => {
                    // Prevent card click when toggling checkbox
                    checkbox.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });
                    // On change, send request to update the status
                    checkbox.addEventListener('change', (e) => {
                        e.stopPropagation();
                        const taskId = checkbox.getAttribute('data-task-id');
                        const isChecked = checkbox.checked;

                        showLoading();

                        // Example: PATCH /tasks/{id}/status
                        fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ completed: isChecked })
                        })
                        .then(response => response.json())
                        .then(data => {
                            hideLoading();
                            if (data.success) {
                                // Update the card’s DOM
                                const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
                                const statusP = taskCard.querySelector('.task-info p:nth-of-type(4)');
                                const titleEl = taskCard.querySelector('.card-title');

                                if (isChecked) {
                                    statusP.innerHTML = 'Status: <span class="overdue-status">Completed</span>';
                                    titleEl.style.textDecoration = 'line-through';
                                    titleEl.style.color = '#6c757d';
                                    taskCard.classList.remove('overdue');
                                } else {
                                    statusP.textContent = 'Status: Pending';
                                    titleEl.style.textDecoration = 'none';
                                    titleEl.style.color = '#333';

                                    // Re-check if overdue
                                    const dueDate = taskCard.getAttribute('data-task-duedate');
                                    if (dueDate) {
                                        const dateObj = new Date(dueDate);

                                        const todayStart = new Date();
                                        todayStart.setHours(0,0,0,0);

                                        if (dateObj < todayStart) {
                                            statusP.innerHTML = 'Status: <span class="overdue-status">Overdue</span>';
                                            taskCard.classList.add('overdue');
                                        } else {
                                            taskCard.classList.remove('overdue');
                                        }
                                    }
                                }
                            } else {
                                alert('Failed to update task status: ' + data.message);
                                checkbox.checked = !isChecked; // revert
                            }
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error:', error);
                            alert('An error occurred while updating the task status.');
                            checkbox.checked = !isChecked; // revert
                        });
                    });
                });
            }

            // On initial load, show "today" tasks
            document.addEventListener('DOMContentLoaded', () => {
                filterTasks('today');
            });

            // ---------- FINANCE LOGIC (unchanged) ----------
            const financeLabelsWeek = @json($financeLabelsWeek);
            const financeDataWeek = @json($financeDataWeek);
            const financeLabelsMonth = @json($financeLabelsMonth);
            const financeDataMonth = @json($financeDataMonth);

            let expenseChart = null;

            function updateChart() {
                document.getElementById('loading-spinner').style.display = 'block';

                const period = document.getElementById('expense-filter').value;
                let labels = [];
                let data = [];

                if (period === 'week') {
                    labels = financeLabelsWeek;
                    data = financeDataWeek;
                } else {
                    labels = financeLabelsMonth;
                    data = financeDataMonth;
                }

                const ctx = document.getElementById('expenseChart').getContext('2d');
                const noDataContainer = document.getElementById('no-data-illustration');
                const noDataText = document.getElementById('no-data-text');

                const isDataEmpty = data.length === 0 || data.every(amount => amount === 0);

                if (isDataEmpty) {
                    document.getElementById('expenseChart').style.display = 'none';
                    noDataText.textContent = period === 'week' ? 'Nothing this week.' : 'Nothing this month.';
                    noDataContainer.style.display = 'flex';
                    document.getElementById('loading-spinner').style.display = 'none';
                } else {
                    document.getElementById('expenseChart').style.display = 'block';
                    noDataContainer.style.display = 'none';

                    if (expenseChart) {
                        expenseChart.destroy();
                    }

                    const backgroundColors = [
                        '#4D4D4D', '#666666', '#808080', '#999999',
                        '#B3B3B3', '#CCCCCC', '#E6E6E6', '#333333'
                    ];

                    const assignedColors = backgroundColors.slice(0, labels.length);

                    expenseChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: assignedColors,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        color: '#333',
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            return `${label}: $${value.toLocaleString()}`;
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: `Expense Distribution - ${period === 'week' ? 'This Week' : 'This Month'}`,
                                    color: '#333',
                                    font: {
                                        size: 18
                                    }
                                }
                            },
                            animation: {
                                onComplete: function() {
                                    document.getElementById('loading-spinner').style.display = 'none';
                                }
                            }
                        }
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                updateChart();
            });

            // Budget list logic
            const budgetDataWeek = @json($budgetDataWeek);
            const budgetDataMonth = @json($budgetDataMonth);

            function updateBudgetList() {
                const period = document.getElementById('budget-filter').value;
                const budgetListContainer = document.getElementById('budget-list-container');

                budgetListContainer.innerHTML = '';

                let data = [];
                if (period === 'week') {
                    data = budgetDataWeek;
                } else {
                    data = budgetDataMonth;
                }

                if (!data || data.length === 0) {
                    budgetListContainer.innerHTML = `
                        <div class="no-data-white-container" data-bs-toggle="tooltip" data-bs-placement="top" title="No Budget Data" style="display:flex; align-items:center; justify-content:center; flex-direction:column; height:100%;">
                            <div class="no-data-illustration-container">
                                <img src="{{ asset('images/budgets.png') }}" alt="No Budget Data Illustration" class="no-data-illustration">
                                <p>No budget data available for this ${period === 'week' ? 'week' : 'month'}.</p>
                            </div>
                        </div>
                    `;
                } else {
                    let budgetListHtml = `<div class="budget-list scrollable-horizontal" id="budget-list">`;
                    data.forEach(budget => {
                        const spentVal = (budget.spent && !isNaN(budget.spent)) ? parseFloat(budget.spent) : 0;
                        const remainingVal = (budget.remaining && !isNaN(budget.remaining)) ? parseFloat(budget.remaining) : 0;
                        const amountVal = (budget.amount && !isNaN(budget.amount)) ? parseFloat(budget.amount) : 0;

                        budgetListHtml += `
                            <a href="{{ url('budgets/') }}/${budget.id}" class="budget-item card" role="article" aria-label="Budget Item" title="View Budget: ${budget.category}">
                                <h3>${budget.category}</h3>
                                <p><strong>Budget:</strong> $${amountVal.toFixed(2)}</p>
                                <p><strong>Spent:</strong> $${spentVal.toFixed(2)}</p>
                                <p><strong>Remaining:</strong> $${remainingVal.toFixed(2)}</p>
                            </a>
                        `;
                    });
                    budgetListHtml += `</div>`;
                    budgetListContainer.innerHTML = budgetListHtml;
                }
            }

            // Tooltip initialization
            document.addEventListener('DOMContentLoaded', () => {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Welcome Message and Confetti
                @if(session('verified'))
                    // Show the welcome message
                    const welcomeMessage = document.getElementById('welcome-message');
                    welcomeMessage.style.display = 'block';

                    // Trigger confetti
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 }
                    });

                    // Optionally, hide the message after some time
                    setTimeout(() => {
                        welcomeMessage.style.display = 'none';
                    }, 7000); // 7 seconds
                @endif
            });

            function hideAllTooltips() {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (tooltipTriggerEl) {
                    var tooltipInstance = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                    if (tooltipInstance) {
                        tooltipInstance.hide();
                    }
                });
            }

            document.addEventListener('click', hideAllTooltips);
            document.addEventListener('touchstart', hideAllTooltips);
        </script>
    </body>
</html>
