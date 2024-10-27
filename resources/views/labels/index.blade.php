<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labels Management</title>
    <link rel="stylesheet" href="{{ asset('css/label_index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" id="menu-icon">
                <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
                    arrow_back
                </span>
            </div>
            <div class="title">All Labels</div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Illustration -->
            <div class="illustration-container">
                <img src="{{ asset('images/illustration2.png') }}" alt="Illustration">
            </div>

            <!-- Label Cards -->
            <div class="label-cards">
                @forelse($labels as $label)
                    <div class="card label-card" onclick="location.href='{{ route('labels.show', $label->id) }}'">
                        <div class="card-content">
                            <span class="card-title">{{ $label->name }}</span>
                            <p>{{ $label->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="nothing-here">
                        <img src="{{ asset('images/illustration2.png') }}" alt="No labels illustration">
                        <p>No labels available</p>
                    </div>
                @endforelse
            </div>
        </main>

        <!-- Floating Action Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('labels.create') }}">
                <i class="bi bi-tag"></i> New Label
            </div>
        </div>
    </div>

     <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const fab = document.getElementById('fab');
        const fabOptions = document.getElementById('fab-options');
        
        fab.addEventListener('click', () => {
            fabOptions.classList.toggle('show');
        });

        document.querySelectorAll('.fab-option').forEach(option => {
            option.addEventListener('click', () => {
                window.location.href = option.getAttribute('data-action');
            });
        });
    });
    </script>
</body>
</html>
