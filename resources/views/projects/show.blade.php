<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/project_show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Toastr CSS for Toast Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Make the project ID available in JS -->
    <script>
        const projectId = {{ $project->id }};
    </script>
</head>
<body>
    
    <!-- Top App Bar -->
    <div class="app-bar">
        <!-- Back Icon -->
        <span class="material-icons-outlined back-icon header-icon"
              onclick="window.history.back();"
              tabindex="0"
              role="button"
              aria-label="Go Back"
              title="Go Back">
            arrow_back
        </span>

        <!-- Title -->
        <h1 class="app-bar-title">{{ $project->name }}</h1>

        <!-- App Bar Actions -->
        <div class="app-bar-actions">
            <!-- Project Members Icon Link -->
            <a href="{{ route('projects.members', ['project' => $project->id]) }}"
               class="user-icon-link header-icon"
               aria-label="Project Members"
               title="Project Members">
                <span class="material-icons-outlined">group</span>
            </a>

            <!-- More Options Dropdown Trigger -->
            <span class="material-icons-outlined dropdown-trigger header-icon"
                  id="dropdown-trigger"
                  role="button"
                  tabindex="0"
                  aria-haspopup="true"
                  aria-expanded="false"
                  title="More Options">
                more_vert
            </span>
        </div>

        <!-- Dropdown Menu -->
        <ul id="project-dropdown" class="dropdown-content" aria-labelledby="dropdown-trigger">
            <li>
                <a href="{{ route('projects.edit', $project->id) }}">
                    <span class="material-icons-outlined">edit</span>
                    Edit Project
                </a>
            </li>
            <li>
                <!-- Instead of an inline confirm, trigger the delete modal -->
                <button type="button" class="dropdown-button w-100 text-start" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <span class="material-icons-outlined">delete</span>
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

        <!-- Smart Sorting Options -->
        <div class="task-sort text-center mb-4">
            <button class="btn btn-sm btn-outline-secondary" id="sort-by-priority" title="Sort by Priority" data-bs-toggle="tooltip" data-bs-placement="top">
                Sort by Priority
            </button>
            <button class="btn btn-sm btn-outline-secondary" id="sort-by-due-date" title="Sort by Due Date" data-bs-toggle="tooltip" data-bs-placement="top">
                Sort by Due Date
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

        <!-- "New Project Task" Button Positioned at the Top -->
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

        <!-- Floating Action Button (Mobile Only) -->
        <div class="fab-container d-block d-md-none">
            <div class="fab" id="fab" aria-label="Add Task" tabindex="0" role="button" title="Add Task">
                <i class="bi bi-plus" aria-hidden="true"></i>
            </div>
            <div class="fab-options" id="fab-options">
                <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createProjectTaskModal" role="button" aria-label="Create New Task" title="Create New Task" data-bs-toggle="tooltip" data-bs-placement="left">
                    <span class="material-icons-outlined">check_circle</span> New Task
                </button>
                <a href="{{ route('projects.create') }}" class="fab-option" role="button" aria-label="Create New Project" title="Create New Project" data-bs-toggle="tooltip" data-bs-placement="left">
                    <span class="material-icons-outlined">folder</span> New Project
                </a>
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
                    <!-- Updated form with a unique ID for AJAX submission -->
                    <form id="create-project-task-form" action="{{ route('projecttasks.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Form Fields -->
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
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <!-- Submit button referencing the updated form ID -->
                    <button type="submit" form="create-project-task-form" class="icon-button" aria-label="Save Task" title="Save Task" data-bs-toggle="tooltip" data-bs-placement="top">
                        <span class="material-icons-outlined">send</span>
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
                    <form id="delete-project-form"
                          action="{{ route('projects.destroy', $project->id) }}"
                          method="POST"
                          style="display:inline;">
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

    <!-- Loading Overlay (optional) -->
    <div class="loading-overlay d-none" id="loading-overlay" aria-hidden="true">
        <div class="loading-spinner"></div>
    </div>

    <!-- JavaScript Files -->
    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Toastr JS for Toast Notifications -->
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
                // If the click is not on the checkbox, navigate
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

        // FAB Button Functionality
        const fab = document.getElementById('fab');
        const fabOptions = document.getElementById('fab-options');

        if (fab) {
            fab.addEventListener('click', function(event) {
                event.preventDefault();
                fabOptions.classList.toggle('show');
                hideAllTooltips();
            });

            fab.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fab.click();
                }
            });

            document.addEventListener('click', function(event) {
                if (!fab.contains(event.target) && !fabOptions.contains(event.target)) {
                    fabOptions.classList.remove('show');
                    hideAllTooltips();
                }
            });
        }

        document.querySelectorAll('.fab-option').forEach(function(option) {
            option.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    option.click();
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

        // Sorting Functionality
        const sortByPriorityBtn = document.getElementById('sort-by-priority');
        const sortByDueDateBtn = document.getElementById('sort-by-due-date');

        function sortTasks(criteria) {
            const visibleTasks = Array.from(document.querySelectorAll('.task-card')).filter(card => card.style.display !== 'none');
            const parent = document.querySelector('.task-cards .row');

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

            visibleTasks.forEach(task => parent.appendChild(task));
            hideAllTooltips();
        }

        sortByPriorityBtn.addEventListener('click', () => {
            sortTasks('priority');
        });

        sortByDueDateBtn.addEventListener('click', () => {
            sortTasks('dueDate');
        });

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
                    // Close the modal
                    const modalElement = document.getElementById('createProjectTaskModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                    // Append new task card to the project tasks row
                    const newTaskHtml = generateProjectTaskCardHtml(data.task);
                    const tasksRow = document.getElementById('project-tasks-row');
                    tasksRow.insertAdjacentHTML('beforeend', newTaskHtml);
                    // Reinitialize tooltips
                    const newTooltips = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    newTooltips.forEach(el => new bootstrap.Tooltip(el, { trigger: 'hover focus' }));
                    // Reattach event listener for the new checkbox
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
            // Determine if task is overdue
            let isOverdue = false;
            if(task.status === 'pending' && task.due_date) {
                const dueDate = new Date(task.due_date);
                const today = new Date();
                today.setHours(0,0,0,0);
                if(dueDate < today) {
                    isOverdue = true;
                }
            }
            const taskUrl = `/projects/${projectId}/tasks/${task.id}`;
            return `
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
                        ${ task.label ? `<span class="label-pill" style="background-color: ${task.label.color};" aria-label="Label: ${task.label.name}">${task.label.name}</span>` : '' }
                    </div>
                </div>
            </div>
            `;
        }

        function attachProjectTaskCheckboxListener() {
            const checkboxes = document.querySelectorAll('.task-card .task-complete-checkbox');
            checkboxes.forEach(checkbox => {
                // Remove existing listeners by replacing the node
                const newCheckbox = checkbox.cloneNode(true);
                checkbox.parentNode.replaceChild(newCheckbox, checkbox);
                newCheckbox.addEventListener('change', function(event) {
                    event.stopPropagation();
                    const checkboxElement = this;
                    const taskId = checkboxElement.getAttribute('data-task-id');
                    const isChecked = checkboxElement.checked;
                    const loadingOverlay = document.getElementById('loading-overlay');
                    loadingOverlay.classList.remove('d-none');
                    const url = `/projects/${projectId}/tasks/${taskId}/status`;
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
                            const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
                            taskCard.setAttribute('data-task-status', isChecked ? 'completed' : 'pending');
                            const cardBodyParagraphs = taskCard.querySelectorAll('.card-body p');
                            const statusParagraph = cardBodyParagraphs[2]; // (0:Due, 1:Priority, 2:Status)
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

        // Attach listeners on initial load
        attachProjectTaskCheckboxListener();
    });
    </script>
</body>
</html>
