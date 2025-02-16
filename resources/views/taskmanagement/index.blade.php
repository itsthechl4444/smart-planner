<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>
  <!-- Favicon -->
  <link rel="icon" href="/images/LogoPNG.png" type="image/png">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- External Stylesheets -->
  <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Canvas Confetti Library -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js" defer></script>

  <!-- Inline CSS -->
  <style>
    /* --- Animation for Illustrations --- */
    @keyframes floatAnimation {
      0% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
      100% { transform: translateY(0); }
    }
    .no-data-illustration, .illustration {
      animation: floatAnimation 3s ease-in-out infinite;
    }
    /* Reduce top margin for "nothing-here" containers */
    .nothing-here {
      margin-top: 0;
      min-height: 40vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    /* =========================================
       1. Global Styles
    ========================================= */
    *, *::before, *::after {
      box-sizing: border-box;
    }
    body {
      font-family: "Open Sans", sans-serif;
      margin: 0;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      color: #808080;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .main-content::-webkit-scrollbar {
      display: none;
    }
    .main-content {
      -ms-overflow-style: none;
      scrollbar-width: none;
      padding-bottom: 80px;
    }
    /* =========================================
       2. Header Styles (Centered Title)
    ========================================= */
    .header {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 20px;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      height: 65px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .title {
      font-size: 20px;
      font-weight: 500;
      text-align: center;
      color: #555;
    }
    .spacer {
      width: 40px;
      height: 100%;
      display: none;
    }
    @media (min-width: 769px) {
      .spacer {
        display: block;
      }
    }
    /* =========================================
       3. Smart Animations
    ========================================= */
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }
    .modal.fade .modal-dialog {
      transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }
    .modal.show .modal-dialog {
      transform: translate(0, 0);
      opacity: 1;
    }
    /* =========================================
       4. Global Search Bar Styles
    ========================================= */
    .global-search {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      padding-top: 80px;
    }
    .task-search {
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 800px;
      background-color: #fff;
      border-radius: 8px;
      padding: 10px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .task-search .search-icon {
      color: #808080;
      margin-right: 12px;
      font-size: 20px;
    }
    .task-search input {
      border: none;
      outline: none;
      flex-grow: 1;
      font-size: 16px;
      color: #555;
      background-color: transparent;
    }
    .task-search input::placeholder {
      color: #aaa;
    }
    .clear-search {
      color: #aaa;
      cursor: pointer;
      font-size: 20px;
      transition: color 0.3s ease;
    }
    .clear-search:hover {
      color: #555;
    }
    @media (max-width: 768px) {
      .task-search {
        max-width: 100%;
        margin: 0 auto;
        padding: 8px 12px;
      }
      .task-search .search-icon {
        margin-right: 8px;
        font-size: 18px;
      }
      .task-search input {
        font-size: 14px;
      }
      .clear-search {
        font-size: 18px;
      }
    }
    @media (max-width: 480px) {
      .task-search {
        max-width: 100%;
        margin: 0 auto;
        padding: 6px 10px;
      }
      .task-search .search-icon {
        margin-right: 6px;
        font-size: 16px;
      }
      .task-search input {
        font-size: 12px;
      }
      .clear-search {
        font-size: 16px;
      }
    }
    /* =========================================
       5. Tabs Section
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
      display: flex;
      align-items: center;
      transition: border-color 0.3s ease, color 0.3s ease;
    }
    .tab-link .tab-icon {
      font-size: 20px;
      color: #808080;
      margin-right: 8px;
      display: flex;
      align-items: center;
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
    @media (max-width: 600px) {
      .tabs {
        padding-bottom: 10px;
      }
      .tab-link {
        padding: 10px 15px;
        font-size: 14px;
      }
      .tab-link .tab-icon {
        font-size: 18px;
        margin-right: 6px;
      }
    }
    @media (max-width: 480px) {
      .tabs {
        flex-direction: row;
        gap: 8px;
        padding: 6px 0;
      }
      .tab-link {
        padding: 6px 12px;
        font-size: 14px;
      }
      .tab-link .tab-icon {
        font-size: 16px;
        margin-right: 4px;
      }
    }
    /* =========================================
       6. Task Filter Buttons
    ========================================= */
    .task-filter {
      display: flex;
      justify-content: center;
      margin-top: 30px;
      margin-bottom: 20px;
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
    /* =========================================
       7. Cards (Enhanced Project Cards)
    ========================================= */
    .task-cards,
    .label-cards,
    .project-cards,
    .search-cards {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      padding: 0;
      box-sizing: border-box;
    }
    @media (max-width: 480px) {
      .task-cards,
      .label-cards,
      .project-cards,
      .search-cards {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 10px;
      }
    }
    .card {
      background-color: #ffffff;
      border-radius: 10px;
      margin: 5px 0;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      width: 100%;
      max-width: 800px;
      box-sizing: border-box;
    }
    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-content {
      padding: 15px;
      box-sizing: border-box;
    }
    .card-title {
      font-size: 18px;
      color: #333;
      margin-bottom: 10px;
      font-weight: bold;
    }
    /* Group project description with dates */
    .project-dates {
      margin-top: 5px;
      color: #666;
      font-size: 14px;
    }
    .task-info p,
    .label-info p,
    .project-info p {
      margin: 5px 0;
      color: #666;
    }
    .overdue-status {
      color: red;
      font-weight: bold;
    }
    .label-pill {
      display: inline-block;
      padding: 4px 8px;
      margin-top: 8px;
      font-size: 14px;
      color: #fff;
      background-color: #808080;
      border-radius: 12px;
      text-align: center;
    }
    /* =========================================
       8. "Nothing Here" Illustration
    ========================================= */
    .nothing-here {
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #808080;
      width: 100%;
      margin-top: 0;
      min-height: 40vh;
    }
    .nothing-here img {
      width: 100%;
      max-width: 200px;
      height: auto;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }
    .nothing-here img:hover {
      transform: scale(1.05);
    }
    .nothing-here p {
      font-size: 16px;
      margin: 0;
      text-align: center;
    }
    .search-results h2 {
      text-align: center;
      font-size: 16px;
    }
    .search-results .nothing-here p {
      text-align: center;
      font-size: 14px;
    }
    @media (max-width: 768px) {
      .nothing-here img {
        max-width: 300px;
      }
    }
    @media (max-width: 480px) {
      .nothing-here img {
        max-width: 90%;
      }
      .nothing-here p {
        font-size: 16px;
      }
    }
    /* =========================================
       9. Floating Action Button (FAB)
    ========================================= */
    .fab {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #808080;
      color: #fff;
      width: 60px;
      height: 60px;
      border-radius: 10px;
      display: none;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      z-index: 1000;
    }
    .fab i {
      font-size: 24px;
    }
    .fab:hover {
      background-color: #555;
      transform: scale(1.1);
    }
    .fab-options {
      display: none;
      position: fixed;
      bottom: 100px;
      right: 30px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      padding: 10px;
      z-index: 999;
      transition: opacity 0.3s ease, transform 0.3s ease;
      opacity: 0;
      transform: translateY(10px);
    }
    .fab-options.show {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    .fab-option {
      display: flex;
      align-items: center;
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      background: none;
      border: none;
      color: inherit;
      width: 100%;
      text-align: left;
      font-size: 16px;
    }
    .fab-option i {
      font-size: 18px;
      margin-right: 10px;
    }
    .fab-option:hover {
      background-color: #e0e0e0;
    }
    @media (min-width: 769px) {
      .fab {
        display: none;
      }
      .fab-options {
        display: none;
      }
    }
    @media (max-width: 768px) {
      .fab {
        display: flex;
      }
    }
    /* =========================================
       10. Bottom Navbar Styles
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
      .fab {
        bottom: calc(20px + 15px);
      }
      .fab-options {
        bottom: calc(35px + 10px);
      }
    }
    @media (max-width: 480px) {
      .bottom-navbar {
        width: calc(100% - 40px);
        bottom: 20px;
      }
      .fab {
        margin-bottom: 60px;
      }
      .fab-options {
        margin-bottom: 120px;
      }
    }
    @media (min-width: 769px) {
      .bottom-navbar {
        width: 400px;
        bottom: 20px;
      }
      .fab {
        bottom: 20px;
        right: 20px;
      }
      .bottom-navbar .navbar-item {
        font-size: 14px;
      }
      .bottom-navbar .navbar-item i {
        font-size: 26px;
      }
    }
    /* =========================================
       11. Loading Overlay Styles
    ========================================= */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.8);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1003;
    }
    .loading-spinner {
      width: 60px;
      height: 60px;
      border: 6px solid #f3f3f3;
      border-top: 6px solid #808080;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    /* =========================================
       12. Form and Button Styles
    ========================================= */
    .modal-body .form-group {
      margin-bottom: 20px;
    }
    .icon-button {
      width: 40px;
      height: 40px;
      border: 1px solid #808080;
      background-color: #ffffff;
      color: #808080;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
      margin-left: 8px;
    }
    .icon-button:hover {
      background-color: #808080;
      color: #ffffff;
    }
    .icon-button .material-icons-outlined {
      font-size: 24px;
    }
    /* =========================================
       13. Additional Adjustments
    ========================================= */
    .container {
      padding-bottom: 80px;
    }
    /* =========================================
       14. Enhanced Filter Button Active State
    ========================================= */
    button.filter-btn.active {
      background-color: #808080;
      color: #fff;
      border-color: #808080;
    }
    /* =========================================
       15. New Item Styles for Desktop
    ========================================= */
    .new-item {
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 16px;
      color: #555;
      margin-bottom: 10px;
    }
    .new-item .material-icons-outlined {
      font-size: 20px;
      margin-right: 8px;
    }
    .desktop-only {
      display: none;
    }
    @media (min-width: 769px) {
      .desktop-only {
        display: flex;
      }
    }
    @media (max-width: 768px) {
      .desktop-only {
        display: none;
      }
    }
  </style>
</head>
<body>
  @include('partials.loader')
  <header class="header" role="banner">
    <div class="title">Task Management</div>
    <div class="spacer" aria-hidden="true"></div>
  </header>
  <div class="container">
    <main class="main-content">
      <!-- Global Search Bar -->
      <div class="global-search">
        <div class="task-search">
          <i class="bi bi-search search-icon" aria-hidden="true"></i>
          <input type="text" id="global-search-input" placeholder="Search Tasks, Labels, Projects..." aria-label="Search Tasks, Labels, Projects" data-bs-toggle="tooltip" data-bs-placement="top" title="Type to search tasks, labels, or projects." />
          <button type="button" class="btn btn-link clear-search" id="clear-search" aria-label="Clear Search" title="Clear Search">
            <i class="bi bi-x-circle-fill" aria-hidden="true"></i>
          </button>
        </div>
      </div>

      <!-- Search Results -->
      <div id="search-results" class="search-results tab-content" style="display: none;">
        <h2>Search Results</h2>
        <div class="task-cards search-cards"></div>
        <div class="nothing-here" id="no-search-results" style="display: none;">
          <img src="{{ asset('images/task1.png') }}" alt="No results found" class="no-data-illustration">
          <p>No records match your search.</p>
        </div>
      </div>

      <!-- Tabs Navigation -->
      <div class="tabs" role="tablist">
        <button class="tab-link active" onclick="openTab(event, 'tasks')" role="tab" aria-selected="true" aria-controls="tasks" aria-label="Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all tasks.">
          <span class="material-icons-outlined tab-icon" aria-hidden="true">check_box</span>
          Tasks
        </button>
        <button class="tab-link" onclick="openTab(event, 'labels')" role="tab" aria-selected="false" aria-controls="labels" aria-label="Labels" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all labels.">
          <span class="material-icons-outlined tab-icon" aria-hidden="true">label</span>
          Labels
        </button>
        <button class="tab-link" onclick="openTab(event, 'projects')" role="tab" aria-selected="false" aria-controls="projects" aria-label="Projects" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all projects.">
          <span class="material-icons-outlined tab-icon" aria-hidden="true">folder</span>
          Projects
        </button>
      </div>

      <!-- Tasks Section -->
      <div id="tasks" class="tab-content active" role="tabpanel" aria-labelledby="tasks">
        <!-- Task Filter Buttons -->
        <div class="task-filter" role="group" aria-label="Task Filters">
          <button class="filter-btn active" data-filter="all" aria-pressed="true" aria-label="Show All Tasks" title="Show All Tasks" data-bs-toggle="tooltip" data-bs-placement="top">All</button>
          <button class="filter-btn" data-filter="pending" aria-pressed="false" aria-label="Show Pending Tasks" title="Show Pending Tasks" data-bs-toggle="tooltip" data-bs-placement="top">Pending</button>
          <button class="filter-btn" data-filter="completed" aria-pressed="false" aria-label="Show Completed Tasks" title="Show Completed Tasks" data-bs-toggle="tooltip" data-bs-placement="top">Completed</button>
          <button class="filter-btn" data-filter="overdue" aria-pressed="false" aria-label="Show Overdue Tasks" title="Show Overdue Tasks" data-bs-toggle="tooltip" data-bs-placement="top">Overdue</button>
        </div>

        <!-- Completion Rate Tips -->
        <div id="completion-tips-container" class="alert alert-info" style="display:none; max-width:800px; margin:0 auto; margin-bottom:20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Tips to improve your task completion rate.">
          <strong>Tip:</strong> You have quite a few pending or overdue tasks. Consider breaking them into smaller subtasks or setting reminders!
        </div>

        <!-- Overdue Streak Suggestion -->
        <div id="overdue-streak-container" class="alert alert-warning" style="display:none; max-width:800px; margin:0 auto; margin-bottom:20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Suggestions to manage overdue tasks better.">
          <strong>Suggestion:</strong> It appears tasks with certain labels frequently end up overdue. Try scheduling them earlier or adjusting due dates.
        </div>

        <!-- New Task Button for Desktop -->
        <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createTaskModal" role="button" tabindex="0" aria-label="Add New Task" title="Add New Task">
          <span class="material-icons-outlined">add</span> New Task
        </div>

        <!-- Task Cards -->
        <div class="task-cards">
          @foreach($tasks as $task)
            <div class="card task-card {{ ($task->status === 'pending' && $task->due_date && \Carbon\Carbon::parse($task->due_date)->lt(\Carbon\Carbon::today())) ? 'overdue' : '' }}" 
                 data-task-id="{{ $task->id }}"
                 data-task-url="{{ route('tasks.show', $task->id) }}"
                 data-task-status="{{ strtolower($task->status) }}"
                 data-task-priority="{{ strtolower($task->priority) }}" 
                 data-task-duedate="{{ $task->due_date ?? '' }}"
                 data-task-label="{{ $task->label ? $task->label->name : '' }}"
                 role="button"
                 tabindex="0"
                 aria-label="View Task: {{ $task->title }}"
                 title="View Task: {{ $task->title }}"
                 data-bs-toggle="tooltip"
                 data-bs-placement="top">
              <!-- Task Completion Checkbox -->
              <div class="task-checkbox">
                <input type="checkbox" class="task-complete-checkbox" 
                       data-task-id="{{ $task->id }}" 
                       {{ strtolower($task->status) === 'completed' ? 'checked' : '' }}
                       aria-label="Mark as Completed"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="Mark task as completed.">
              </div>
              <!-- Card Content -->
              <div class="card-content">
                <div class="task-info">
                  <span class="card-title">{{ $task->title }}</span>
                  <p>Due Date: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'No due date' }}</p>
                  <p>Priority: {{ $task->priority }}</p>
                  <p>
                    Status: 
                    @if ($task->status === 'pending' && $task->due_date && \Carbon\Carbon::parse($task->due_date)->lt(\Carbon\Carbon::today()))
                      <span class="overdue-status">Overdue</span>
                    @else
                      {{ ucfirst($task->status) }}
                    @endif
                  </p>
                  @if($task->label)
                    <span class="label-pill" style="background-color: {{ $task->label->color }};" aria-label="Label: {{ $task->label->name }}">
                      {{ $task->label->name }}
                    </span>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- No Tasks Message -->
        <div class="nothing-here" id="no-tasks-message" style="display: none;">
          <img src="{{ asset('images/task1.png') }}" alt="No tasks to display" class="no-data-illustration">
          <p id="no-tasks-text">No tasks to display.</p>
        </div>
      </div>

      <!-- Labels Section -->
      <div id="labels" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="labels">
        <!-- New Label Button for Desktop -->
        <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createLabelModal" role="button" tabindex="0" aria-label="Add New Label" title="Add New Label">
          <span class="material-icons-outlined">add</span> New Label
        </div>
        @if (isset($labels) && $labels->isEmpty())
          <div class="nothing-here" id="no-labels-message">
            <img src="{{ asset('images/label.png') }}" alt="No labels created" class="no-data-illustration">
            <p>No labels created yet.</p>
          </div>
        @elseif(isset($labels))
          <div class="label-cards">
            @foreach($labels as $label)
              <div class="card label-card" 
                   data-label-id="{{ $label->id }}"
                   data-label-url="{{ route('labels.show', $label->id) }}"
                   role="button"
                   tabindex="0"
                   aria-label="View Label: {{ $label->name }}"
                   title="View Label: {{ $label->name }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top">
                <div class="card-content">
                  <span class="card-title">{{ $label->name }}</span>
                  <p>{{ $label->description ?? 'No description' }}</p>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Projects Section -->
      <div id="projects" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="projects">
        <!-- New Project Button for Desktop -->
        <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createProjectModal" role="button" tabindex="0" aria-label="Add New Project" title="Add New Project">
          <span class="material-icons-outlined">add</span> New Project
        </div>
        @if (isset($projects) && $projects->isEmpty())
          <div class="nothing-here" id="no-projects-message">
            <img src="{{ asset('images/project.png') }}" alt="No projects created" class="no-data-illustration">
            <p>No projects created yet.</p>
          </div>
        @elseif(isset($projects))
          <div class="project-cards">
            @foreach($projects as $project)
              <div class="card project-card" 
                   data-project-id="{{ $project->id }}"
                   data-project-url="{{ route('projects.show', $project->id) }}"
                   role="button"
                   tabindex="0"
                   aria-label="View Project: {{ $project->name }}"
                   title="View Project: {{ $project->name }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top">
                <div class="card-content">
                  <span class="card-title">{{ $project->name }}</span>
                  <p>{{ $project->description ?? 'No description' }}</p>
                  <p class="project-dates">
                    <small>
                      Start: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'N/A' }},
                      End: {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : 'N/A' }}
                    </small>
                  </p>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </main>

    <!-- Floating Action Button (FAB) for Mobile -->
    <div class="fab" id="fab" role="button" aria-label="Add New" title="Add New" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="left">
      <i class="bi bi-plus" aria-hidden="true"></i>
    </div>
    <div class="fab-options" id="fab-options">
      <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createTaskModal" role="button" aria-label="Create New Task" title="Create New Task" data-bs-toggle="tooltip" data-bs-placement="left">
        <i class="bi bi-check-circle" aria-hidden="true"></i> New Task
      </button>
      <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createLabelModal" role="button" aria-label="Create New Label" title="Create New Label" data-bs-toggle="tooltip" data-bs-placement="left">
        <i class="bi bi-tag" aria-hidden="true"></i> New Label
      </button>
      <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createProjectModal" role="button" aria-label="Create New Project" title="Create New Project" data-bs-toggle="tooltip" data-bs-placement="left">
        <i class="bi bi-folder" aria-hidden="true"></i> New Project
      </button>
    </div>

    <!-- Bottom Navigation Bar -->
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

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body">
            <!-- Append query string and fragment to redirect back to tasks tab -->
            <form id="create-task-form" action="{{ route('tasks.store') }}?redirect=taskmanagement#tasks" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ Auth::id() }}">
              <div class="form-group">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter Task Title" required autofocus data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the title of the task.">
                @error('title')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter a detailed description of the task.">{{ old('description') }}</textarea>
                @error('description')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the due date for the task.">
                @error('due_date')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-control" id="priority" name="priority" required aria-required="true" aria-label="Select Priority" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the priority level of the task.">
                  <option value="" disabled selected>Select Priority</option>
                  <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                  <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                  <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                </select>
                @error('priority')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="label_id" class="form-label">Label</label>
                <select class="form-control" id="label_id" name="label_id" aria-label="Select Label" data-bs-toggle="tooltip" data-bs-placement="top" title="Select a label for the task.">
                  <option value="" disabled selected>Select Label</option>
                  @foreach($labels as $label)
                    <option value="{{ $label->id }}" {{ old('label_id') == $label->id ? 'selected' : '' }}>{{ $label->name }}</option>
                  @endforeach
                </select>
                @error('label_id')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Enter Notes" data-bs-toggle="tooltip" data-bs-placement="top" title="Add any additional notes for the task.">{{ old('notes') }}</textarea>
                @error('notes')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="attachments" class="form-label">Attachments</label>
                <input type="file" class="form-control" id="attachments" name="attachments" aria-label="Upload Attachments" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach any relevant files to the task.">
                @error('attachments')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group form-check">
                <input type="hidden" name="reminder" value="0">
                <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder') ? 'checked' : '' }} aria-checked="{{ old('reminder') ? 'true' : 'false' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Check to set a reminder for this task.">
                <label class="form-check-label" for="reminder">Set Reminder</label>
                @error('reminder')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
              <span class="material-icons-outlined">close</span>
            </button>
            <button type="submit" form="create-task-form" class="icon-button" aria-label="Save Task" title="Save Task" data-bs-toggle="tooltip" data-bs-placement="top">
              <span class="material-icons-outlined">send</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Create Task Modal -->

    <!-- Create Label Modal -->
    <div class="modal fade" id="createLabelModal" tabindex="-1" aria-labelledby="createLabelModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body">
            <!-- Redirect back to labels tab after saving -->
            <form id="create-label-form" action="{{ route('labels.store') }}?redirect=taskmanagement#labels" method="POST">
              @csrf
              <div class="form-group">
                <label for="label-name" class="form-label">Label Name</label>
                <input type="text" class="form-control" id="label-name" name="name" value="{{ old('name') }}" placeholder="Enter Label Name" required autofocus aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the name of the label.">
                @error('name')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="label-description" class="form-label">Description</label>
                <textarea class="form-control" id="label-description" name="description" placeholder="Enter Description" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter a description for the label.">{{ old('description') }}</textarea>
                @error('description')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="label-color" class="form-label">Color</label>
                <input type="color" class="form-control form-control-color" id="label-color" name="color" value="{{ old('color', '#007bff') }}" aria-label="Choose Label Color" data-bs-toggle="tooltip" data-bs-placement="top" title="Select a color for the label.">
                @error('color')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
              <span class="material-icons-outlined">close</span>
            </button>
            <button type="submit" form="create-label-form" class="icon-button" aria-label="Save Label" title="Save Label" data-bs-toggle="tooltip" data-bs-placement="top">
              <span class="material-icons-outlined">send</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Create Label Modal -->

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body">
            <!-- Redirect back to projects tab after saving -->
            <form id="create-project-form" action="{{ route('projects.store') }}?redirect=taskmanagement#projects" method="POST">
              @csrf
              <div class="form-group">
                <label for="project-name" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="project-name" name="name" value="{{ old('name') }}" placeholder="Enter Project Name" required autofocus aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the name of the project.">
                @error('name')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="project-description" class="form-label">Description</label>
                <textarea class="form-control" id="project-description" name="description" placeholder="Enter Description" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter a description for the project.">{{ old('description') }}</textarea>
                @error('description')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="project-start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="project-start_date" name="start_date" value="{{ old('start_date') }}" required aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the start date for the project.">
                @error('start_date')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
              <div class="form-group">
                <label for="project-end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="project-end_date" name="end_date" value="{{ old('end_date') }}" required aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the end date for the project.">
                @error('end_date')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
              <span class="material-icons-outlined">close</span>
            </button>
            <button type="submit" form="create-project-form" class="icon-button" aria-label="Save Project" title="Save Project" data-bs-toggle="tooltip" data-bs-placement="top">
              <span class="material-icons-outlined">send</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Create Project Modal -->

    <!-- Congratulations Modal -->
    <div class="modal fade" id="congratsModal" tabindex="-1" aria-labelledby="congratsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-body text-center">
            <img src="{{ asset('images/done.png') }}" alt="Congratulations" class="congrats-illustration mb-4">
            <h2>Congratulations! 🎉</h2>
            <p>You've completed 5 tasks today! Keep up the great work.</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="filter-btn" data-bs-dismiss="modal" aria-label="Close" title="Awesome!" data-bs-toggle="tooltip" data-bs-placement="top">Awesome!</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Congratulations Modal -->

    <!-- Loading Overlay (Spinner) -->
    <div class="loading-overlay" id="loading-overlay" style="display: none;">
      <div class="loading-spinner"></div>
    </div>
  </div>
  
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="{{ asset('js/loader.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Initialize Bootstrap tooltips
      const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      const tooltipList = tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, { trigger: 'hover focus' }));
      function hideAllTooltips() {
        tooltipList.forEach(tooltip => tooltip.hide());
      }
      document.addEventListener('click', hideAllTooltips);
      document.addEventListener('touchstart', hideAllTooltips);

      // Floating Action Button functionality for mobile
      const fab = document.getElementById('fab');
      const fabOptions = document.getElementById('fab-options');
      fab.addEventListener('click', (e) => {
        fabOptions.classList.toggle('show');
        e.stopPropagation();
        hideAllTooltips();
      });
      document.addEventListener("click", function(event) {
        if (!fab.contains(event.target) && !fabOptions.contains(event.target)) {
          fabOptions.classList.remove("show");
        }
        hideAllTooltips();
      });

      // Card click handlers for tasks, labels, projects
      ['task', 'label', 'project'].forEach(type => {
        const cards = document.querySelectorAll(`.${type}-card`);
        cards.forEach(card => {
          card.addEventListener('click', () => {
            const url = card.getAttribute(`data-${type}-url`);
            if (url) {
              window.location.href = url;
            } else {
              console.error(`${type.charAt(0).toUpperCase() + type.slice(1)} URL not found.`);
            }
            hideAllTooltips();
          });
          card.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              card.click();
            }
          });
        });
      });

      // Search functionality
      const searchInput = document.getElementById('global-search-input');
      const clearSearch = document.getElementById('clear-search');
      const searchResults = document.getElementById('search-results');
      const searchCardsContainer = searchResults.querySelector('.search-cards');
      const noSearchResults = document.getElementById('no-search-results');
      const tabsDiv = document.querySelector('.tabs');
      function debounce(func, delay) {
        let debounceTimer;
        return function() {
          const context = this;
          const args = arguments;
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => func.apply(context, args), delay);
        }
      }
      searchInput.addEventListener('input', debounce(function() {
        const query = this.value.toLowerCase().trim();
        if (query.length === 0) {
          searchResults.style.display = 'none';
          searchCardsContainer.innerHTML = '';
          noSearchResults.style.display = 'none';
          tabsDiv.style.display = 'flex';
          const activeTab = document.querySelector('.tab-content.active');
          if (activeTab) { activeTab.style.display = 'block'; }
          hideAllTooltips();
          return;
        }
        tabsDiv.style.display = 'none';
        const tabContents = document.getElementsByClassName('tab-content');
        for (let i = 0; i < tabContents.length; i++) {
          tabContents[i].style.display = 'none';
        }
        searchCardsContainer.innerHTML = '';
        noSearchResults.style.display = 'none';
        ['task', 'label', 'project'].forEach(type => {
          const cards = document.querySelectorAll(`.${type}-card`);
          cards.forEach(card => {
            const cardTitleElement = card.querySelector('.card-title');
            const cardTitle = cardTitleElement ? cardTitleElement.textContent.toLowerCase() : '';
            let cardContentText = '';
            if (type === 'task') {
              const dueDate = card.querySelector('.task-info p:nth-child(2)');
              const priority = card.querySelector('.task-info p:nth-child(3)');
              const status = card.querySelector('.task-info p:nth-child(4)');
              const label = card.querySelector('.label-pill');
              cardContentText = (dueDate ? dueDate.textContent.toLowerCase() : '') + ' ' +
                                (priority ? priority.textContent.toLowerCase() : '') + ' ' +
                                (status ? status.textContent.toLowerCase() : '') + ' ' +
                                (label ? label.textContent.toLowerCase() : '');
            } else if (type === 'label') {
              const labelDescription = card.querySelector('.card-content p');
              cardContentText = labelDescription ? labelDescription.textContent.toLowerCase() : '';
            } else if (type === 'project') {
              const projectDescription = card.querySelector('.card-content p:nth-child(2)');
              const projectDates = card.querySelector('.project-dates');
              cardContentText = (projectDescription ? projectDescription.textContent.toLowerCase() : '') + ' ' +
                                (projectDates ? projectDates.textContent.toLowerCase() : '');
            }
            if (cardTitle.includes(query) || cardContentText.includes(query)) {
              const clonedCard = card.cloneNode(true);
              searchCardsContainer.appendChild(clonedCard);
            }
          });
        });
        const totalResults = searchCardsContainer.querySelectorAll('.card').length;
        noSearchResults.style.display = totalResults === 0 ? 'flex' : 'none';
        searchResults.style.display = 'block';
        hideAllTooltips();
      }, 300));
      clearSearch.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        hideAllTooltips();
      });

      // Tab navigation
      window.openTab = function(evt, tabName) {
        evt.preventDefault();
        const tabContents = document.getElementsByClassName('tab-content');
        for (let i = 0; i < tabContents.length; i++) {
          tabContents[i].classList.remove('active');
          tabContents[i].style.display = 'none';
        }
        const tabLinks = document.getElementsByClassName('tab-link');
        for (let i = 0; i < tabLinks.length; i++) {
          tabLinks[i].classList.remove('active');
        }
        const currentTab = document.getElementById(tabName);
        currentTab.classList.add('active');
        currentTab.style.display = 'block';
        evt.currentTarget.classList.add('active');
        handleNoDataMessages();
        if (tabName === 'tasks') {
          filterButtons.forEach(btn => {
            if (btn.getAttribute('data-filter') === 'all') {
              btn.classList.add('active');
              btn.setAttribute('aria-pressed', 'true');
            } else {
              btn.classList.remove('active');
              btn.setAttribute('aria-pressed', 'false');
            }
          });
          filterTasks('all');
        }
        hideAllTooltips();
      };

      function handleNoDataMessages() {
        const cardTypes = ['task', 'label', 'project'];
        cardTypes.forEach(type => {
          const cards = document.querySelectorAll(`.${type}-card`);
          const noMessage = document.getElementById(`no-${type}s-message`);
          if (noMessage) {
            noMessage.style.display = cards.length === 0 ? 'flex' : 'none';
          }
        });
      }
      handleNoDataMessages();

      // Task completion and status update
      function handleTaskCompletion() {
        const checkboxes = document.querySelectorAll('.task-complete-checkbox');
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener('click', function(event) {
            event.stopPropagation();
          });
          checkbox.addEventListener('change', function(event) {
            event.stopPropagation();
            const taskId = this.getAttribute('data-task-id');
            const isChecked = this.checked;
            document.getElementById('loading-overlay').style.display = 'flex';
            fetch(`/tasks/${taskId}/status`, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
              },
              body: JSON.stringify({ completed: isChecked })
            })
            .then(response => response.json())
            .then(data => {
              document.getElementById('loading-overlay').style.display = 'none';
              if (data.success) {
                const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
                const statusElement = taskCard.querySelector('.task-info p:nth-child(4)');
                const titleElement = taskCard.querySelector('.card-title');
                if (isChecked) {
                  statusElement.innerHTML = 'Status: <span class="overdue-status">Completed</span>';
                  titleElement.style.textDecoration = 'line-through';
                  titleElement.style.color = '#6c757d';
                  taskCard.classList.remove('overdue');
                } else {
                  statusElement.textContent = 'Status: Pending';
                  titleElement.style.textDecoration = 'none';
                  titleElement.style.color = '#333';
                  const dueDate = taskCard.getAttribute('data-task-duedate');
                  if (dueDate) {
                    const dateObj = new Date(dueDate);
                    const todayStart = new Date();
                    todayStart.setHours(0,0,0,0);
                    if (dateObj < todayStart) {
                      statusElement.innerHTML = 'Status: <span class="overdue-status">Overdue</span>';
                      taskCard.classList.add('overdue');
                    } else {
                      taskCard.classList.remove('overdue');
                    }
                  }
                }
                filterTasks(currentFilter);
              } else {
                alert('Failed to update task status: ' + data.message);
                this.checked = !isChecked;
              }
            })
            .catch(error => {
              document.getElementById('loading-overlay').style.display = 'none';
              console.error('Error:', error);
              alert('An error occurred while updating the task status.');
              this.checked = !isChecked;
            });
          });
        });
      }
      handleTaskCompletion();

      const filterButtons = document.querySelectorAll('.filter-btn');
      const taskCards = document.querySelectorAll('.task-card');
      const noTasksMessage = document.getElementById('no-tasks-message');
      const noTasksText = document.getElementById('no-tasks-text');
      function filterTasks(filter) {
        let matchingTasks = 0;
        taskCards.forEach(card => {
          const status = card.getAttribute('data-task-status');
          if (filter === 'all') {
            card.style.display = 'block';
            matchingTasks++;
          } else if (filter === 'overdue') {
            const isOverdue = card.classList.contains('overdue');
            if (isOverdue) {
              card.style.display = 'block';
              matchingTasks++;
            } else {
              card.style.display = 'none';
            }
          } else {
            if (status === filter) {
              card.style.display = 'block';
              matchingTasks++;
            } else {
              card.style.display = 'none';
            }
          }
        });
        if (matchingTasks === 0) {
          if (currentFilter === 'all') {
            noTasksText.textContent = 'No tasks at all.';
          } else if (currentFilter === 'pending') {
            noTasksText.textContent = 'No pending tasks.';
          } else if (currentFilter === 'completed') {
            noTasksText.textContent = 'No completed tasks yet.';
          } else if (currentFilter === 'overdue') {
            noTasksText.textContent = 'No overdue tasks.';
          }
          noTasksMessage.style.display = 'flex';
        } else {
          noTasksMessage.style.display = 'none';
        }
      }
      filterButtons.forEach(button => {
        button.addEventListener('click', () => {
          filterButtons.forEach(btn => {
            btn.classList.remove("active");
            btn.setAttribute('aria-pressed', 'false');
          });
          button.classList.add("active");
          button.setAttribute('aria-pressed', 'true');
          const filter = button.getAttribute('data-filter');
          filterTasks(filter);
          hideAllTooltips();
        });
      });
      filterTasks('all');

      // Keyboard accessibility for FAB
      fab.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          fab.click();
        }
      });
      document.querySelectorAll('.fab-option').forEach(option => {
        option.addEventListener('keypress', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            option.click();
          }
        });
      });

      // Example: Check and celebrate task completions (using confetti)
      const todayDate = new Date().toISOString().slice(0,10);
      let storedDate = localStorage.getItem('completedTasksDate');
      if (!storedDate || storedDate !== todayDate) {
        localStorage.setItem('completedTasksCount', '0');
        localStorage.setItem('completedTasksDate', todayDate);
        localStorage.setItem('congratsShownForToday', 'false');
      }
      let completedTasksCount = parseInt(localStorage.getItem('completedTasksCount')) || 0;
      function celebrateCompletion() {
        confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
        const congratsModal = new bootstrap.Modal(document.getElementById('congratsModal'));
        congratsModal.show();
        localStorage.setItem('congratsShownForToday', 'true');
      }
      function checkTaskCompletion() {
        completedTasksCount++;
        localStorage.setItem('completedTasksCount', completedTasksCount.toString());
        if (completedTasksCount >= 5 && localStorage.getItem('congratsShownForToday') === 'false') {
          celebrateCompletion();
        }
      }
    });
  </script>
</body>
</html>
