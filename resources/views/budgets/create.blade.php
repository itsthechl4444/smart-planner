<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Budget</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/budget.css') }}">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Create Budget</h1>
        <button type="submit" form="create-budget-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration1.png') }}" alt="Budget Illustration">
        </div>

        <div class="container">
            <form id="create-budget-form" action="{{ route('budgets.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Budget Name" required>
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
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="{{ old('amount') }}" placeholder="Amount" required>
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <select class="form-control" id="category" name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <select class="form-control" id="period" name="period" required>
                        <option value="" disabled selected>Select Period</option>
                        @foreach($periods as $value => $label)
                            <option value="{{ $value }}" {{ old('period') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('period')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <select class="form-control" id="currency" name="currency" required>
                        <option value="" disabled selected>Select Currency</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                    @error('currency')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Account dropdown: Optional -->
                <div class="form-group">
                    <select class="form-control" id="account_id" name="account_id">
                        <option value="">None</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="hidden" name="overspending_reminder" value="0">
                    <input type="checkbox" class="form-check-input" id="overspending_reminder" name="overspending_reminder" value="1" {{ old('overspending_reminder') ? 'checked' : '' }}>
                    <label class="form-check-label" for="overspending_reminder">Set Reminder for Overspending</label>
                    @error('overspending_reminder')
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
