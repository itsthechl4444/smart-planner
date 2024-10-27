<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accounts.css') }}">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Edit Account</h1>
        <button type="submit" form="edit-account-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration.png') }}" alt="Account Illustration">
        </div>

        <div class="container">
            <form id="edit-account-form" action="{{ route('accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $account->name }}" placeholder="Account Name" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $account->description }}</textarea>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="balance" name="balance" value="{{ $account->balance }}" step="0.01" placeholder="Balance" required>
                </div>
                <div class="form-group">
                    <select class="form-control" id="currency" name="currency" required>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency }}" {{ $account->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
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
