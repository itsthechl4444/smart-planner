<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/project_show.css') }}">
    <!-- Icons and Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS (Ensure Bootstrap is included) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    
  <!-- Top App Bar -->
<div class="app-bar">
    <!-- Back Icon -->
    <span class="material-symbols-outlined back-icon header-icon" onclick="window.history.back();">
        arrow_back
    </span>

    <!-- Title -->
    <h1 class="app-bar-title">{{ $project->name }}</h1>

    <!-- App Bar Actions -->
    <div class="app-bar-actions">
        <!-- User Icon Link -->
        <a href="{{ route('projects.members', ['project' => $project->id]) }}" class="user-icon-link header-icon" aria-label="Project Members">
            <span class="material-symbols-outlined">group</span>
        </a>

        <!-- More Vert Icon as Button -->
        <span class="material-symbols-outlined dropdown-trigger header-icon" id="dropdown-trigger" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
            more_vert
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
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-button">
                    <span class="material-symbols-outlined">delete</span>
                    Delete Project
                </button>
            </form>
        </li>
    </ul>
</div> 


    <!-- Main Content -->
    <main>
        <!-- Accepted Collaborators Section -->
        <section class="collaborators-section">
            <h3>Accepted Collaborators</h3>
            <ul>
                @forelse($project->acceptedCollaborators as $collaborator)
                    <li>{{ $collaborator->name }} ({{ $collaborator->email }})</li>
                @empty
                    <li>No collaborators have accepted the invitation yet.</li>
                @endforelse
            </ul>
        </section>

        <!-- Project Tasks Section -->
        @if($project->tasks->isEmpty())
            <div class="empty-state">
                <img src="{{ asset('images/illustration.png') }}" alt="No Tasks Illustration">
                <p>No tasks yet</p>
            </div>
        @else
            <div class="task-cards container mt-4">
                <div class="row">
                    @foreach($project->tasks as $task)
                        <div class="col-md-4 mb-4">
                            <div class="card task-card" data-url="{{ route('projecttasks.show', [$project->id, $task->id]) }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'No due date' }}</p>
                                    <p class="card-text"><strong>Label:</strong> {{ $task->label->name ?? 'None' }}</p>
                                    <p class="card-text"><strong>Priority:</strong> {{ $task->priority }}</p>
                                    <a href="{{ route('projecttasks.show', [$project->id, $task->id]) }}" class="btn btn-primary">View Task</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


<!-- Floating Action Button -->
<div class="fab" id="fab" aria-label="Add Task">
    <i class="bi bi-plus"></i>
</div>
<div class="fab-options" id="fab-options">
    <a href="{{ route('projecttasks.create', $project->id) }}" class="fab-option" aria-label="Create New Task">
        <i class="bi bi-check-circle"></i> New Task
    </a>
    <!-- Add more options here if needed -->
</div>



    <!-- JavaScript Files -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown Menu for Project Actions
        const dropdownTrigger = document.querySelector('#dropdown-trigger');
        const dropdownMenu = document.querySelector('#project-dropdown');

        // Task Cards Navigation
        const taskCards = document.querySelectorAll('.task-card');
        taskCards.forEach(function(card) {
            card.addEventListener('click', function() {
                const url = card.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                } else {
                    console.error('No URL found for this task card.');
                }
            });
        });

        // Toggle Dropdown Menu Visibility
        dropdownTrigger.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('open');
        });

        // Close Dropdown Menu If Clicked Outside
        document.addEventListener('click', function(event) {
            if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('open');
            }
        });

        // FAB Button Functionality
        const fab = document.getElementById('fab');
        const fabOptions = document.getElementById('fab-options');

        // Toggle FAB Options Visibility
        fab.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default anchor behavior
            fabOptions.classList.toggle('show');
        });

        // Close FAB Options If Clicked Outside
        document.addEventListener('click', function(event) {
            if (!fab.contains(event.target) && !fabOptions.contains(event.target)) {
                fabOptions.classList.remove('show');
            }
        });
    });
</script>

</body>
</html>
