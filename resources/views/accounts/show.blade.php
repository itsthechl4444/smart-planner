<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="stylesheet" href="{{ asset('css/account_details.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="container">
    <header class="header">
        <div class="menu-icon">
            <a href="{{ route('financemanagement.index') }}"><i class="material-icons">arrow_back</i></a>
        </div>
        <div class="title">Account Details</div>
        <div style="position: relative;">
            <i class="material-icons dropdown-trigger" id="dropdown-trigger">more_vert</i>
            <ul id="account-dropdown" class="dropdown-content">
                <li><a href="{{ route('accounts.edit', $account->id) }}"><i class="material-icons">edit</i>Edit Account</a></li>
                <li>
                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="material-icons">delete</i>Delete Account</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>
    <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="account-illustration">
    <div class="account-details">
        <h2>{{ $account->name }}</h2>
        <p><strong>Description:</strong> {{ $account->description }}</p>
        <p><strong>Balance:</strong> {{ $account->balance }}</p>
        <p><strong>Currency:</strong> {{ $account->currency }}</p>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownTrigger = document.querySelector('#dropdown-trigger');
        const dropdownMenu = document.querySelector('#account-dropdown');

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
