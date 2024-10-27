<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}"> <!-- Include taskmanagement.css for tab styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Remove Materialize CSS as it's no longer needed -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
    
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
</head>
<body>
    <header class="header">
        <div class="menu-icon" id="menu-icon">
            <i class="bi bi-list"></i>
        </div>
        <div class="title">Reports</div>
    </header>

    @include('partials.sidebar')

    <main class="main-content">
        <!-- Custom Tabs Section -->
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'task-reports')">Task Reports</button>
            <button class="tab-link" onclick="openTab(event, 'finance-reports')">Finance Reports</button>
        </div>

        <!-- Task Reports Section -->
        <div id="task-reports" class="tab-content active">
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

            <!-- Line Divider -->
            <div class="divider"></div>

            <!-- Task Distribution Section -->
            <div class="task-distribution">
                <h5>Task Distribution by Label</h5>
                <div class="filter-options">
                    <button onclick="updateChartPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateChartPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>
                <!-- Canvas for Donut Chart -->
                <canvas id="taskDistributionChart" width="400" height="400"></canvas>
            </div>
        </div>

        <!-- Finance Reports Section -->
        <div id="finance-reports" class="tab-content">
            <!-- Add a loading spinner above the Expense Summary table -->
            <div id="expense-loading" style="display: none; text-align: center; margin-top: 20px;">
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

            <!-- Expense Summary Section -->
            <div class="other-section">
                <h5>Expense Summary</h5>
                <div class="filter-options">
                    <button onclick="updateExpenseReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateExpenseReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
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

            <!-- Line Divider -->
            <div class="divider"></div>

            <!-- Income Overview Section -->
            <div class="income-overview other-section">
                <h5>Income Overview</h5>
                <div class="filter-options">
                    <button onclick="updateIncomeReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateIncomeReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>

                <!-- Add a loading spinner above the Income Overview table -->
                <div id="income-loading" style="display: none; text-align: center; margin-top: 20px;">
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

                <!-- Income Overview Table -->
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

            <!-- Line Divider -->
            <div class="divider"></div>

            <!-- Budget Progress Report Section -->
            <div class="budget-progress-report other-section">
                <h5>Budget Progress Report</h5>
                <div class="filter-options">
                    <button onclick="updateBudgetProgressReportPeriod('week')" class="btn waves-effect waves-light">This Week</button>
                    <button onclick="updateBudgetProgressReportPeriod('month')" class="btn waves-effect waves-light">This Month</button>
                </div>

                <!-- Add a loading spinner above the Budget Progress table -->
                <div id="budget-progress-loading" style="display: none; text-align: center; margin-top: 20px;">
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

                <!-- Budget Progress Table -->
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

    <!-- Include Sidebar JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        renderTaskChart(); // Initialize the task distribution chart
        fetchTaskData('week'); // Fetch initial task data
        fetchExpenseData('week'); // Fetch initial expense data
        fetchIncomeData('week'); // Fetch initial income data
        fetchBudgetProgressData('week'); // Fetch initial budget progress data
    });

    // Function to generate random colors
    function generateColors(numColors) {
        const backgroundColor = [];
        const borderColor = [];

        for (let i = 0; i < numColors; i++) {
            const color = getRandomColor();
            backgroundColor.push(color.background);
            borderColor.push(color.border);
        }

        return { backgroundColor, borderColor };
    }

    // Function to get a random color
    function getRandomColor() {
        const r = Math.floor(Math.random() * 200);
        const g = Math.floor(Math.random() * 200);
        const b = Math.floor(Math.random() * 200);
        return {
            background: `rgba(${r}, ${g}, ${b}, 0.2)`,
            border: `rgba(${r}, ${g}, ${b}, 1)`
        };
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
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    }

    // Function to update the task distribution chart with new data
    function updateTaskChart(labels, taskCounts) {
        window.taskChart.data.labels = labels;
        window.taskChart.data.datasets[0].data = taskCounts;

        // Generate colors if necessary
        if (window.taskChart.data.datasets[0].backgroundColor.length !== labels.length) {
            const colors = generateColors(labels.length);
            window.taskChart.data.datasets[0].backgroundColor = colors.backgroundColor;
            window.taskChart.data.datasets[0].borderColor = colors.borderColor;
        }

        window.taskChart.update(); // Refresh the chart with the new data
    }

    // Function to handle task chart period filter button clicks
    function updateChartPeriod(period) {
        fetchTaskData(period);
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
        }

        // Remove 'active' class from all tab links
        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
        }

        // Show the current tab and add 'active' class to the clicked tab
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
    </script>
</body>
</html>
