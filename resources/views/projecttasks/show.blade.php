<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Task Details</title>
    <link rel="stylesheet" href="{{ asset('css/task_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Project Task Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="task-dropdown" class="dropdown-content">
            <!-- Corrected Route References -->
            <li>
                <a href="{{ route('projecttasks.edit', ['project' => $project->id, 'task' => $task->id]) }}">
                    <span class="material-symbols-outlined">edit</span>Edit Task
                </a>
            </li>
            <li>
                <form action="{{ route('projecttasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Task</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="task-illustration">
        <div class="task-details">
            <h2>{{ $task->title }}</h2>
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
            <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
            <p><strong>Label:</strong> {{ $task->label ? $task->label->name : 'None' }}</p>
            <p><strong>Notes:</strong> {{ $task->notes }}</p>
            <p><strong>Reminder:</strong> {{ $task->reminder ? 'Yes' : 'No' }}</p>
            @if ($task->attachments)
                <p><strong>Attachments:</strong> <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">View Attachment</a></p>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#task-dropdown');

            // Toggle dropdown menu visibility
            dropdownTrigger.addEventListener('click', function() {
                dropdownMenu.classList.toggle('open');
            });

            // Close dropdown menu if clicked outside
            document.addEventListener('click', function(event) {
                if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
