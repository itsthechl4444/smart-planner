<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Details</title>
    <link rel="stylesheet" href="{{ asset('css/budget_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Budget Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="budget-dropdown" class="dropdown-content">
            <li><a href="{{ route('budgets.edit', $budget->id) }}"><span class="material-symbols-outlined">edit</span>Edit Budget</a></li>
            <li>
                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Budget</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="budget-illustration">
        <div class="budget-details">
            <h2>{{ $budget->name }}</h2>
            <p><strong>Description:</strong> {{ $budget->description }}</p>
            <p><strong>Amount:</strong> {{ $budget->amount }}</p>
            <p><strong>Category:</strong> {{ $budget->category }}</p>
            <p><strong>Date:</strong> {{ $budget->date }}</p>
            <p><strong>Period:</strong> {{ $budget->period }}</p>
            <p><strong>Currency:</strong> {{ $budget->currency }}</p>
            <p><strong>Account:</strong> {{ $budget->account->name ?? 'N/A' }}</p>
            <p><strong>Reminder for Overspending:</strong> {{ $budget->overspending_reminder ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#budget-dropdown');

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
