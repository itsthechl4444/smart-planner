<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Label</title>
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
        <h1 class="app-bar-title">Create Label</h1>
        <button type="submit" form="create-label-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration2.png') }}" alt="Label Illustration">
        </div>

        <div class="container">
            <form id="create-label-form" action="{{ route('labels.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Label Name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="color" class="form-label">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="#007bff">
                    @error('color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap's tooltips if needed
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</body>
</html>
