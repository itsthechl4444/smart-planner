<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" id="menu-icon">
            <i class="bi bi-list"></i>
        </div>
        <div class="title">Task Management</div>
    </header>
    
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <!-- Global Search Bar -->
        <div class="global-search">
            <div class="task-search">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="global-search-input" placeholder="Search Tasks, Labels, Projects..." />
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'tasks')">Tasks</button>
            <button class="tab-link" onclick="openTab(event, 'labels')">Labels</button>
            <button class="tab-link" onclick="openTab(event, 'projects')">Projects</button>
        </div>

        <!-- Tasks Section -->
        <div id="tasks" class="tab-content active">
            <!-- Task Cards Container -->
            <div class="task-cards">
                @if (isset($tasks) && $tasks->isEmpty())
                    <!-- No tasks at all -->
                    <div class="nothing-here" id="no-tasks-at-all-message" style="display: flex;">
                        <img src="{{ asset('images/illustration1.png') }}" alt="Nothing here illustration">
                        <p>No tasks at all.</p>
                    </div>
                @elseif(isset($tasks))
                    @foreach($tasks as $task)
                        <div class="card task-card" 
                            data-task-id="{{ $task->id }}"
                            data-task-url="{{ route('tasks.show', $task->id) }}">
                            <div class="card-content">
                                <div class="task-info">
                                    <span class="card-title">{{ $task->title }}</span>
                                    <p>Due Date: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'No due date' }}</p>
                                    <p>Label: {{ $task->label->name ?? 'None' }}</p>
                                    <p>Priority: {{ $task->priority }}</p>
                                    <p>Status: {{ ucfirst($task->status) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- View All Tasks Link -->
            <div class="view-all-link" id="view-all-link">
                <a href="{{ route('tasks.index') }}">View All Tasks</a>
            </div>
        </div>

        <!-- Labels Section -->
        <div id="labels" class="tab-content">
            @if (isset($labels) && $labels->isEmpty())
                <!-- No labels created yet -->
                <div class="nothing-here">
                    <img src="{{ asset('images/illustration2.png') }}" alt="Nothing here illustration">
                    <p>No labels created yet.</p>
                </div>
            @elseif(isset($labels))
                <!-- Label Cards -->
                <div class="label-cards">
                    @foreach($labels as $label)
                        <div class="card label-card" 
                            data-label-id="{{ $label->id }}"
                            data-label-url="{{ route('labels.show', $label->id) }}">
                            <div class="card-content">
                                <span class="card-title">{{ $label->name }}</span>
                                <p>{{ $label->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- View All Labels Link -->
                <div class="view-all-link">
                    <a href="{{ route('labels.index') }}">View All Labels</a>
                </div>
            @endif
        </div>

        <!-- Projects Section -->
        <div id="projects" class="tab-content">
            @if (isset($projects) && $projects->isEmpty())
                <div class="nothing-here">
                    <img src="{{ asset('images/illustration3.png') }}" alt="Nothing here illustration">
                    <p>No projects created yet.</p>
                </div>
            @else
                <div class="project-cards">
                    @foreach($projects as $project)
                        <div class="card project-card" 
                            data-project-id="{{ $project->id }}"
                            data-project-url="{{ route('projects.show', $project->id) }}">
                            <div class="card-content">
                                <span class="card-title">{{ $project->name }}</span>
                                <p>{{ $project->description ?? 'No description' }}</p>
                                <p>Start Date: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'N/A' }}</p>
                                <p>End Date: {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : 'N/A' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="view-all-link">
                    <a href="{{ route('projects.index') }}">View All Projects</a>
                </div>
            @endif
        </div>
    </main>

    <!-- Floating Action Button -->
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
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // FAB button toggle functionality
        document.getElementById('fab').addEventListener('click', () => {
            document.getElementById('fab-options').classList.toggle('show');
        });

        document.querySelectorAll('.fab-option').forEach(option => {
            option.addEventListener('click', () => {
                window.location.href = option.getAttribute('data-action');
            });
        });

        // Task card navigation
        const taskCards = document.querySelectorAll('.task-card');
        taskCards.forEach(card => {
            card.addEventListener('click', () => {
                const taskUrl = card.getAttribute('data-task-url');
                if (taskUrl) {
                    window.location.href = taskUrl;
                } else {
                    console.error('Task URL not found for this card.');
                }
            });
        });

        // Label card navigation
        const labelCards = document.querySelectorAll('.label-card');
        labelCards.forEach(card => {
            card.addEventListener('click', () => {
                const labelUrl = card.getAttribute('data-label-url');
                if (labelUrl) {
                    window.location.href = labelUrl;
                } else {
                    console.error('Label URL not found for this card.');
                }
            });
        });

        // Project card navigation
        const projectCards = document.querySelectorAll('.project-card');
        projectCards.forEach(card => {
            card.addEventListener('click', () => {
                const projectUrl = card.getAttribute('data-project-url');
                if (projectUrl) {
                    window.location.href = projectUrl;
                } else {
                    console.error('Project URL not found for this card.');
                }
            });
        });

        // Initial check for tasks
        const taskCardsLength = document.querySelectorAll('.task-card').length;
        if (taskCardsLength === 0) {
            // No tasks at all
            const noTasksAtAllMessage = document.getElementById('no-tasks-at-all-message');
            if (noTasksAtAllMessage) {
                noTasksAtAllMessage.style.display = 'flex';
            }
            // Hide the "View All Tasks" link
            const viewAllLink = document.getElementById('view-all-link');
            if (viewAllLink) {
                viewAllLink.style.display = 'none';
            }
        }
    });

// Tab functionality
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

    // Handle "No Data" messages when switching tabs
    handleNoDataMessages();
}

// Debounce Function to limit the rate of search execution
function debounce(func, delay) {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
}

// Search Functionality with Debounce
const searchInput = document.getElementById('global-search-input');

searchInput.addEventListener('input', debounce(function() {
    const query = this.value.toLowerCase().trim();

    if (query.length === 0) {
        // If search is cleared, reset all cards to display
        document.querySelectorAll('.task-card, .label-card, .project-card').forEach(card => {
            card.style.display = 'block';
        });
        handleNoDataMessages();
        return;
    }

    // Filter Tasks
    const taskCards = document.querySelectorAll('.task-card');
    taskCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const dueDate = card.querySelector('.task-info p:nth-child(2)').textContent.toLowerCase();
        const label = card.querySelector('.task-info p:nth-child(3)').textContent.toLowerCase();
        const priority = card.querySelector('.task-info p:nth-child(4)').textContent.toLowerCase();
        const status = card.querySelector('.task-info p:nth-child(5)').textContent.toLowerCase();

        if (title.includes(query) || dueDate.includes(query) || label.includes(query) || priority.includes(query) || status.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Filter Labels
    const labelCards = document.querySelectorAll('.label-card');
    labelCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-content p').textContent.toLowerCase();

        if (title.includes(query) || description.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Filter Projects
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-content p').textContent.toLowerCase();
        const startDate = card.querySelector('.card-content p:nth-child(3)').textContent.toLowerCase();
        const endDate = card.querySelector('.card-content p:nth-child(4)').textContent.toLowerCase();

        if (title.includes(query) || description.includes(query) || startDate.includes(query) || endDate.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Handle "No Data" Messages
    handleNoDataMessages();
}, 300)); // 300 milliseconds delay

// Function to handle "No Data" messages based on search results
function handleNoDataMessages() {
    // Tasks
    const visibleTaskCards = document.querySelectorAll('.task-card[style*="display: block"]');
    const noTasksAtAllMessage = document.getElementById('no-tasks-at-all-message');
    if (visibleTaskCards.length === 0) {
        if (document.querySelector('.task-cards').children.length > 0) {
            noTasksAtAllMessage.style.display = 'flex';
        }
        document.getElementById('view-all-link').style.display = 'none';
    } else {
        noTasksAtAllMessage.style.display = 'none';
        document.getElementById('view-all-link').style.display = 'block';
    }

    // Labels
    const visibleLabelCards = document.querySelectorAll('.label-card[style*="display: block"]');
    const noLabelsMessage = document.querySelector('#labels .nothing-here');
    if (visibleLabelCards.length === 0 && document.getElementById('labels').classList.contains('active')) {
        noLabelsMessage.style.display = 'flex';
    } else {
        noLabelsMessage.style.display = 'none';
    }

    // Projects
    const visibleProjectCards = document.querySelectorAll('.project-card[style*="display: block"]');
    const noProjectsMessage = document.querySelector('#projects .nothing-here');
    if (visibleProjectCards.length === 0 && document.getElementById('projects').classList.contains('active')) {
        noProjectsMessage.style.display = 'flex';
    } else {
        noProjectsMessage.style.display = 'none';
    }
}
</script>
</body>
</html>