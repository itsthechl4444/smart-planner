<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>

      <!-- Favicon -->
      <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/project_show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Toastr CSS for Toast Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Make the project ID available in JS -->
    <script>
        const projectId = {{ $project->id }};
    </script>
    
    <!-- Inline CSS: Project Show & Global Styles -->
    <style>
        /* =========================================
           1. Global Styles
        ========================================= */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
        
        body {
            font-family: "Open Sans", sans-serif;
            margin: 0;
            background: #f9f9f9;
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
           2. Top App Bar Styles
        ========================================= */
        .app-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 56px;
            padding: 0 20px;
            background-color: #f9f9f9;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid #ddd;
        }
        
        .header-icon {
            font-size: 24px;
            color: #555;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .back-icon {
            transition: transform 0.3s ease;
        }
        
        .back-icon:hover {
            transform: rotate(90deg);
        }
        
        .app-bar-title {
            flex-grow: 1;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            color: #555;
            margin: 0;
        }
        
        .app-bar-actions {
            display: flex;
            align-items: center;
        }
        
        .user-icon-link {
            margin-right: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        /* Dropdown Styles */
        .dropdown-content {
            display: none;
            position: absolute;
            top: 56px;
            right: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 5px 0;
            font-size: 14px;
            min-width: 160px;
            z-index: 1000;
        }
        
        .dropdown-content.open {
            display: block;
        }
        
        .dropdown-content li {
            list-style: none;
        }
        
        .dropdown-content li a,
        .dropdown-content li button {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 16px;
        }
        
        .dropdown-content li a:hover,
        .dropdown-content li button:hover {
            background-color: #f1f1f1;
        }
        
        .dropdown-content span.material-symbols-outlined {
            margin-right: 8px;
            font-size: 20px;
        }
        
        /* =========================================
           3. Task Filter Buttons
        ========================================= */
        .task-filter {
            display: flex;
            justify-content: center;
            margin-top: 80px;
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
           4. Task Cards Styling
        ========================================= */
        .task-cards .card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, background-color 0.3s ease;
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
        }
        
        .task-cards .card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .card-text {
            color: #666;
        }
        
        .card-text strong {
            color: #333;
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
        
        .overdue-status {
            color: red;
            font-weight: bold;
        }
        
        .task-card {
            position: relative;
        }
        
        .task-checkbox {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
        }
        
        .task-complete-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-color: #fff;
            border: 2px solid #808080;
            border-radius: 50%;
            outline: none;
            transition: background-color 0.3s, border-color 0.3s;
            position: relative;
        }
        
        .task-complete-checkbox:checked {
            background-color: #808080;
            border-color: #808080;
        }
        
        .task-complete-checkbox:checked::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            width: 10px;
            height: 10px;
            background-color: #fff;
            border-radius: 50%;
        }
        
        .task-complete-checkbox:hover {
            border-color: #555;
        }
        
        .task-complete-checkbox:focus {
            box-shadow: 0 0 0 3px rgba(128, 128, 128, 0.5);
        }
        
        /* =========================================
           5. Empty State Styles
        ========================================= */
        .empty-state {
            text-align: center;
            margin-top: 50px;
            position: relative;
        }
        
        .empty-state img {
            max-width: 100%;
            height: auto;
            max-height: 250px;
            border-radius: 10px;
        }
        
        .empty-state p {
            margin-top: 15px;
            color: #555;
            font-size: 18px;
        }
        
        /* =========================================
           6. Floating Action Button (FAB) Styles
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
        
        @media (min-width: 769px) {
            .fab {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .fab {
                display: flex;
            }
            .add-button-container {
                display: none !important;
            }
        }
        
        /* =========================================
           7. Create Project Task Modal Styles
        ========================================= */
        .custom-modal-content {
            background-color: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            position: relative;
        }
        
        .modal-footer {
            border-top: none;
            display: flex;
            justify-content: flex-end;
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
        
        .icon-button .material-symbols-outlined {
            font-size: 24px;
        }
        
        /* =========================================
           8. Completion Rate Tips and Overdue Streak Styles
        ========================================= */
        #completion-tips-container {
            display: none;
            max-width: 800px;
            margin: 0 auto;
        }
        
        #overdue-streak-container {
            display: none;
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* =========================================
           9. Loading Overlay Styles
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
            to {
                transform: rotate(360deg);
            }
        }
        
        /* =========================================
           10. Accessibility Enhancements
        ========================================= */
        .card-title,
        .empty-state p,
        .add-link span {
            color: #333;
        }
        
        /* =========================================
           11. Responsive Adjustments
        ========================================= */
        .task-cards {
            padding-top: 0;
        }
        
        @media (min-width: 768px) {
            .add-button-container {
                margin-top: 20px;
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 767px) {
            .add-button-container {
                margin-top: 20px;
                margin-bottom: 20px;
            }
        }
        
        /* =========================================
           12. Tooltips Styles
        ========================================= */
        .tooltip-inner {
            background-color: #555;
            color: #fff;
            font-size: 14px;
            border-radius: 4px;
        }
        
        .bs-tooltip-top .tooltip-arrow::before,
        .bs-tooltip-auto[x-placement^="top"] .tooltip-arrow::before {
            border-top-color: #555;
        }
        
        .bs-tooltip-bottom .tooltip-arrow::before,
        .bs-tooltip-auto[x-placement^="bottom"] .tooltip-arrow::before {
            border-bottom-color: #555;
        }
        
        .bs-tooltip-left .tooltip-arrow::before,
        .bs-tooltip-auto[x-placement^="left"] .tooltip-arrow::before {
            border-left-color: #555;
        }
        
        .bs-tooltip-right .tooltip-arrow::before,
        .bs-tooltip-auto[x-placement^="right"] .tooltip-arrow::before {
            border-right-color: #555;
        }
    </style>
</head>
<body>
    
    <!-- Top App Bar -->
    <div class="app-bar">
        <!-- Back Icon (changed to chevron_left) -->
        <span class="material-symbols-outlined back-icon header-icon"
              onclick="window.history.back();"
              tabindex="0"
              role="button"
              aria-label="Go Back"
              title="Go Back">
            chevron_left
        </span>

        <!-- Title -->
        <h1 class="app-bar-title">{{ $project->name }}</h1>

        <!-- App Bar Actions -->
        <div class="app-bar-actions">
            <!-- Project Members Icon Link (changed to person_add) -->
            <a href="{{ route('projects.members', ['project' => $project->id]) }}"
               class="user-icon-link header-icon"
               aria-label="Project Members"
               title="Project Members">
                <span class="material-symbols-outlined">person_add</span>
            </a>

            <!-- More Options Dropdown Trigger (changed to more_horiz) -->
            <span class="material-symbols-outlined dropdown-trigger header-icon"
                  id="dropdown-trigger"
                  role="button"
                  tabindex="0"
                  aria-haspopup="true"
                  aria-expanded="false"
                  title="More Options">
                more_horiz
            </span>
        </div>

        <!-- Dropdown Menu -->
        <ul id="project-dropdown" class="dropdown-content" aria-labelledby="dropdown-trigger">
            <li>
                <a href="{{ route('projects.edit', $project->id) }}">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Project
                </a>
            </li>
            <li>
                <button type="button" class="dropdown-button w-100 text-start" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <span class="material-symbols-outlined">delete</span>
                    Delete Project
                </button>
            </li>
        </ul>
    </div> 

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content position-relative">
        <!-- Filter Buttons -->
        <div class="task-filter" role="group" aria-label="Task Filters">
            <button class="filter-btn active" data-filter="all" aria-pressed="true" title="Show All Tasks" data-bs-toggle="tooltip" data-bs-placement="top">
                All
            </button>
            <button class="filter-btn" data-filter="pending" aria-pressed="false" title="Show Pending Tasks" data-bs-toggle="tooltip" data-bs-placement="top">
                Pending
            </button>
            <button class="filter-btn" data-filter="overdue" aria-pressed="false" title="Show Overdue Tasks" data-bs-toggle="tooltip" data-bs-placement="top">
                Overdue
            </button>
            <button class="filter-btn" data-filter="completed" aria-pressed="false" title="Show Completed Tasks" data-bs-toggle="tooltip" data-bs-placement="top">
                Completed
            </button>
        </div>

        <!-- Completion Rate Tips -->
        <div id="completion-tips-container" class="alert alert-secondary alert-dismissible fade show text-center mb-4" style="display:none;" role="alert">
            <strong>Tip:</strong> You have quite a few pending or overdue tasks. Consider breaking them into smaller subtasks or setting reminders!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- Overdue Streak Suggestion -->
        <div id="overdue-streak-container" class="alert alert-warning alert-dismissible fade show text-center mb-4" style="display:none;" role="alert">
            <strong>Suggestion:</strong> It appears tasks with certain labels frequently end up overdue. Try scheduling them earlier or adjusting due dates.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- "New Project Task" Button (Visible on Desktop only) -->
        <div class="add-button-container d-flex justify-content-center mb-4">
            <a href="#" class="add-link text-dark text-decoration-none d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createProjectTaskModal" aria-label="Create New Project Task" title="Create New Project Task">
                <i class="bi bi-plus me-2"></i>
                <span>New Project Task</span>
            </a>
        </div>

        <!-- Project Tasks Section -->
        @if($project->tasks->isEmpty())
            <div class="empty-state position-relative">
                <img src="{{ asset('images/task1.png') }}" alt="No Tasks Illustration" class="emptystate">
                <p>No tasks yet</p>
            </div>
        @else
            <div class="task-cards container">
                <div class="row" id="project-tasks-row">
                    @foreach($project->tasks as $task)
                        <div class="col-md-4 mb-4 task-card" 
                             data-task-id="{{ $task->id }}" 
                             data-task-url="{{ route('projecttasks.show', [$project->id, $task->id]) }}" 
                             data-task-status="{{ strtolower($task->status) }}" 
                             data-task-priority="{{ strtolower($task->priority) }}" 
                             data-task-duedate="{{ $task->due_date ? $task->due_date->toDateString() : '' }}" 
                             data-task-label="{{ $task->label ? $task->label->name : '' }}" 
                             role="button" 
                             tabindex="0" 
                             aria-label="View Task: {{ $task->title }}" 
                             title="View Task: {{ $task->title }}" 
                             data-bs-toggle="tooltip" 
                             data-bs-placement="top">
                            <div class="card h-100 {{ ($task->status === 'pending' && $task->due_date && $task->due_date->lt(\Carbon\Carbon::today())) ? 'overdue' : '' }}">
                                <div class="task-checkbox">
                                    <input type="checkbox" class="task-complete-checkbox" data-task-id="{{ $task->id }}" {{ strtolower($task->status) === 'completed' ? 'checked' : '' }} aria-label="Mark as Completed" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark task as completed.">
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</p>
                                    <p class="card-text"><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
                                    <p class="card-text">
                                        <strong>Status:</strong> 
                                        @if ($task->status === 'pending' && $task->due_date && $task->due_date->lt(\Carbon\Carbon::today()))
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
            </div>

            <!-- Empty States for Each Filter -->
            <div id="no-tasks-all" class="empty-state position-relative" style="display:none;">
                <img src="{{ asset('images/task1.png') }}" alt="No Tasks Illustration" class="emptystate">
                <p>No tasks available.</p>
            </div>
            <div id="no-tasks-pending" class="empty-state position-relative" style="display:none;">
                <img src="{{ asset('images/task1.png') }}" alt="No Pending Tasks Illustration" class="emptystate">
                <p>No pending tasks yet.</p>
            </div>
            <div id="no-tasks-overdue" class="empty-state position-relative" style="display:none;">
                <img src="{{ asset('images/task1.png') }}" alt="No Overdue Tasks Illustration" class="emptystate">
                <p>No overdue tasks.</p>
            </div>
            <div id="no-tasks-completed" class="empty-state position-relative" style="display:none;">
                <img src="{{ asset('images/task1.png') }}" alt="No Completed Tasks Illustration" class="emptystate">
                <p>No completed tasks yet.</p>
            </div>
        @endif

        <!-- Floating Action Button (FAB) for Mobile -->
        <div class="fab-container d-block d-md-none">
            <div class="fab" id="fab" aria-label="Add Task" tabindex="0" role="button" title="Add Task"
                 data-bs-toggle="modal" data-bs-target="#createProjectTaskModal">
                <i class="bi bi-plus" aria-hidden="true"></i>
            </div>
        </div>

        <!-- Toast Notification -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <!-- Toastr handles the toast notifications -->
        </div>
    </main>

    <!-- Create Project Task Modal -->
    <div class="modal fade" id="createProjectTaskModal" tabindex="-1" aria-labelledby="createProjectTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content custom-modal-content">
                <div class="modal-body">
                    <form id="create-project-task-form" action="{{ route('projecttasks.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter Task Title" required autofocus data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the title of the task.">
                            @error('title')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter Description" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter a detailed description of the task.">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required data-bs-toggle="tooltip" data-bs-placement="top" title="Select the due date for the task.">
                            @error('due_date')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                            <select class="form-control" id="priority" name="priority" required data-bs-toggle="tooltip" data-bs-placement="top" title="Select the priority level of the task.">
                                <option value="" disabled selected>Select Priority</option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            </select>
                            @error('priority')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Enter Notes" data-bs-toggle="tooltip" data-bs-placement="top" title="Add any additional notes for the task.">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="attachments" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="attachments" name="attachments" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach any relevant files to the task.">
                            @error('attachments')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group form-check mb-4">
                            <input type="hidden" name="reminder" value="0">
                            <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder') ? 'checked' : '' }} data-bs-toggle="tooltip" data-bs-placement="top" title="Check to set a reminder for this task.">
                            <label class="form-check-label" for="reminder">Set Reminder</label>
                            @error('reminder')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                    <button type="submit" form="create-project-task-form" class="icon-button" aria-label="Save Task" title="Save Task" data-bs-toggle="tooltip" data-bs-placement="top">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Create Project Task Modal -->

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this project? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <form id="delete-project-form" action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Confirm Delete Modal -->

    <!-- Loading Overlay -->
    <div class="loading-overlay d-none" id="loading-overlay" aria-hidden="true">
        <div class="loading-spinner"></div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(el => new bootstrap.Tooltip(el, { trigger: 'hover focus' }));
        
        function hideAllTooltips() {
            tooltipList.forEach(tooltip => tooltip.hide());
        }
        
        // Dropdown Menu for Project Actions
        const dropdownTrigger = document.querySelector('#dropdown-trigger');
        const dropdownMenu = document.querySelector('#project-dropdown');
        
        dropdownTrigger.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('open');
            hideAllTooltips();
        });
        
        dropdownTrigger.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                dropdownTrigger.click();
            }
        });
        
        document.addEventListener('click', function(event) {
            if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('open');
                hideAllTooltips();
            }
        });
        
        // Toastr Options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "3000",
        };
        
        // Task Cards Navigation
        const taskCards = document.querySelectorAll('.task-card');
        taskCards.forEach(function(card) {
            card.addEventListener('click', function(event) {
                const target = event.target;
                if (!target.classList.contains('task-complete-checkbox')) {
                    const url = card.getAttribute('data-task-url');
                    if (url) {
                        window.location.href = url;
                    } else {
                        console.error('No URL found for this task card.');
                    }
                }
            });
            
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
        });
        
        // Filter Functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const allTaskCards = document.querySelectorAll('.task-card');
        const taskCardsContainer = document.querySelector('.task-cards');
        const emptyStates = {
            'all': document.getElementById('no-tasks-all'),
            'pending': document.getElementById('no-tasks-pending'),
            'overdue': document.getElementById('no-tasks-overdue'),
            'completed': document.getElementById('no-tasks-completed')
        };
        
        function hideAllEmptyStates() {
            Object.values(emptyStates).forEach(state => {
                if(state) state.style.display = 'none';
            });
        }
        
        let currentFilter = 'all';
        
        function filterTasks(filter) {
            currentFilter = filter;
            let matchingTasks = 0;
            allTaskCards.forEach(card => {
                const status = card.getAttribute('data-task-status');
                const isOverdue = card.querySelector('.card').classList.contains('overdue');
                if (filter === 'all') {
                    card.style.display = 'block';
                    matchingTasks++;
                } else if (filter === 'pending') {
                    if (status === 'pending') {
                        card.style.display = 'block';
                        matchingTasks++;
                    } else {
                        card.style.display = 'none';
                    }
                } else if (filter === 'completed') {
                    if (status === 'completed') {
                        card.style.display = 'block';
                        matchingTasks++;
                    } else {
                        card.style.display = 'none';
                    }
                } else if (filter === 'overdue') {
                    if (isOverdue) {
                        card.style.display = 'block';
                        matchingTasks++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        
            hideAllEmptyStates();
        
            if (matchingTasks === 0) {
                if (emptyStates[currentFilter]) {
                    emptyStates[currentFilter].style.display = 'block';
                } else {
                    document.querySelector('.empty-state').style.display = 'block';
                }
                taskCardsContainer.style.display = 'none';
            } else {
                taskCardsContainer.style.display = 'block';
                hideAllEmptyStates();
            }
        }
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-pressed', 'false');
                });
                button.classList.add('active');
                button.setAttribute('aria-pressed', 'true');
                const filter = button.getAttribute('data-filter');
                filterTasks(filter);
                hideAllTooltips();
            });
        });
        
        filterTasks('all');
        
        // SMART FEATURES LOGIC
        const allTasks = document.querySelectorAll('.task-card');
        let pendingCount = 0;
        let overdueCount = 0;
        let completedCountToday = 0; 
        allTasks.forEach(card => {
            const status = card.getAttribute('data-task-status');
            if (status === 'completed') {
                completedCountToday++;
            } else if (card.querySelector('.card').classList.contains('overdue')) {
                overdueCount++;
            } else if (status === 'pending') {
                pendingCount++;
            }
        });
        
        const completionTipsContainer = document.getElementById('completion-tips-container');
        if ((pendingCount + overdueCount) > completedCountToday && (pendingCount + overdueCount) > 3) {
            completionTipsContainer.style.display = 'block';
        }
        
        const labelOverdueCount = {};
        allTasks.forEach(card => {
            if (card.querySelector('.card').classList.contains('overdue')) {
                const lbl = card.getAttribute('data-task-label') || 'No Label';
                labelOverdueCount[lbl] = (labelOverdueCount[lbl] || 0) + 1;
            }
        });
        
        const overdueStreakContainer = document.getElementById('overdue-streak-container');
        for (const lbl in labelOverdueCount) {
            if (labelOverdueCount[lbl] > 2) {
                overdueStreakContainer.style.display = 'block';
                break;
            }
        }
        
        // AJAX Submission for Create Project Task Form
        const createProjectTaskForm = document.getElementById('create-project-task-form');
        createProjectTaskForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const url = form.action;
            const formData = new FormData(form);
            const loadingOverlay = document.getElementById('loading-overlay');
            loadingOverlay.classList.remove('d-none');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loadingOverlay.classList.add('d-none');
                if (data.success) {
                    form.reset();
                    const modalElement = document.getElementById('createProjectTaskModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                    const newTaskHtml = generateProjectTaskCardHtml(data.task);
                    const tasksRow = document.getElementById('project-tasks-row');
                    tasksRow.insertAdjacentHTML('beforeend', newTaskHtml);
                    const newTooltips = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    newTooltips.forEach(el => new bootstrap.Tooltip(el, { trigger: 'hover focus' }));
                    attachProjectTaskCheckboxListener();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                loadingOverlay.classList.add('d-none');
                console.error('Error:', error);
                toastr.error('An error occurred while creating the task.');
            });
        });
        
        function generateProjectTaskCardHtml(task) {
            let isOverdue = false;
            if(task.status === 'pending' && task.due_date) {
                const dueDate = new Date(task.due_date);
                const today = new Date();
                today.setHours(0,0,0,0);
                if(dueDate < today) {
                    isOverdue = true;
                }
            }
            const taskUrl = /projects/${projectId}/tasks/${task.id};
            return 
            <div class="col-md-4 mb-4 task-card" 
                 data-task-id="${task.id}" 
                 data-task-url="${taskUrl}" 
                 data-task-status="${task.status.toLowerCase()}" 
                 data-task-priority="${task.priority.toLowerCase()}" 
                 data-task-duedate="${task.due_date ? task.due_date : ''}" 
                 data-task-label="${task.label ? task.label.name : ''}" 
                 role="button" 
                 tabindex="0" 
                 aria-label="View Task: ${task.title}" 
                 title="View Task: ${task.title}" 
                 data-bs-toggle="tooltip" 
                 data-bs-placement="top">
                <div class="card h-100 ${ (task.status === 'pending' && isOverdue) ? 'overdue' : '' }">
                    <div class="task-checkbox">
                        <input type="checkbox" class="task-complete-checkbox" data-task-id="${task.id}" ${task.status.toLowerCase() === 'completed' ? 'checked' : ''} aria-label="Mark as Completed" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark task as completed.">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${task.title}</h5>
                        <p class="card-text"><strong>Due Date:</strong> ${task.due_date ? new Date(task.due_date).toISOString().slice(0,10) : 'No due date'}</p>
                        <p class="card-text"><strong>Priority:</strong> ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}</p>
                        <p class="card-text"><strong>Status:</strong> ${ (task.status === 'pending' && isOverdue) ? '<span class="overdue-status">Overdue</span>' : task.status.charAt(0).toUpperCase() + task.status.slice(1) }</p>
                        ${ task.label ? <span class="label-pill" style="background-color: ${task.label.color};" aria-label="Label: ${task.label.name}">${task.label.name}</span> : '' }
                    </div>
                </div>
            </div>
            ;
        }
        
        function attachProjectTaskCheckboxListener() {
            const checkboxes = document.querySelectorAll('.task-card .task-complete-checkbox');
            checkboxes.forEach(checkbox => {
                const newCheckbox = checkbox.cloneNode(true);
                checkbox.parentNode.replaceChild(newCheckbox, checkbox);
                newCheckbox.addEventListener('change', function(event) {
                    event.stopPropagation();
                    const checkboxElement = this;
                    const taskId = checkboxElement.getAttribute('data-task-id');
                    const isChecked = checkboxElement.checked;
                    const loadingOverlay = document.getElementById('loading-overlay');
                    loadingOverlay.classList.remove('d-none');
                    const url = /projects/${projectId}/tasks/${taskId}/status;
                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ status: isChecked ? 'completed' : 'pending' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        loadingOverlay.classList.add('d-none');
                        if (data.success) {
                            const taskCard = document.querySelector(.task-card[data-task-id="${taskId}"]);
                            taskCard.setAttribute('data-task-status', isChecked ? 'completed' : 'pending');
                            const cardBodyParagraphs = taskCard.querySelectorAll('.card-body p');
                            const statusParagraph = cardBodyParagraphs[2];
                            if (isChecked) {
                                statusParagraph.innerHTML = '<strong>Status:</strong> <span class="overdue-status">Completed</span>';
                                const titleElement = taskCard.querySelector('.card-title');
                                titleElement.style.textDecoration = 'line-through';
                                taskCard.querySelector('.card').classList.remove('overdue');
                            } else {
                                statusParagraph.innerHTML = '<strong>Status:</strong> Pending';
                                const titleElement = taskCard.querySelector('.card-title');
                                titleElement.style.textDecoration = 'none';
                                const dueDateText = taskCard.querySelector('.card-body p:nth-of-type(1)').textContent.replace('Due Date:', '').trim();
                                const dueDateValue = dueDateText && dueDateText !== 'No due date' ? new Date(dueDateText) : null;
                                const today = new Date();
                                today.setHours(0,0,0,0);
                                if (dueDateValue && dueDateValue < today) {
                                    statusParagraph.innerHTML = '<strong>Status:</strong> <span class="overdue-status">Overdue</span>';
                                    taskCard.querySelector('.card').classList.add('overdue');
                                } else {
                                    taskCard.querySelector('.card').classList.remove('overdue');
                                }
                            }
                        } else {
                            alert('Failed to update task status: ' + data.message);
                            checkboxElement.checked = !isChecked;
                        }
                    })
                    .catch(error => {
                        loadingOverlay.classList.add('d-none');
                        console.error('Error:', error);
                        alert('An error occurred while updating the task status.');
                        checkboxElement.checked = !isChecked;
                    });
                });
            });
        }
        
        attachProjectTaskCheckboxListener();
    });
    </script>
</body>
</html>