<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savings</title>
    <link rel="stylesheet" href="{{ asset('css/savings_index.css') }}">
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
            <div class="title">Savings</div>
        </header>
        <main class="main-content">
            <div class="illustration-container">
                <img src="{{ asset('images/illustration2.png') }}" alt="Savings Illustration">
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
           <!-- Savings Cards Container -->
<div class="savings-cards">
    @forelse ($savings as $saving)
        <a href="{{ route('savings.show', $saving->id) }}" class="card savings-card">
            <div class="card-content">
                <span class="card-title">{{ $saving->name }}</span>
                <p><strong>Description:</strong> {{ $saving->description }}</p>
                <p><strong>Desired Amount:</strong> {{ number_format($saving->desired_amount, 2) }} {{ $saving->currency }}</p>
                <p><strong>Amount Saved:</strong> {{ number_format($saving->total_saved, 2) }} {{ $saving->currency }}</p>
                <p><strong>Desired Date:</strong> 
                    @if($saving->desired_date)
                        {{ \Carbon\Carbon::parse($saving->desired_date)->format('Y-m-d') }}
                    @else
                        Not Set
                    @endif
                </p>
            </div>
        </a>
    @empty
        <div class="nothing-here">
            <img src="{{ asset('images/illustration2.png') }}" alt="Nothing here illustration">
            <p>No savings available</p>
        </div>
    @endforelse
</div>

            </div>
        </main>

        <!-- FAB Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('savings.create') }}">
                <i class="bi bi-wallet"></i> New Saving
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
