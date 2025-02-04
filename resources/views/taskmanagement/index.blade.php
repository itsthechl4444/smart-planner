<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Canvas Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header class="header" role="banner">
        <button class="menu-icon btn btn-link" id="menu-icon" aria-label="Toggle Sidebar" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="title">Task Management</div>
        <div class="spacer" aria-hidden="true"></div>
    </header>
    
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Container -->
    <div class="container">
        <main class="main-content">
            <!-- Global Search -->
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
                <div class="search-cards"></div>
                <div class="nothing-here" id="no-search-results" style="display: none;">
                    <img src="{{ asset('images/empty.svg') }}" alt="No results found" class="no-data-illustration">
                    <p>No records match your search.</p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs" role="tablist">
                <button class="tab-link active" onclick="openTab(event, 'tasks')" role="tab" aria-selected="true" aria-controls="tasks" aria-label="Tasks" title="View Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all tasks.">
                    <span class="material-icons-outlined tab-icon" aria-hidden="true">check_box</span>
                    Tasks
                </button>
                <button class="tab-link" onclick="openTab(event, 'labels')" role="tab" aria-selected="false" aria-controls="labels" aria-label="Labels" title="View Labels" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all labels.">
                    <span class="material-icons-outlined tab-icon" aria-hidden="true">label</span>
                    Labels
                </button>
                <button class="tab-link" onclick="openTab(event, 'projects')" role="tab" aria-selected="false" aria-controls="projects" aria-label="Projects" title="View Projects" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view all projects.">
                    <span class="material-icons-outlined tab-icon" aria-hidden="true">folder</span>
                    Projects
                </button>
            </div>

            <!-- Tasks Section -->
            <div id="tasks" class="tab-content active" role="tabpanel" aria-labelledby="tasks">
                <!-- Filter Buttons -->
                <div class="task-filter" role="group" aria-label="Task Filters">
                    <button class="filter-btn active" data-filter="all" aria-pressed="true" aria-label="Show All Tasks" title="Show All Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="View all tasks.">
                        All
                    </button>
                    <button class="filter-btn" data-filter="pending" aria-pressed="false" aria-label="Show Pending Tasks" title="Show Pending Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="View only pending tasks.">
                        Pending
                    </button>
                    <button class="filter-btn" data-filter="completed" aria-pressed="false" aria-label="Show Completed Tasks" title="Show Completed Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="View only completed tasks.">
                        Completed
                    </button>
                    <button class="filter-btn" data-filter="overdue" aria-pressed="false" aria-label="Show Overdue Tasks" title="Show Overdue Tasks" data-bs-toggle="tooltip" data-bs-placement="top" title="View only overdue tasks.">
                        Overdue
                    </button>
                </div>

                <!-- Smart Sorting Options -->
                <div class="task-sort" style="text-align:center; margin-bottom:20px;">
                    <button class="btn btn-sm btn-outline-secondary" id="sort-by-priority" title="Sort by Priority" data-bs-toggle="tooltip" data-bs-placement="top" title="Sort tasks by priority.">Sort by Priority</button>
                    <button class="btn btn-sm btn-outline-secondary" id="sort-by-due-date" title="Sort by Due Date" data-bs-toggle="tooltip" data-bs-placement="top" title="Sort tasks by due date.">Sort by Due Date</button>
                </div>

                <!-- Completion Rate Tips -->
                <div id="completion-tips-container" class="alert alert-info" style="display:none; max-width:800px; margin:0 auto; margin-bottom:20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Tips to improve your task completion rate.">
                    <strong>Tip:</strong> You have quite a few pending or overdue tasks. Consider breaking them into smaller subtasks or setting reminders!
                </div>

                <!-- Overdue Streak Suggestion -->
                <div id="overdue-streak-container" class="alert alert-warning" style="display:none; max-width:800px; margin:0 auto; margin-bottom:20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Suggestions to manage overdue tasks better.">
                    <strong>Suggestion:</strong> It appears tasks with certain labels frequently end up overdue. Try scheduling them earlier or adjusting due dates.
                </div>

                <!-- New Task for Desktop -->
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
                            data-bs-placement="top"
                            title="Click to view task details.">

                            <div class="task-checkbox">
                                <input type="checkbox" class="task-complete-checkbox" 
                                       data-task-id="{{ $task->id }}" 
                                       {{ strtolower($task->status) === 'completed' ? 'checked' : '' }}
                                       aria-label="Mark as Completed"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Mark task as completed.">
                            </div>
                            
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
                <!-- New Label for Desktop -->
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
                                data-bs-placement="top"
                                title="Click to view label details.">
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
                <!-- New Project for Desktop -->
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
                                aria-label="View Project: {{ $project->name }} "
                                title="View Project: {{ $project->name }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Click to view project details.">
                                <div class="card-content">
                                    <span class="card-title">{{ $project->name }}</span>
                                    <p>{{ $project->description ?? 'No description' }}</p>
                                    <p>Start Date: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'N/A' }}</p>
                                    <p>End Date: {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : 'N/A' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>

        <!-- FAB (Visible Only on Mobile) -->
        <div class="fab" id="fab" role="button" aria-label="Add New" title="Add New" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="left" title="Click to add a new task, label, or project.">
            <i class="bi bi-plus" aria-hidden="true"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createTaskModal" role="button" aria-label="Create New Task" title="Create New Task" data-bs-toggle="tooltip" data-bs-placement="left" title="Add a new task.">
                <i class="bi bi-check-circle" aria-hidden="true"></i> New Task
            </button>
            <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createLabelModal" role="button" aria-label="Create New Label" title="Create New Label" data-bs-toggle="tooltip" data-bs-placement="left" title="Add a new label.">
                <i class="bi bi-tag" aria-hidden="true"></i> New Label
            </button>
            <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createProjectModal" role="button" aria-label="Create New Project" title="Create New Project" data-bs-toggle="tooltip" data-bs-placement="left" title="Add a new project.">
                <i class="bi bi-folder" aria-hidden="true"></i> New Project
            </button>
        </div>

        <!-- Bottom Navbar -->
        <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
            <a href="{{ route('dashboard') }}" class="navbar-item" aria-label="Dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="top" title="Go to Dashboard">
                <i class="bi bi-house-door" aria-hidden="true"></i>
            </a>
            <a href="{{ route('taskmanagement.index') }}" class="navbar-item active" aria-label="Task Management" title="Task Management" data-bs-toggle="tooltip" data-bs-placement="top" title="View Task Management">
                <i class="bi bi-list-task" aria-hidden="true"></i>
            </a>
            <a href="{{ route('financemanagement.index') }}" class="navbar-item" aria-label="Finance Management" title="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top" title="View Finance Management">
                <i class="bi bi-currency-dollar" aria-hidden="true"></i>
            </a>
            <a href="{{ route('calendar.index') }}" class="navbar-item" aria-label="Calendar" title="Calendar" data-bs-toggle="tooltip" data-bs-placement="top" title="View Calendar">
                <i class="bi bi-calendar" aria-hidden="true"></i>
            </a>
            <a href="{{ route('notifications.index') }}" class="navbar-item" aria-label="Notifications" title="Notifications" data-bs-toggle="tooltip" data-bs-placement="top" title="View Notifications">
                <i class="bi bi-bell" aria-hidden="true"></i>
            </a>
            <a href="{{ route('tips') }}" class="navbar-item" aria-label="Tips & Best Practices" title="Tips & Best Practices" data-bs-toggle="tooltip" data-bs-placement="top" title="View Tips & Best Practices">
                <i class="bi bi-lightbulb" aria-hidden="true"></i>
            </a>
            <a href="{{ route('reports') }}" class="navbar-item" aria-label="Reports" title="Reports" data-bs-toggle="tooltip" data-bs-placement="top" title="View Reports">
                <i class="bi bi-bar-chart" aria-hidden="true"></i>
            </a>
        </nav>

        <!-- Create Task Modal -->
        <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="create-task-form" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                            <div class="form-group">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter Task Title" required autofocus aria-required="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the title of the task.">
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
                        <button type="submit" form="create-task-form" class="icon-button" aria-label="Save Task" title="Save Task" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save the task.">
                            <span class="material-icons-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Create Task Modal -->

        <!-- Create Label Modal -->
        <div class="modal fade" id="createLabelModal" tabindex="-1" aria-labelledby="createLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="create-label-form" action="{{ route('labels.store') }}" method="POST">
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
                                <input type="color" class="form-control form-control-color" id="label-color" name="color" value="{{ old('color', '#007bff') }}" title="Choose your color" aria-label="Choose Label Color" data-bs-toggle="tooltip" data-bs-placement="top" title="Select a color for the label.">
                                @error('color')<span class="text-danger" role="alert">{{ $message }}</span>@enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
                            <span class="material-icons-outlined">close</span>
                        </button>
                        <button type="submit" form="create-label-form" class="icon-button" aria-label="Save Label" title="Save Label" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save the label.">
                            <span class="material-icons-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Create Label Modal -->

        <!-- Create Project Modal -->
        <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="create-project-form" action="{{ route('projects.store') }}" method="POST">
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
                        <button type="submit" form="create-project-form" class="icon-button" aria-label="Save Project" title="Save Project" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save the project.">
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
                        <img src="https://i.imgur.com/4AI6ZKd.png" alt="Congratulations" class="congrats-illustration mb-4">
                        <h2>Congratulations! 🎉</h2>
                        <p>You've completed 5 tasks today! Keep up the great work.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="filter-btn" data-bs-dismiss="modal" aria-label="Close" title="Awesome!" data-bs-toggle="tooltip" data-bs-placement="top" title="Close the congratulations message.">Awesome!</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Congratulations Modal -->

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loading-overlay" aria-hidden="true">
            <div class="loading-spinner"></div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize all Bootstrap tooltips
            const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, { trigger: 'hover focus' }));

            function hideAllTooltips() {
                tooltipList.forEach(tooltip => tooltip.hide());
            }

            const menuIcon = document.getElementById('menu-icon');
            const container = document.querySelector('.container');
            menuIcon.addEventListener('click', () => {
                container.classList.toggle('sidebar-collapsed');
                hideAllTooltips();
            });

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
            });

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
                    if (activeTab) {
                        activeTab.style.display = 'block';
                    }
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
                            const projectStartDate = card.querySelector('.card-content p:nth-child(3)');
                            const projectEndDate = card.querySelector('.card-content p:nth-child(4)');
                            cardContentText = (projectDescription ? projectDescription.textContent.toLowerCase() : '') + ' ' +
                                              (projectStartDate ? projectStartDate.textContent.toLowerCase() : '') + ' ' +
                                              (projectEndDate ? projectEndDate.textContent.toLowerCase() : '');
                        }

                        if (cardTitle.includes(query) || cardContentText.includes(query)) {
                            const clonedCard = card.cloneNode(true);
                            clonedCard.querySelectorAll('*').forEach(element => {
                                const newEl = element.cloneNode(true);
                                element.parentNode.replaceChild(newEl, element);
                            });
                            searchCardsContainer.appendChild(clonedCard);
                        }
                    });
                });

                const totalResults = searchCardsContainer.querySelectorAll('.card').length;
                if (totalResults === 0) {
                    noSearchResults.style.display = 'flex';
                } else {
                    noSearchResults.style.display = 'none';
                }
                searchResults.style.display = 'block';
                hideAllTooltips();
            }, 300));

            clearSearch.addEventListener('click', () => {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                hideAllTooltips();
            });

            searchCardsContainer.addEventListener('click', (event) => {
                const card = event.target.closest('.card');
                if (card) {
                    let url = '';
                    if (card.classList.contains('task-card')) {
                        url = card.getAttribute('data-task-url');
                    } else if (card.classList.contains('label-card')) {
                        url = card.getAttribute('data-label-url');
                    } else if (card.classList.contains('project-card')) {
                        url = card.getAttribute('data-project-url');
                    }

                    if (url) {
                        window.location.href = url;
                    } else {
                        console.error('URL not found for this card.');
                    }
                    hideAllTooltips();
                }
            });

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

            // Track current filter
            let currentFilter = 'all';

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
                    // Reset to 'all' when switching to tasks
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
            }

            // Daily completion logic
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
                // Mark that we've shown it today
                localStorage.setItem('congratsShownForToday', 'true');
            }

            function checkTaskCompletion() {
                // Increment and store count
                completedTasksCount++;
                localStorage.setItem('completedTasksCount', completedTasksCount.toString());

                // Only show if not shown today
                if (completedTasksCount >= 5 && localStorage.getItem('congratsShownForToday') === 'false') {
                    celebrateCompletion();
                }
            }

            const filterButtons = document.querySelectorAll('.filter-btn');
            const taskCards = document.querySelectorAll('.task-card');
            const noTasksMessage = document.getElementById('no-tasks-message');
            const noTasksText = document.getElementById('no-tasks-text');

            function filterTasks(filter) {
                currentFilter = filter;
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
                    if (filter === 'all') {
                        noTasksText.textContent = 'No tasks at all.';
                    } else if (filter === 'pending') {
                        noTasksText.textContent = 'No pending tasks.';
                    } else if (filter === 'completed') {
                        noTasksText.textContent = 'No completed tasks yet.';
                    } else if (filter === 'overdue') {
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

            // Handle task completion without reloading page
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
                        const loadingOverlay = document.getElementById('loading-overlay');
                        loadingOverlay.style.display = 'flex';
                        
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
                            loadingOverlay.style.display = 'none';
                            if (data.success) {
                                const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
                                // Update the data-task-status attribute
                                taskCard.setAttribute('data-task-status', isChecked ? 'completed' : 'pending');
                                const statusElement = taskCard.querySelector('.task-info p:nth-child(4)');
                                const titleElement = taskCard.querySelector('.card-title');
                                if (isChecked) {
                                    statusElement.innerHTML = 'Status: <span class="overdue-status">Completed</span>';
                                    titleElement.style.textDecoration = 'line-through';
                                    titleElement.style.color = '#6c757d';
                                    taskCard.classList.remove('overdue');
                                    checkTaskCompletion(); // Increment daily completion counter
                                } else {
                                    statusElement.textContent = 'Status: Pending';
                                    titleElement.style.textDecoration = 'none';
                                    titleElement.style.color = '#333';
                                    // Re-check overdue status if needed
                                    const dueDateTextRecheck = taskCard.querySelector('.task-info p:nth-child(2)').textContent.replace('Due Date:', '').trim();
                                    const dueDateValueRecheck = dueDateTextRecheck && dueDateTextRecheck !== 'No due date' ? new Date(dueDateTextRecheck) : null;
                                    const todayRecheck = new Date();
                                    todayRecheck.setHours(0,0,0,0);
                                    if (dueDateValueRecheck && dueDateValueRecheck < todayRecheck) {
                                        statusElement.innerHTML = 'Status: <span class="overdue-status">Overdue</span>';
                                        taskCard.classList.add('overdue');
                                    } else {
                                        taskCard.classList.remove('overdue');
                                    }
                                }
                                // Reapply the current filter to update view automatically
                                filterTasks(currentFilter);
                            } else {
                                alert('Failed to update task status: ' + data.message);
                                this.checked = !isChecked;
                            }
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error:', error);
                            alert('An error occurred while updating the task status.');
                            this.checked = !isChecked;
                        });
                    });
                });
            }
            handleTaskCompletion();

            const observer = new MutationObserver(() => {
                handleTaskCompletion();
            });
            const taskCardsContainer = document.querySelector('.task-cards');
            if (taskCardsContainer) {
                observer.observe(taskCardsContainer, { childList: true, subtree: true });
            }
            const searchCardsContainerObserved = document.querySelector('.search-cards');
            if (searchCardsContainerObserved) {
                observer.observe(searchCardsContainerObserved, { childList: true, subtree: true });
            }

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

            // SMART FEATURES LOGIC

            // Count pending/overdue vs completed
            const allTasks = document.querySelectorAll('.task-card');
            let pendingCount = 0;
            let overdueCount = 0;
            let completedCountToday = 0; 
            allTasks.forEach(card => {
                const status = card.getAttribute('data-task-status');
                if (status === 'completed') {
                    completedCountToday++;
                } else if (card.classList.contains('overdue')) {
                    overdueCount++;
                } else if (status === 'pending') {
                    pendingCount++;
                }
            });

            const completionTipsContainer = document.getElementById('completion-tips-container');
            if ((pendingCount + overdueCount) > completedCountToday && (pendingCount + overdueCount) > 3) {
                completionTipsContainer.style.display = 'block';
            }

            const sortByPriorityBtn = document.getElementById('sort-by-priority');
            const sortByDueDateBtn = document.getElementById('sort-by-due-date');

            function sortTasks(criteria) {
                const visibleTasks = Array.from(document.querySelectorAll('.task-card')).filter(card => card.style.display !== 'none');
                const parent = document.querySelector('.task-cards');

                visibleTasks.sort((a, b) => {
                    if (criteria === 'priority') {
                        const priorityOrder = { 'high': 1, 'medium': 2, 'low': 3 };
                        const aPriority = priorityOrder[a.getAttribute('data-task-priority')] || 99;
                        const bPriority = priorityOrder[b.getAttribute('data-task-priority')] || 99;
                        return aPriority - bPriority;
                    } else if (criteria === 'dueDate') {
                        const aDue = a.getAttribute('data-task-duedate') || '';
                        const bDue = b.getAttribute('data-task-duedate') || '';
                        if (!aDue && !bDue) return 0;
                        if (!aDue) return 1;
                        if (!bDue) return -1;
                        const aDate = new Date(aDue);
                        const bDate = new Date(bDue);
                        return aDate - bDate;
                    }
                    return 0;
                });

                visibleTasks.forEach(t => parent.appendChild(t));
                hideAllTooltips();
            }

            sortByPriorityBtn.addEventListener('click', () => {
                sortTasks('priority');
            });

            sortByDueDateBtn.addEventListener('click', () => {
                sortTasks('dueDate');
            });

            // Overdue Streak Detection
            const labelOverdueCount = {};
            allTasks.forEach(card => {
                if (card.classList.contains('overdue')) {
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

            // AUTOMATICALLY OPEN THE LABELS TAB IF A NEW LABEL WAS JUST CREATED
            @if(session('activeTab') === 'labels')
                // Delay slightly to ensure elements are loaded
                setTimeout(function() {
                    // Simulate a click on the tab link for labels
                    const labelsTabLink = document.querySelector('.tab-link[aria-controls="labels"]');
                    if (labelsTabLink) {
                        labelsTabLink.click();
                    }
                }, 100);
            @endif

        });
    </script>
</body>
</html>
