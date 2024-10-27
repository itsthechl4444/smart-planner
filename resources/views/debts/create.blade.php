<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Debt</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/debt.css') }}">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Create Debt</h1>
        <button type="submit" form="create-debt-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration.png') }}" alt="Debt Illustration">
        </div>

        <div class="container">
            <form id="create-debt-form" action="{{ route('debts.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Debt Name" required>
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
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="{{ old('amount') }}" required>
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="currency" class="form-label">Currency</label>
                    <select class="form-control" id="currency" name="currency" required>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}">{{ $currency }}</option>
                        @endforeach
                    </select>
                    @error('currency')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="borrowed" {{ old('type') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="lent" {{ old('type') == 'lent' ? 'selected' : '' }}>Lent</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
                    @error('due_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group form-check">
                    <input type="hidden" name="reminder" value="0">
                    <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder') ? 'checked' : '' }}>
                    <label class="form-check-label" for="reminder">Set Reminder</label>
                    @error('reminder')
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
