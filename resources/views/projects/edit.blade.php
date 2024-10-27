<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Edit Project</h1>
        <button type="submit" form="edit-project-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration1.png') }}" alt="Project Illustration">
        </div>

        <form id="edit-project-form" action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Project Name" value="{{ $project->name }}" required>
            </div>
            
            <div class="form-group">
                <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $project->description }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $project->start_date }}" required>
            </div>
            
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $project->end_date }}" required>
            </div>
        </form>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
