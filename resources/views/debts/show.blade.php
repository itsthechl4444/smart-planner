<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debt Details</title>
    <link rel="stylesheet" href="{{ asset('css/debt_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Debt Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="debt-dropdown" class="dropdown-content">
            <li><a href="{{ route('debts.edit', $debt->id) }}"><span class="material-symbols-outlined">edit</span>Edit Debt</a></li>
            <li>
                <form action="{{ route('debts.destroy', $debt->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Debt</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration2.png') }}" alt="Illustration" class="debt-illustration">
        <div class="debt-details">
            <!-- Display user-specific debt details -->
            <h2>{{ $debt->name }}</h2>
            <p><strong>Description:</strong> {{ $debt->description }}</p>
            <p><strong>Amount:</strong> ${{ number_format($debt->amount, 2) }}</p>
            <p><strong>Currency:</strong> {{ $debt->currency }}</p>
            <p><strong>Type:</strong> {{ ucfirst($debt->type) }}</p>
            <p><strong>Due Date:</strong> {{ $debt->due_date }}</p>
            <p><strong>Reminder:</strong> {{ $debt->reminder ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#debt-dropdown');

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
