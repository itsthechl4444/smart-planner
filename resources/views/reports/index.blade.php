<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Favicon -->
   <link rel="icon" href="/images/LogoPNG.png" type="image/png">
  <title>Reports</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Material Symbols Outlined (alternative for more_horiz) -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

  <!-- Include Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

  <!-- Inline Custom CSS -->
  <style>
    /* =========================================
       1. Global Styles
    ========================================= */
    body {
      font-family: "Open Sans", sans-serif;
      margin: 0;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      color: #808080;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    /* Header: Center the title and absolutely position the more-options icon */
    .header {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center; /* center the title horizontally */
      padding: 10px 20px;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      height: 70px;
    }

    .title {
      font-size: 20px;
      font-weight: 500;
      color: #555;
      /* Removed flex: 1; so it doesn't push content */
    }

    .more-options {
      position: absolute;
      right: 20px; /* Place the icon on the far right */
    }

    .divider {
      margin: 30px 0;
      border-top: 1px solid #ddd;
      width: 100%;
    }

    /* Increased bottom padding to ensure content
       isn't blocked by the bottom navbar */
    .main-content {
      padding: 80px 20px 120px;
      overflow-y: auto; /* Allows vertical scrolling */
      min-height: 100vh; /* Ensures the container covers the viewport height */
    }

    /* =========================================
       2. Tabs Styles
    ========================================= */
    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      border-bottom: 1px solid #e0e0e0;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      padding: 0 10px;
      min-width: 0;
    }

    .tabs::-webkit-scrollbar {
      display: none;
    }
    .tabs {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .tab-link {
      flex: 0 0 auto;
      background-color: transparent;
      border: none;
      outline: none;
      padding: 14px 20px;
      cursor: pointer;
      font-size: 16px;
      color: #555;
      border-bottom: 2px solid transparent;
      transition: border-color 0.3s ease, color 0.3s ease;
    }

    .tab-link:hover {
      color: #333;
    }

    .tab-link.active {
      color: #333;
      border-bottom: 2px solid #808080;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    /* =========================================
       3. Report Containers
    ========================================= */
    .report-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      position: relative;
    }

    .chart-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      aspect-ratio: 1 / 1;
      max-width: 400px;
      width: 100%;
      height: auto;
      margin: 20px auto 0 auto;
    }

    .task-distribution.report-container .chart-wrapper canvas {
      width: 100% !important;
      height: 100% !important;
    }

    .no-data-illustration-container {
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #6c757d;
    }

    .no-data-illustration-container img {
      max-width: 150px;
      margin-bottom: 10px;
    }

    .no-data-illustration-container p {
      font-size: 1rem;
    }

    /* =========================================
       4. Task Summary Cards
    ========================================= */
    .task-summary {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      flex-wrap: nowrap;
      gap: 20px;
      margin-bottom: 20px;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scroll-behavior: smooth;
      position: relative;
    }

    .task-summary::-webkit-scrollbar {
      display: none;
    }
    .task-summary {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .task-summary .card {
      flex: 0 0 auto;
      width: 200px;
      background-color: #f0f0f0;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      text-align: center;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      cursor: default;
    }

    .task-summary .card:hover {
      transform: scale(1.02);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .completed-card {
      background-color: #e8e8e8;
    }

    .pending-card {
      background-color: #e0e0e0;
    }

    .overdue-card {
      background-color: #d5d5d5;
    }

    .task-summary .card h5 {
      font-size: 18px;
      color: #555;
      margin-bottom: 10px;
    }

    .task-summary .card p {
      font-size: 24px;
      color: #333;
      font-weight: bold;
      margin: 0;
    }

    @media (max-width: 768px) {
      .task-summary {
        gap: 15px;
      }
      .task-summary .card {
        width: 180px;
        padding: 18px;
      }
    }

    @media (max-width: 480px) {
      .task-summary {
        /* Keep horizontal scroll; do not stack vertically */
      }
      .task-summary .card {
        width: 180px;
        padding: 15px;
      }
    }

    /* Center the .task-summary on desktop (≥992px) */
    @media (min-width: 992px) {
      .task-summary {
        justify-content: center;
      }
    }

    /* =========================================
       5. Filter Buttons - Updated to Light Gray
    ========================================= */
    .filter-options {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .filter-options .btn {
      background-color: #e0e0e0 !important;
      color: #555 !important;
      border: 1px solid #ccc !important;
      cursor: pointer;
      padding: 8px 16px;
      border-radius: 4px;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 14px;
    }

    .filter-options .btn:hover,
    .filter-options .btn:focus {
      background-color: #d5d5d5 !important;
      color: #333 !important;
    }

    .filter-options .btn.active {
      background-color: #c0c0c0 !important;
      color: #333 !important;
      border-color: #b3b3b3 !important;
    }

    @media (max-width: 768px) {
      .filter-options .btn {
        padding: 6px 12px;
        font-size: 12px;
      }
    }

    @media (max-width: 480px) {
      .filter-options {
        flex-wrap: nowrap; /* keep them in one line if possible */
        overflow-x: auto;  /* allow horizontal scroll if needed */
      }
    }

    /* =========================================
       6. Tables (Finance Reports)
    ========================================= */
    table.highlight {
      background-color: #fff;
      width: 100%;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    table.highlight th,
    table.highlight td {
      padding: 15px;
      text-align: left;
      font-size: 16px;
      color: #555;
      border-bottom: 1px solid #ddd;
    }

    table.highlight th {
      background-color: #e8e8e8;
      font-weight: bold;
    }

    table.highlight td {
      background-color: #f9f9f9;
    }

    table.highlight tr.total-row td {
      font-weight: bold;
    }

    @media (max-width: 768px) {
      table.highlight th,
      table.highlight td {
        padding: 10px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      table.highlight th,
      table.highlight td {
        padding: 8px;
        font-size: 12px;
      }
      .report-container {
        padding: 15px;
      }
    }

    /* =========================================
       7. Loading Spinners (Creative Ripple Spinner)
    ========================================= */
    .spinner {
      position: relative;
      width: 40px;
      height: 40px;
      margin: 20px auto;
    }
    .spinner::before,
    .spinner::after {
      content: "";
      position: absolute;
      border: 4px solid #808080;
      border-radius: 50%;
      animation: ripple 1s linear infinite;
    }
    .spinner::before {
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    }
    .spinner::after {
      width: 100%;
      height: 100%;
      top: 4px;
      left: 4px;
      border-color: transparent;
      border-top-color: #808080;
      animation-delay: 0.5s;
    }
    @keyframes ripple {
      0% {
        transform: scale(0);
        opacity: 1;
      }
      100% {
        transform: scale(1.5);
        opacity: 0;
      }
    }

    /* =========================================
       8. More Options Dropdown
    ========================================= */
    .more-options-btn {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 24px;
      color: #555;
      padding: 8px;
      border-radius: 50%;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .more-options-btn:hover {
      background-color: rgba(0, 0, 0, 0.05);
    }

    .more-options-dropdown {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background-color: #fff; /* White background */
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      border-radius: 4px;
      z-index: 1002;
      min-width: 160px;
    }

    .more-options-dropdown.show {
      display: block;
    }

    .more-options-dropdown .dropdown-item {
      padding: 10px 16px;
      text-decoration: none;
      display: block;
      color: #333; /* Dark text on white background */
      transition: background-color 0.2s ease;
    }

    .more-options-dropdown .dropdown-item:hover {
      background-color: #f0f0f0;
    }

    /* =========================================
       9. Bottom Navbar Styles
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
      color: #ffffff;
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

    /* =========================================
       10. Accessibility & Misc
    ========================================= */
    .no-data-message p,
    .finance-summary h3,
    .finance-summary p,
    .budget-item p,
    .goal-card p,
    .budget-planner-section h2,
    .financial-goals-section h2,
    .tracker-header h2,
    .chart-wrapper .chart-title,
    .task-filter .filter-btn,
    .task-card p,
    .finance-card p,
    .goal-card h3 {
      color: #333;
    }

    .tooltip-inner {
      background-color: #333 !important;
      color: #fff !important;
      border-radius: 4px !important;
      padding: 5px 10px !important;
      font-size: 14px !important;
    }

    .tooltip-arrow::before {
      border-top-color: #333 !important;
    }
  </style>
</head>
<body>
  @include('partials.loader')
  <!-- Header -->
  <header class="header">
    <div class="title">Reports</div>
    
    <!-- More Options Icon -->
    <div class="more-options">
      <button id="more-options-btn" class="more-options-btn" aria-haspopup="true" aria-expanded="false" aria-label="More options">
        <!-- material icon 'more_horiz' -->
        <i class="material-icons">more_horiz</i>
      </button>
      <div id="more-options-dropdown" class="more-options-dropdown" role="menu" aria-labelledby="more-options-btn">
        <a href="{{ route('reports.downloadPdf', ['period' => 'week']) }}" class="dropdown-item" role="menuitem">Download as PDF</a>
      </div>
    </div>
  </header>

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
          <div class="spinner"></div>
        </div>
        <table class="highlight" id="expense-summary-table">
          <thead>
            <tr>
              <th>Expense Type</th>
              <th>Amount Spent</th>
              <th>Percentage of Allocated Budget</th>
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
          <div class="spinner"></div>
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
          <div class="spinner"></div>
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

  <!-- Bootstrap 5 JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Include your custom loader JS file -->
   <script src="{{ asset('js/loader.js') }}"></script> 

  <!-- Custom JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart + Data initialization
        renderTaskChart(); // Initialize task distribution chart
        fetchTaskData('week');       // Initial task data (week)
        fetchExpenseData('week');    // Initial expense data (week)
        fetchIncomeData('week');     // Initial income data (week)
        fetchBudgetProgressData('week'); // Initial budget progress data (week)

        // More Options Dropdown
        const moreOptionsBtn = document.getElementById('more-options-btn');
        const moreOptionsDropdown = document.getElementById('more-options-dropdown');
        moreOptionsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            moreOptionsDropdown.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!moreOptionsBtn.contains(e.target) && !moreOptionsDropdown.contains(e.target)) {
                moreOptionsDropdown.classList.remove('show');
            }
        });

        // Hide no-data container initially
        document.getElementById('no-data-task-illustration').style.display = 'none';

        // Initialize tooltips for bottom navbar
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Generate colors for charts
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

    // =============================
    // Task Data & Chart
    // =============================
    function fetchTaskData(period) {
      fetch(`/task-reports?period=${period}`, {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
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

    function renderTaskChart() {
      const ctx = document.getElementById('taskDistributionChart').getContext('2d');
      window.taskChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: [],
          datasets: [{
            label: 'Task Distribution',
            data: [],
            backgroundColor: [],
            borderColor: [],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          aspectRatio: 1,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: { color: '#555' }
            }
          }
        }
      });
    }

    function updateTaskChart(labels, taskCounts) {
      const noDataContainer = document.getElementById('no-data-task-illustration');
      const noDataText = document.getElementById('no-data-task-text');
      if (labels.length === 0 || taskCounts.every(count => count === 0)) {
        document.getElementById('taskDistributionChart').style.display = 'none';
        noDataText.textContent = 'No data available for the selected period.';
        noDataContainer.style.display = 'flex';
      } else {
        document.getElementById('taskDistributionChart').style.display = 'block';
        noDataContainer.style.display = 'none';
      }
      if (labels.length > 0 && taskCounts.some(count => count > 0)) {
        window.taskChart.data.labels = labels;
        window.taskChart.data.datasets[0].data = taskCounts;
        const colors = generateColors(labels.length);
        window.taskChart.data.datasets[0].backgroundColor = colors.backgroundColor;
        window.taskChart.data.datasets[0].borderColor = colors.borderColor;
        window.taskChart.update();
      }
    }

    function updateChartPeriod(period) {
      fetchTaskData(period);
    }

    // =============================
    // Expense Data
    // =============================
    function fetchExpenseData(period) {
      document.getElementById('expense-loading').style.display = 'block';
      fetch(`/expense-reports?period=${period}`, {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Network response was not ok (${response.statusText})`);
        }
        return response.json();
      })
      .then(data => {
        populateExpenseTable(data.expenseSummary, data.totalBudget, data.totalSpent);
        document.getElementById('expense-loading').style.display = 'none';
      })
      .catch(error => {
        console.error('Error fetching expense data:', error);
        document.getElementById('expense-loading').style.display = 'none';
      });
    }

    function updateExpenseReportPeriod(period) {
      fetchExpenseData(period);
    }

    function populateExpenseTable(expenseSummary, totalBudget, totalSpent) {
      const tableBody = document.querySelector('#expense-summary-table tbody');
      tableBody.innerHTML = '';
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

        const tdCategory = document.createElement('td');
        tdCategory.textContent = item.category;
        tr.appendChild(tdCategory);

        const tdAmount = document.createElement('td');
        tdAmount.textContent = 'PHP ' + parseFloat(item.amount_spent).toFixed(2);
        tr.appendChild(tdAmount);

        const tdPercentage = document.createElement('td');
        tdPercentage.textContent = `${item.percentage_of_budget.toFixed(2)}%`;
        tdPercentage.style.color = item.percentage_of_budget > 100 ? 'red' : 'green';
        tr.appendChild(tdPercentage);

        tableBody.appendChild(tr);
      });
    }

    // =============================
    // Income Data
    // =============================
    function fetchIncomeData(period) {
      document.getElementById('income-loading').style.display = 'block';
      fetch(`/income-reports?period=${period}`, {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Network response was not ok (${response.statusText})`);
        }
        return response.json();
      })
      .then(data => {
        populateIncomeTable(data.incomeSummary, data.totalIncome);
        document.getElementById('income-loading').style.display = 'none';
      })
      .catch(error => {
        console.error('Error fetching income data:', error);
        document.getElementById('income-loading').style.display = 'none';
      });
    }

    function updateIncomeReportPeriod(period) {
      fetchIncomeData(period);
    }

    function populateIncomeTable(incomeSummary, totalIncome) {
      const tableBody = document.querySelector('#income-overview-table tbody');
      tableBody.innerHTML = '';
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

        const tdSource = document.createElement('td');
        tdSource.textContent = item.source_name;
        tr.appendChild(tdSource);

        const tdAmount = document.createElement('td');
        tdAmount.textContent = 'PHP ' + parseFloat(item.amount_received).toFixed(2);
        tr.appendChild(tdAmount);

        tableBody.appendChild(tr);
      });

      const trTotal = document.createElement('tr');
      trTotal.classList.add('total-row');

      const tdTotalLabel = document.createElement('td');
      tdTotalLabel.textContent = 'Total Income';
      tdTotalLabel.style.fontWeight = 'bold';
      trTotal.appendChild(tdTotalLabel);

      const tdTotalAmount = document.createElement('td');
      tdTotalAmount.textContent = 'PHP ' + parseFloat(totalIncome).toFixed(2);
      tdTotalAmount.style.fontWeight = 'bold';
      trTotal.appendChild(tdTotalAmount);

      tableBody.appendChild(trTotal);
    }

    // =============================
    // Budget Progress Data
    // =============================
    function fetchBudgetProgressData(period) {
      document.getElementById('budget-progress-loading').style.display = 'block';
      fetch(`/budget-progress-reports?period=${period}`, {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Network response was not ok (${response.statusText})`);
        }
        return response.json();
      })
      .then(data => {
        populateBudgetProgressTable(data.budgetProgress);
        document.getElementById('budget-progress-loading').style.display = 'none';
      })
      .catch(error => {
        console.error('Error fetching budget progress data:', error);
        document.getElementById('budget-progress-loading').style.display = 'none';
      });
    }

    function updateBudgetProgressReportPeriod(period) {
      fetchBudgetProgressData(period);
    }

    function populateBudgetProgressTable(budgetProgress) {
      const tableBody = document.querySelector('#budget-progress-table tbody');
      tableBody.innerHTML = '';
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

        const tdCategory = document.createElement('td');
        tdCategory.textContent = item.category;
        tr.appendChild(tdCategory);

        const tdAllocated = document.createElement('td');
        tdAllocated.textContent = 'PHP ' + parseFloat(item.allocated_budget).toFixed(2);
        tr.appendChild(tdAllocated);

        const tdSpent = document.createElement('td');
        tdSpent.textContent = 'PHP ' + parseFloat(item.amount_spent).toFixed(2);
        tr.appendChild(tdSpent);

        const tdRemaining = document.createElement('td');
        const remaining = Math.max(0, parseFloat(item.remaining_budget));
        tdRemaining.textContent = 'PHP ' + remaining.toFixed(2);
        tdRemaining.style.color = remaining <= 0 ? 'red' : 'green';
        tr.appendChild(tdRemaining);

        tableBody.appendChild(tr);
      });
    }

    // =============================
    // Custom Tab Functionality
    // =============================
    function openTab(evt, tabName) {
      const tabLinks = document.getElementsByClassName("tab-link");
      const tabContents = document.getElementsByClassName("tab-content");
      for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove("active");
        tabContents[i].setAttribute('aria-hidden', 'true');
      }
      for (let i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
        tabLinks[i].setAttribute('aria-selected', 'false');
      }
      const currentTabContent = document.getElementById(tabName);
      currentTabContent.classList.add("active");
      currentTabContent.setAttribute('aria-hidden', 'false');
      evt.currentTarget.classList.add("active");
      evt.currentTarget.setAttribute('aria-selected', 'true');
    }
  </script>
</body>
</html> 
