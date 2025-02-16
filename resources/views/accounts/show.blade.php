<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <!-- Load Material Symbols Outlined for icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #f5f5f5;
            color: #808080;
            margin: 0;
            box-sizing: border-box;
        }

        /* Header Styles */
        .header {
            display: flex;
      align-items: center;
      justify-content: space-between;
      height: 56px;
      padding: 0 20px;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 1px solid #ddd;
        }

        .menu-icon a {
            text-decoration: none;
            color: #555;
        }

        .menu-icon .material-symbols-outlined {
            font-size: 24px;
            cursor: pointer;
        }

        .title {
            flex-grow: 1;
      text-align: center;
      font-size: 20px;
      font-weight: 500;
      color: #555;
      margin: 0;
        }

        .dropdown-trigger {
            font-size: 24px;
            cursor: pointer;
            color: #555;
            position: relative;
        }

        /* Dropdown Styles (Copied from Task Show) */
        .dropdown-content {
            position: absolute;
            top: 56px;
            right: 20px;
            display: none;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            z-index: 1001;
            border: 1px solid #ddd;
            border-radius: 10px;
            min-width: 150px;
            overflow: hidden;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-content.open {
            display: block;
        }

        .dropdown-content li {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            cursor: pointer;
            white-space: nowrap;
            font-size: 14px;
        }

        .dropdown-content li + li {
            border-top: 1px solid #ddd;
        }

        .dropdown-content li a,
        .dropdown-content li form button {
            color: #555;
            display: flex;
            align-items: center;
            text-decoration: none;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }

        .dropdown-content li a span,
        .dropdown-content li form button span {
            margin-right: 6px;
            font-size: 20px;
        }

        .dropdown-content li:hover {
            background-color: #f0f0f0;
        }

        .dropdown-content form {
            margin: 0;
        }

        .dropdown-content form button {
            padding: 10px 20px;
        }

        .dropdown-content form button:hover {
            background-color: #f0f0f0;
        }
        .dropdown-content {
      position: absolute;
      top: 30px;
      right: 10px;
      display: none;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      z-index: 9999;
      border: 1px solid #ddd;
      border-radius: 10px;
      min-width: 150px;
      overflow: hidden;
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .dropdown-content.open {
      display: block;
    }

    /* Same left and right padding, minimal whitespace */
    .dropdown-content li {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      cursor: pointer;
      white-space: nowrap;
      font-size: 14px;
    }
    /* Light divider between items */
    .dropdown-content li + li {
      border-top: 1px solid #ddd;
    }

    /* No extra horizontal padding in link/button; 
       the <li> handles the main spacing. */
    .dropdown-content li a,
    .dropdown-content li form button {
      color: #555;
      display: flex;
      align-items: center;
      text-decoration: none;
      width: 100%;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
      padding: 0;
    }
    /* Icon margin for clarity */
    .dropdown-content li span.material-symbols-outlined {
      margin-right: 6px;
      font-size: 20px;
    }

    .dropdown-content li:hover {
      background-color: #f0f0f0;
    }
    .dropdown-content form {
      margin: 0;
    }

        /* Main Content */
        .container {
            width: 90%;
            max-width: 800px;
            margin: 70px auto 20px; /* 70px top margin to leave space for fixed header, 20px bottom margin for extra space */
            padding-bottom: 20px;
        }

        .account-illustration {
            width: 100%;
            max-width: 400px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .account-details {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .account-details h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .account-details p {
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .account-details strong {
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .title {
                font-size: 18px;
            }

            .account-details h2 {
                font-size: 20px;
            }

            .account-details p {
                font-size: 14px;
            }
        }

        @media (max-width: 360px) {
            .title {
                font-size: 16px;
            }

            .account-details h2 {
                font-size: 18px;
            }

            .account-details p {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="menu-icon">
                <a href="{{ route('financemanagement.index') }}">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            </div>
            <div class="title">Account Details</div>
            <div style="position: relative;">
                <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">more_horiz</span>
                <ul id="account-dropdown" class="dropdown-content">
                    <li>
                        <a href="{{ route('accounts.edit', $account->id) }}">
                            <span class="material-symbols-outlined">edit</span> Edit Account
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <span class="material-symbols-outlined">delete</span> Delete Account
                            </button>
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
