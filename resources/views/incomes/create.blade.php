<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income</title>
    <link rel="stylesheet" href="{{ asset('css/income.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Add Income</h1>
        <button type="submit" form="add-income-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration.png') }}" alt="Income Illustration">
        </div>

        <div class="container">
            <form id="add-income-form" action="{{ route('incomes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="source_name" name="source_name" value="{{ old('source_name') }}" placeholder="Source Name" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Amount" step="0.01" required>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
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
