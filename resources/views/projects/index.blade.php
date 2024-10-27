<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project_index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <header class="header">
            <div class="menu-icon" id="menu-icon">
                <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
                    arrow_back
                </span>
            </div>
            <div class="title">All Projects</div>
        </header>

        <!-- Main Content Section -->
        <main class="main-content">
            <div class="illustration-container">
                <img src="{{ asset('images/illustration1.png') }}" alt="Illustration">
            </div>

            <!-- Project Cards Container -->
            <div class="project-cards">
                <!-- Loop through projects and display as cards -->
                @foreach($projects as $project)
                <div class="project-card card" data-url="{{ route('projects.show', $project) }}">
                    <div class="card-content">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </main>

        <!-- FAB Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>

        <!-- FAB Options -->
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('projects.create') }}">
                <i class="bi bi-folder-plus"></i> New Project
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- JavaScript for FAB and Card Clicks -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // FAB Toggle
            const fab = document.getElementById('fab');
            const fabOptions = document.getElementById('fab-options');

            fab.addEventListener('click', () => {
                fabOptions.classList.toggle('show');
            });

            // Project card click handler
            const projectCards = document.querySelectorAll('.project-card');
            projectCards.forEach(card => {
                card.addEventListener('click', () => {
                    const url = card.getAttribute('data-url');
                    window.location.href = url;
                });
            });

            // FAB options click handler
            document.querySelectorAll('.fab-option').forEach(option => {
                option.addEventListener('click', () => {
                    window.location.href = option.getAttribute('data-action');
                });
            });
        });
    </script>
</body>

</html>
