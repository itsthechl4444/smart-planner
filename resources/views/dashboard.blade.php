<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Planner Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="container">

        <!-- Header -->
        <header class="header">

            <div class="menu-icon" id="menu-icon">
                <i class="bi bi-list"></i>
            </div>

            <div class="title">Smart Planner</div>

            <!-- Notification Bell Icon -->
            <div class="notification-icon">
                <a href="{{ route('notifications.index') }}" class="text-dark">
                    <i class="bi bi-bell"></i>
                    <!-- Optional: Notification Badge -->
                    <!-- <span class="notification-badge">3</span> -->
                </a>
            </div>

            <!-- Profile Icon -->
            <div class="profile-icon">
                <a href="{{ route('profile.index') }}" class="text-dark">
                    <i class="bi bi-person-circle menu-icon"></i>
                </a>
            </div>

        </header>
        <!-- Removed the commented-out search input -->

        @include('partials.sidebar')

        <main class="main-content">

            <!-- Tab Sections for Task and Finance Management -->
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'Task')">
                    <i class="material-icons tab-icon">assignment</i>
                    Task Management
                </button>
                <button class="tab-link" onclick="openTab(event, 'Finance')">
                    <i class="material-icons tab-icon">account_balance</i>
                    Finance Management
                </button>
            </div>

            <!-- Task Management Section -->
            <div id="Task" class="tab-content active">
                <!-- Removed the Task Search Bar -->

                <!-- Task Filter Buttons -->
                <div class="task-filter">
                    <button class="filter-btn active" onclick="filterTasks('today', event)">Today</button>
                    <button class="filter-btn" onclick="filterTasks('week', event)">This Week</button>
                    <button class="filter-btn" onclick="filterTasks('month', event)">This Month</button>
                </div>
                <div class="task-list" id="task-list">
                    <!-- Tasks will be dynamically displayed here -->
                </div>
            </div>

            <!-- Finance Tab -->
            <div id="Finance" class="tab-content">
                <div class="illustration-container">
                    <img src="{{ asset('images/illustration3.png') }}" alt="Illustration" class="illustration">
                </div>
                <div class="finance-summary">
                    <div class="finance-card">
                        <h3>Total Income</h3>
                        <p>${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div class="finance-card">
                        <h3>Total Expenses</h3>
                        <p>${{ number_format($totalExpense, 2) }}</p>
                    </div>
                </div>

                <hr class="divider">

                <div class="expense-tracker">
                    <div class="tracker-header">
                        <h2>Expense Distribution</h2>
                        <select id="expense-filter" onchange="updateChart()">
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>

                    <!-- Chart Container -->
                    <div class="chart-wrapper">
                        <canvas id="expenseChart"></canvas>
                        <!-- No Data Illustration -->
                        <div class="no-data-illustration-container" id="no-data-illustration">
                            <img src="{{ asset('images/illustration1.png') }}" alt="No Data" class="no-data-illustration">
                            <p id="no-data-text">Nothing this week.</p>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <!-- Budget Planner Section -->
                <div class="budget-planner-section">
                    <h2>Budget Planner</h2>
                    <div class="budget-list">
                        @if($budgetDataWeek->count() > 0)
                            @foreach($budgetDataWeek as $budget)
                                <div class="budget-item">
                                    <h3>Category: {{ $budget->category }}</h3>
                                    <p>Allocated Budget: ${{ number_format($budget->amount, 2) }}</p>
                                    <p>Amount Spent: ${{ number_format($budget->spent, 2) }}</p>
                                    <p>Remaining Amount: ${{ number_format($budget->remaining, 2) }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="no-data-message">
                                <img src="{{ asset('images/illustration1.png') }}" alt="No Budget Data" class="no-data-illustration">
                                <p>No budget data available for this week.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="divider">

                <!-- Financial Goals Overview -->
                <div class="financial-goals-section">
                    <h2>Financial Goals</h2>
                    <div class="goals-list">
                        @if($savings->count() > 0)
                            @foreach($savings as $goal)
                                <div class="goal-card">
                                    <h3>{{ $goal->name }}</h3>
                                    <p>Amount Saved: ${{ number_format($goal->amount_saved, 2) }}</p>
                                    <p>Desired Amount: ${{ number_format($goal->desired_amount, 2) }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="no-data-message">
                                <img src="{{ asset('images/illustration1.png') }}" alt="No Savings Goals" class="no-data-illustration">
                                <p>No Savings Goals Yet</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </main>

        <!-- Fab Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>

        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('tasks.create') }}">
                <i class="bi bi-check-circle"></i> New Task
            </div>
            <div class="fab-option" data-action="{{ route('labels.create') }}">
                <i class="bi bi-tag"></i> New Label
            </div>
            <div class="fab-option" data-action="{{ route('projects.create') }}">
                <i class="bi bi-folder"></i> New Project
            </div>
            <div class="fab-option" data-action="{{ route('incomes.create') }}">
                <i class="bi bi-wallet2"></i> New Income
            </div>
            <div class="fab-option" data-action="{{ route('expenses.create') }}">
                <i class="bi bi-cash-stack"></i> New Expense
            </div>
        </div>
    </div>

    <!-- My scripts go here -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuIcon = document.getElementById('menu-icon');
            const container = document.querySelector('.container');
            const fab = document.getElementById('fab');
            const fabOptions = document.getElementById('fab-options');

            fab.addEventListener('click', () => {
                fabOptions.classList.toggle('show');
            });

            fabOptions.addEventListener('click', (e) => {
                const option = e.target.closest('.fab-option');
                if (option && option.dataset.action) {
                    window.location.href = option.dataset.action;
                }
            });

            // Removed Search Functionality

        });

        let currentFilter = 'today'; // Default filter

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

            // Set the current filter based on the active tab
            if (tabName === 'Task') {
                currentFilter = 'today'; // Reset to default or any desired default
                filterTasks(currentFilter);
            } else if (tabName === 'Finance') {
                updateChart();
            }
        }

        // Initialize tasks data
        const tasksToday = @json($tasksToday);
        const tasksThisWeek = @json($tasksThisWeek);
        const tasksThisMonth = @json($tasksThisMonth);

        const tasks = {
            today: tasksToday,
            week: tasksThisWeek,
            month: tasksThisMonth
        };

        function filterTasks(period, event, searchQuery = '') {
            currentFilter = period; // Update the current filter
            const taskList = document.getElementById("task-list");
            taskList.innerHTML = '';

            // Clear existing active state from buttons
            const filterBtns = document.getElementsByClassName("filter-btn");
            for (let i = 0; i < filterBtns.length; i++) {
                filterBtns[i].classList.remove("active");
            }

            // Add active state to the clicked button if event is provided
            if (event && event.currentTarget) {
                event.currentTarget.classList.add("active");
            }

            // Check if data exists for the selected period
            if (!tasks[period] || tasks[period].length === 0) {
                let message = '';
                if (period === 'today') {
                    message = 'No tasks today';
                } else if (period === 'week') {
                    message = 'No tasks this week';
                } else if (period === 'month') {
                    message = 'No tasks this month';
                }
                taskList.innerHTML = `
                    <div class="no-data-message">
                        <img src="{{ asset('images/illustration1.png') }}" alt="No Tasks" class="no-data-illustration">
                        <p>${message}</p>
                    </div>
                `;
            } else {
                // Display tasks without search filtering
                tasks[period].forEach(task => {
                    const labelName = task.label ? task.label.name : '';
                    const projectName = task.project ? task.project.name : '';
                    const taskItem = `
                        <div class="task-card">
                            <h3>${task.title}</h3>
                            <p>Project: ${projectName}</p>
                            <p>Due: ${new Date(task.due_date).toLocaleString()}</p>
                            <span class="task-label">${labelName}</span>
                        </div>
                    `;
                    taskList.innerHTML += taskItem;
                });
            }
        }

        // Initialize by displaying today's tasks
        document.addEventListener('DOMContentLoaded', () => {
            filterTasks('today'); // Ensure today's tasks are shown and button is active
        });


        // Initialize finance data (using separate labels and data arrays)
        const financeLabelsWeek = @json($financeLabelsWeek);
        const financeDataWeek = @json($financeDataWeek);
        const financeLabelsMonth = @json($financeLabelsMonth);
        const financeDataMonth = @json($financeDataMonth);

        // Initialize chart variable at the top
        let expenseChart = null;

        function updateChart() {
            const period = document.getElementById('expense-filter').value;
            let labels = [];
            let data = [];

            if (period === 'week') {
                labels = financeLabelsWeek;
                data = financeDataWeek;
            } else if (period === 'month') {
                labels = financeLabelsMonth;
                data = financeDataMonth;
            }

            const ctx = document.getElementById('expenseChart').getContext('2d');
            const noDataContainer = document.getElementById('no-data-illustration');
            const noDataText = document.getElementById('no-data-text');

            // Check if data is empty or all zeros
            const isDataEmpty = data.length === 0 || data.every(amount => amount === 0);

            if (isDataEmpty) {
                // Hide the chart
                document.getElementById('expenseChart').style.display = 'none';
                // Update and show the no-data illustration
                noDataText.textContent = period === 'week' ? 'Nothing this week.' : 'Nothing this month.';
                noDataContainer.style.display = 'flex';
            } else {
                // Show the chart
                document.getElementById('expenseChart').style.display = 'block';
                // Hide the no-data illustration
                noDataContainer.style.display = 'none';
            }

            if (!isDataEmpty) {
                // If the chart already exists, destroy it before creating a new one
                if (expenseChart) {
                    expenseChart.destroy();
                }

                // Define a consistent color palette
                const backgroundColors = [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#FFCD56',
                    '#C9CBCF'
                ];

                // Assign colors based on the number of categories
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
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: $${tooltipItem.raw.toLocaleString()}`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: `Expense Distribution - ${period === 'week' ? 'This Week' : 'This Month'}`
                            }
                        }
                    }
                });
            }
        }

        // Optionally, initialize the chart with default filter (week)
        document.addEventListener('DOMContentLoaded', () => {
            const currentPeriod = document.getElementById('expense-filter').value;
            updateChart();
        });
    </script>
</body>

</html>
