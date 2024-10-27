<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budgets</title>
    <link rel="stylesheet" href="{{ asset('css/budgets_index.css') }}">
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
            <div class="title">Budgets</div>
        </header>
        <main class="main-content">
            <div class="illustration-container">
                <img src="{{ asset('images/illustration2.png') }}" alt="Budgets Illustration">
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="budget-cards">
                @forelse ($budgets as $budget)
                    <a href="{{ route('budgets.show', $budget->id) }}" class="card budget-card">
                        <div class="card-content">
                            <span class="card-title">{{ $budget->name }}</span>
                            <p class="budget-amount">${{ number_format($budget->amount, 2) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="nothing-here">
                        <img src="{{ asset('images/illustration2.png') }}" alt="Nothing here illustration">
                        <p>No budgets available</p>
                    </div>
                @endforelse
            </div>
        </main>

        <!-- FAB Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('budgets.create') }}">
                <i class="bi bi-wallet2"></i> New Budget
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
