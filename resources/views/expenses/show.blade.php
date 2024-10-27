<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Details</title>
    <link rel="stylesheet" href="{{ asset('css/expense_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        /* Optional: Add some styling for the attachment image */
        .expense-attachment img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Expense Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="expense-dropdown" class="dropdown-content">
            <li><a href="{{ route('expenses.edit', $expense->id) }}"><span class="material-symbols-outlined">edit</span>Edit Expense</a></li>
            <li>
                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Expense</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="expense-illustration">
        <div class="expense-details">
            <h2>{{ $expense->name }}</h2>
            <p><strong>Description:</strong> {{ $expense->description }}</p>
            <p><strong>Amount:</strong> {{ $expense->amount }}</p>
            <p><strong>Category:</strong> {{ $expense->category }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</p>
            <p><strong>Currency:</strong> {{ $expense->currency }}</p>
            <p><strong>Payment Method:</strong> {{ $expense->payment_method }}</p>
            <p><strong>Notes:</strong> {{ $expense->notes }}</p>
            @if ($expense->attachment)
                <div class="expense-attachment">
                    <p><strong>Attachment:</strong></p>
                    @php
                        $extension = pathinfo($expense->attachment, PATHINFO_EXTENSION);
                    @endphp
                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                        <img src="{{ asset('storage/' . $expense->attachment) }}" alt="Expense Attachment">
                    @else
                        <a href="{{ asset('storage/' . $expense->attachment) }}" target="_blank">Download Attachment</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#expense-dropdown');

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
