<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Saving</title>
    <link rel="stylesheet" href="{{ asset('css/saving_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
</head>

<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Saving Details</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
        <ul id="saving-dropdown" class="dropdown-content">
            <li><a href="{{ route('savings.edit', $saving->id) }}"><span class="material-symbols-outlined">edit</span>Edit Saving</a></li>
            <li>
                <form action="{{ route('savings.destroy', $saving->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this saving?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Saving</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container">
        <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="saving-illustration">

       <!-- Saving Details -->
<div class="saving-details">
    <h2>{{ $saving->name }}</h2>
    <p><strong>Description:</strong> {{ $saving->description }}</p>
    <p><strong>Desired Amount:</strong> {{ number_format($saving->desired_amount, 2) }} {{ $saving->currency }}</p>
    <p><strong>Amount Saved:</strong> {{ number_format($totalSaved, 2) }} {{ $saving->currency }}</p>
    <p><strong>Remaining Amount:</strong> {{ number_format($remainingAmount, 2) }} {{ $saving->currency }}</p>
    <p><strong>Desired Date:</strong> 
        @if($saving->desired_date)
            {{ \Carbon\Carbon::parse($saving->desired_date)->format('Y-m-d') }}
        @else
            Not Set
        @endif
    </p>
    <p><strong>Notes:</strong> {{ $saving->notes }}</p>
    @if ($saving->attachment)
        <p><strong>Attachment:</strong> <a href="{{ asset('storage/' . $saving->attachment) }}" target="_blank">{{ basename($saving->attachment) }}</a></p>
    @else
        <p>No attachment uploaded.</p>
    @endif
</div>


    <hr class="divider"> 

  <!-- Total Saved Amount and Remaining Amount -->
<div class="total-container">
    <h4>Total Saved Amount: ${{ number_format($totalSaved, 2) }}</h4>
    <h4>Remaining Amount: ${{ number_format($remainingAmount, 2) }}</h4>
</div>

<!-- Save Amount Section -->
<div class="save-amount-section mt-4">
    <h5>Save Amount</h5>
    <form action="{{ route('savings.addAmount', $saving->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount" class="form-label">Amount to Save</label>
            <input type="number" class="form-control" id="amount" name="amount" required min="1" placeholder="Enter amount">
        </div>
        <div class="text-center mt-3"> <!-- Centering the button -->
            <button type="submit" class="btn btn-gray">Save Amount</button>
        </div>
    </form>
</div>





   <!-- Bootstrap Bundle with Popper -->
   <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#saving-dropdown');

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
