<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Details</title>
    <link rel="stylesheet" href="{{ asset('css/income_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Income Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="income-dropdown" class="dropdown-content">
            <li><a href="{{ route('incomes.edit', $income->id) }}"><span class="material-symbols-outlined">edit</span>Edit Income</a></li>
            <li>
                <form action="{{ route('incomes.destroy', $income->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Income</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration2.png') }}" alt="Illustration" class="income-illustration">
        <div class="income-details">
            <h2>{{ $income->source_name }}</h2>
            <p><strong>Description:</strong> {{ $income->description }}</p>
            <p><strong>Amount:</strong> ${{ number_format($income->amount, 2) }}</p>
            <p><strong>Date:</strong> {{ $income->date }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#income-dropdown');

            dropdownTrigger.addEventListener('click', function() {
                dropdownMenu.classList.toggle('open');
            });

            document.addEventListener('click', function(event) {
                if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
