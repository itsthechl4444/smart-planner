<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debts</title>
    <link rel="stylesheet" href="{{ asset('css/debts_index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .debt-card {
            cursor: pointer;
        }
        .debt-card:hover {
            background-color: #f5f5f5; /* Optional: Highlight the card on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="menu-icon" id="menu-icon">
                <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
                    arrow_back
                </span>
            </div>
            <div class="title">Debts</div>
        </header>
        <main class="main-content">
            <div class="illustration-container">
                <img src="{{ asset('images/illustration2.png') }}" alt="Debts Illustration">
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="debt-cards">
                @forelse ($debts as $debt)
                    <a href="{{ route('debts.show', $debt->id) }}" class="card debt-card">
                        <div class="card-content">
                            <span class="card-title">{{ $debt->name }}</span>
                            <p>Amount: {{ $debt->amount }}</p>
                            <p>Currency: {{ $debt->currency }}</p>
                            <p>Type: {{ ucfirst($debt->type) }}</p>
                            <p>Due Date: {{ $debt->due_date }}</p>
                        </div>
                    </a>
                @empty
                    <div class="nothing-here">
                        <img src="{{ asset('images/illustration2.png') }}" alt="Nothing here illustration">
                        <p>No debts available</p>
                    </div>
                @endforelse
            </div>
        </main>

        <!-- FAB Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('debts.create') }}">
                <i class="bi bi-wallet"></i> New Debt
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
