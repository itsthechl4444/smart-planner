<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}"> <!-- Include taskmanagement.css for tab styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Material Icons (if needed) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" id="menu-icon" tabindex="0" aria-label="Toggle Sidebar" role="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </div>
        <div class="title">Reports</div>
        
        <!-- More Options Icon -->
        <div class="more-options">
            <button id="more-options-btn" class="more-options-btn" aria-haspopup="true" aria-expanded="false" aria-label="More options">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <div id="more-options-dropdown" class="more-options-dropdown" role="menu" aria-labelledby="more-options-btn">
                <a href="{{ route('reports.downloadPdf', ['period' => 'week']) }}" class="dropdown-item" role="menuitem">Download as PDF</a>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <!-- Tabs Section -->
        <div class="tabs" role="tablist">
            <button class="tab-link active" onclick="openTab(event, 'task-reports')" role="tab" aria-selected="true" aria-controls="task-reports">Task Reports</button>
            <button class="tab-link" onclick="openTab(event, 'finance-reports')" role="tab" aria-selected="false" aria-controls="finance-reports">Finance Reports</button>
        </div>

        <!-- Task Reports Section -->
        <div id="task-reports" class="tab-content active" role="tabpanel">
            <div class="task-summary">
                <div class="card completed-card">
                    <h5>Completed</h5>
                    <p id="completed-count">{{ $completedCount }}</p>
                </div>
                <div class="card pending-card">
                    <h5>Pending</h5>
                    <p id="pending-count">{{ $pendingCount }}</p>
                </div>
                <div class="card overdue-card">
                    <h5>Overdue</h5>
                    <p id="overdue-count">{{ $overdueCount }}</p>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Task Distribution Section -->
            <div class="task-distribution report-container">
                <h5>Task Distribution by Label</h5>
                <div class="filter-options">
                    <button onclick="updateChartPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateChartPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>
                <div class="chart-wrapper">
                    <canvas id="taskDistributionChart"></canvas>
                    <!-- No Data Illustration -->
                    <div class="no-data-illustration-container" id="no-data-task-illustration">
                        <img src="{{ asset('images/illustration1.png') }}" alt="No Data" class="no-data-illustration">
                        <p id="no-data-task-text">No data available for the selected period.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Finance Reports Section -->
        <div id="finance-reports" class="tab-content" role="tabpanel">
            <!-- Expense Summary Section -->
            <div class="expense-summary report-container">
                <h5>Expense Summary</h5>
                <div class="filter-options">
                    <button onclick="updateExpenseReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateExpenseReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>
                <!-- Loading Spinner -->
                <div id="expense-loading" class="loading-spinner">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="highlight" id="expense-summary-table">
                    <thead>
                        <tr>
                            <th>Expense Type</th>
                            <th>Amount Spent</th>
                            <th>Percentage of Total Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows Will Be Inserted Here -->
                    </tbody>
                </table>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Income Overview Section -->
            <div class="income-overview report-container">
                <h5>Income Overview</h5>
                <div class="filter-options">
                    <button onclick="updateIncomeReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateIncomeReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>
                <!-- Loading Spinner -->
                <div id="income-loading" class="loading-spinner">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-green-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="highlight" id="income-overview-table">
                    <thead>
                        <tr>
                            <th>Income Source</th>
                            <th>Amount Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows Will Be Inserted Here -->
                    </tbody>
                </table>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Budget Progress Report Section -->
            <div class="budget-progress-report report-container">
                <h5>Budget Progress Report</h5>
                <div class="filter-options">
                    <button onclick="updateBudgetProgressReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateBudgetProgressReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>
                <!-- Loading Spinner -->
                <div id="budget-progress-loading" class="loading-spinner">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-orange-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="highlight" id="budget-progress-table">
                    <thead>
                        <tr>
                            <th>Budget Category</th>
                            <th>Allocated Budget</th>
                            <th>Amount Spent</th>
                            <th>Remaining Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows Will Be Inserted Here -->
                    </tbody>
                </table>
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

    <!-- Loading Overlay (if needed) -->
    <!-- You can include a loading overlay similar to the Dashboard if required -->

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Script -->
    <script src="{{ asset('js/sidebar.js') }}"></script>

    <!-- Custom JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        renderTaskChart(); // Initialize the task distribution chart
        fetchTaskData('week'); // Fetch initial task data
        fetchExpenseData('week'); // Fetch initial expense data
        fetchIncomeData('week'); // Fetch initial income data
        fetchBudgetProgressData('week'); // Fetch initial budget progress data

        // Handle More Options dropdown
        const moreOptionsBtn = document.getElementById('more-options-btn');
        const moreOptionsDropdown = document.getElementById('more-options-dropdown');

        moreOptionsBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent the event from bubbling up
            moreOptionsDropdown.classList.toggle('show');
        });

        // Close the dropdown if the user clicks outside of it
        document.addEventListener('click', (e) => {
            if (!moreOptionsBtn.contains(e.target) && !moreOptionsDropdown.contains(e.target)) {
                moreOptionsDropdown.classList.remove('show');
            }
        });

        // Ensure the no-data container is hidden initially
        document.getElementById('no-data-task-illustration').style.display = 'none';

        // Initialize Bottom Navbar Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Toggle Sidebar
        const menuIcon = document.getElementById('menu-icon');
        const bottomNavbar = document.querySelector('.bottom-navbar');

        menuIcon.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-open');
        });

        // Show bottom navbar on viewport changes if needed
        function checkViewport() {
            if (window.innerWidth <= 768) {
                bottomNavbar.style.display = 'flex';
            } else {
                bottomNavbar.style.display = 'flex';
            }
        }

        // Initial check
        checkViewport();

        // Check on resize
        window.addEventListener('resize', checkViewport);
    });

    // Function to generate light shades of gray colors
    function generateColors(numColors) {
        const backgroundColor = [];
        const borderColor = [];

        const grayShades = [
            'rgba(220, 220, 220, 0.2)',
            'rgba(211, 211, 211, 0.2)',
            'rgba(192, 192, 192, 0.2)',
            'rgba(169, 169, 169, 0.2)',
            'rgba(128, 128, 128, 0.2)',
            'rgba(105, 105, 105, 0.2)',
            'rgba(119, 136, 153, 0.2)',
            'rgba(169, 169, 169, 0.2)',
            'rgba(192, 192, 192, 0.2)',
            'rgba(220, 220, 220, 0.2)'
        ];

        const borderGrayShades = [
            'rgba(220, 220, 220, 1)',
            'rgba(211, 211, 211, 1)',
            'rgba(192, 192, 192, 1)',
            'rgba(169, 169, 169, 1)',
            'rgba(128, 128, 128, 1)',
            'rgba(105, 105, 105, 1)',
            'rgba(119, 136, 153, 1)',
            'rgba(169, 169, 169, 1)',
            'rgba(192, 192, 192, 1)',
            'rgba(220, 220, 220, 1)'
        ];

        for (let i = 0; i < numColors; i++) {
            backgroundColor.push(grayShades[i % grayShades.length]);
            borderColor.push(borderGrayShades[i % borderGrayShades.length]);
        }

        return { backgroundColor, borderColor };
    }

    // Function to fetch task data based on the selected period
    function fetchTaskData(period) {
        fetch(`/task-reports?period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Ensure cookies (like session cookies) are sent
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.statusText})`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('completed-count').innerText = data.completed;
            document.getElementById('pending-count').innerText = data.pending;
            document.getElementById('overdue-count').innerText = data.overdue;
            updateTaskChart(data.labels, data.taskCounts);
        })
        .catch(error => {
            console.error('Error fetching task data:', error);
        });
    }

    // Function to initialize the doughnut chart for task distribution
    function renderTaskChart() {
        const ctx = document.getElementById('taskDistributionChart').getContext('2d');
        window.taskChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [], // Initialize empty labels
                datasets: [{
                    label: 'Task Distribution',
                    data: [], // Initialize empty data
                    backgroundColor: [], // Colors will be set dynamically
                    borderColor: [],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1, // Ensures the chart is a perfect circle
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#555' // Legend text color
                        }
                    }
                }
            }
        });
    }

    // Function to update the task distribution chart with new data
    function updateTaskChart(labels, taskCounts) {
        const noDataContainer = document.getElementById('no-data-task-illustration');
        const noDataText = document.getElementById('no-data-task-text');

        if (labels.length === 0 || taskCounts.every(count => count === 0)) {
            // Hide the chart
            document.getElementById('taskDistributionChart').style.display = 'none';
            // Show the no-data illustration
            noDataText.textContent = 'No data available for the selected period.';
            noDataContainer.style.display = 'flex';
        } else {
            // Show the chart
            document.getElementById('taskDistributionChart').style.display = 'block';
            // Hide the no-data illustration
            noDataContainer.style.display = 'none';
        }

        if (labels.length > 0 && taskCounts.some(count => count > 0)) {
            window.taskChart.data.labels = labels;
            window.taskChart.data.datasets[0].data = taskCounts;

            // Generate light gray colors
            const colors = generateColors(labels.length);
            window.taskChart.data.datasets[0].backgroundColor = colors.backgroundColor;
            window.taskChart.data.datasets[0].borderColor = colors.borderColor;

            window.taskChart.update(); // Refresh the chart with the new data
        }
    }

    // Function to handle task chart period filter button clicks
    function updateChartPeriod(period) {
        fetchTaskData(period);
    }

    // Function to fetch expense data based on the selected period
    function fetchExpenseData(period) {
        // Show loading spinner
        document.getElementById('expense-loading').style.display = 'block';

        fetch(`/expense-reports?period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Ensure cookies are sent
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.statusText})`);
            }
            return response.json();
        })
        .then(data => {
            populateExpenseTable(data.expenseSummary, data.totalBudget, data.totalSpent);
            // Hide loading spinner
            document.getElementById('expense-loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching expense data:', error);
            // Hide loading spinner
            document.getElementById('expense-loading').style.display = 'none';
        });
    }

    // Function to handle expense report period filter button clicks
    function updateExpenseReportPeriod(period) {
        fetchExpenseData(period);
    }

    // Function to populate the Expense Summary table
    function populateExpenseTable(expenseSummary, totalBudget, totalSpent) {
        const tableBody = document.querySelector('#expense-summary-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (expenseSummary.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 3;
            td.textContent = 'No expenses found for the selected period.';
            tr.appendChild(td);
            tableBody.appendChild(tr);
            return;
        }

        expenseSummary.forEach(item => {
            const tr = document.createElement('tr');

            // Expense Type
            const tdCategory = document.createElement('td');
            tdCategory.textContent = item.category;
            tr.appendChild(tdCategory);

            // Amount Spent
            const tdAmount = document.createElement('td');
            tdAmount.textContent = `$${parseFloat(item.amount_spent).toFixed(2)}`;
            tr.appendChild(tdAmount);

            // Percentage of Total Budget
            const tdPercentage = document.createElement('td');
            tdPercentage.textContent = `${item.percentage_of_budget.toFixed(2)}%`;

            // Apply red color if overspent
            if (item.percentage_of_budget > 100) {
                tdPercentage.style.color = 'red';
            } else {
                tdPercentage.style.color = 'green';
            }

            tr.appendChild(tdPercentage);
            tableBody.appendChild(tr);
        });
    }

    // Function to fetch income data based on the selected period
    function fetchIncomeData(period) {
        // Show loading spinner
        document.getElementById('income-loading').style.display = 'block';

        fetch(`/income-reports?period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Ensure cookies are sent
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.statusText})`);
            }
            return response.json();
        })
        .then(data => {
            populateIncomeTable(data.incomeSummary, data.totalIncome);
            // Hide loading spinner
            document.getElementById('income-loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching income data:', error);
            // Hide loading spinner
            document.getElementById('income-loading').style.display = 'none';
        });
    }

    // Function to handle income report period filter button clicks
    function updateIncomeReportPeriod(period) {
        fetchIncomeData(period);
    }

    // Function to populate the Income Overview table
    function populateIncomeTable(incomeSummary, totalIncome) {
        const tableBody = document.querySelector('#income-overview-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (incomeSummary.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 2;
            td.textContent = 'No income records found for the selected period.';
            tr.appendChild(td);
            tableBody.appendChild(tr);
            return;
        }

        incomeSummary.forEach(item => {
            const tr = document.createElement('tr');

            // Income Source
            const tdSource = document.createElement('td');
            tdSource.textContent = item.source_name;
            tr.appendChild(tdSource);

            // Amount Received
            const tdAmount = document.createElement('td');
            tdAmount.textContent = `$${parseFloat(item.amount_received).toFixed(2)}`;
            tr.appendChild(tdAmount);

            tableBody.appendChild(tr);
        });

        // Add total income row
        const trTotal = document.createElement('tr');
        trTotal.classList.add('total-row');

        const tdTotalLabel = document.createElement('td');
        tdTotalLabel.textContent = 'Total Income';
        tdTotalLabel.style.fontWeight = 'bold';
        trTotal.appendChild(tdTotalLabel);

        const tdTotalAmount = document.createElement('td');
        tdTotalAmount.textContent = `$${parseFloat(totalIncome).toFixed(2)}`;
        tdTotalAmount.style.fontWeight = 'bold';
        trTotal.appendChild(tdTotalAmount);

        tableBody.appendChild(trTotal);
    }

    // Function to fetch budget progress data based on the selected period
    function fetchBudgetProgressData(period) {
        // Show loading spinner
        document.getElementById('budget-progress-loading').style.display = 'block';

        fetch(`/budget-progress-reports?period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Ensure cookies are sent
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.statusText})`);
            }
            return response.json();
        })
        .then(data => {
            populateBudgetProgressTable(data.budgetProgress);
            // Hide loading spinner
            document.getElementById('budget-progress-loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching budget progress data:', error);
            // Hide loading spinner
            document.getElementById('budget-progress-loading').style.display = 'none';
        });
    }

    // Function to handle budget progress report period filter button clicks
    function updateBudgetProgressReportPeriod(period) {
        fetchBudgetProgressData(period);
    }

    // Function to populate the Budget Progress table
    function populateBudgetProgressTable(budgetProgress) {
        const tableBody = document.querySelector('#budget-progress-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (budgetProgress.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 4;
            td.textContent = 'No budget records found for the selected period.';
            tr.appendChild(td);
            tableBody.appendChild(tr);
            return;
        }

        budgetProgress.forEach(item => {
            const tr = document.createElement('tr');

            // Budget Category
            const tdCategory = document.createElement('td');
            tdCategory.textContent = item.category;
            tr.appendChild(tdCategory);

            // Allocated Budget
            const tdAllocated = document.createElement('td');
            tdAllocated.textContent = `$${parseFloat(item.allocated_budget).toFixed(2)}`;
            tr.appendChild(tdAllocated);

            // Amount Spent
            const tdSpent = document.createElement('td');
            tdSpent.textContent = `$${parseFloat(item.amount_spent).toFixed(2)}`;
            tr.appendChild(tdSpent);

            // Remaining Budget
            const tdRemaining = document.createElement('td');
            tdRemaining.textContent = `$${parseFloat(item.remaining_budget).toFixed(2)}`;

            // Apply red color if overspent
            if (item.remaining_budget <= 0) {
                tdRemaining.style.color = 'red';
            } else {
                tdRemaining.style.color = 'green';
            }

            tr.appendChild(tdRemaining);

            tableBody.appendChild(tr);
        });
    }

    // Custom Tab Functionality
    function openTab(evt, tabName) {
        const tabLinks = document.getElementsByClassName("tab-link");
        const tabContents = document.getElementsByClassName("tab-content");

        // Hide all tab contents
        for (let i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.remove("active");
            tabContents[i].setAttribute('aria-hidden', 'true');
        }

        // Remove 'active' class from all tab links
        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
            tabLinks[i].setAttribute('aria-selected', 'false');
        }

        // Show the current tab and add 'active' class to the clicked tab
        const currentTabContent = document.getElementById(tabName);
        currentTabContent.classList.add("active");
        currentTabContent.setAttribute('aria-hidden', 'false');
        evt.currentTarget.classList.add("active");
        evt.currentTarget.setAttribute('aria-selected', 'true');
    }
    </script>
</body>
</html>
