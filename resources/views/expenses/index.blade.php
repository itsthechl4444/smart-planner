<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="stylesheet" href="{{ asset('css/expenses_index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="menu-icon" id="menu-icon">
                <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
                    arrow_back
                </span>
            </div>
            <div class="title">Expenses</div>
        </header>
        <main class="main-content">
            <div class="illustration-container">
                <img src="{{ asset('images/illustration3.png') }}" alt="Expenses Illustration">
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="expense-cards">
                @forelse ($expenses as $expense)
                    <div class="card expense-card" onclick="window.location.href='{{ route('expenses.show', $expense->id) }}'">
                        <div class="card-content">
                            <span class="card-title">{{ $expense->name }}</span>
                            <p>{{ $expense->category }}</p>
                            <p>Amount: {{ $expense->amount }}</p>
                            <p>Date: {{ $expense->date }}</p>
                        </div>
                    </div>
                @empty
                    <div class="nothing-here">
                        <img src="{{ asset('images/illustration3.png') }}" alt="Nothing here illustration">
                        <p>No expenses available</p>
                    </div>
                @endforelse
            </div>
        </main>
        <!-- FAB Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('expenses.create') }}">
                <i class="bi bi-wallet"></i> New Expense
            </div>
        </div>
    </div>
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
