<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Debt Details</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Material Symbols Outlined -->
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
    
    /* Top App Bar Styles */
    .app-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 56px;
      padding: 0 20px;
      background-color: #f5f5f5;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 1px solid #ddd;
    }
    
    .app-bar-title {
      flex-grow: 1;
      text-align: center;
      font-size: 20px;
      font-weight: 500;
      color: #555;
      margin: 0;
    }
    
    .back-icon,
    .dropdown-trigger {
      cursor: pointer;
      color: #555;
      font-size: 24px;
    }
    
    /* Dropdown Styles (modeled after Income Details) */
    .dropdown-trigger {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .dropdown-content {
      position: fixed;
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
      justify-content: flex-start;
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
    
    /* Main Content */
    .container {
      width: 90%;
      max-width: 800px;
      margin: 70px auto 20px; /* 70px top margin for fixed header; 20px bottom margin for extra space */
      padding-bottom: 20px;
    }
    
    .debt-illustration {
      width: 100%;
      max-width: 400px;
      height: auto;
      display: block;
      margin: 0 auto 20px;
    }
    
    .debt-details {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
    }
    
    .debt-details h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }
    
    .debt-details p {
      font-size: 16px;
      margin-bottom: 8px;
      color: #555;
    }
    
    .debt-details strong {
      font-weight: bold;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .app-bar-title {
        font-size: 18px;
      }
      .debt-details h2 {
        font-size: 20px;
      }
      .debt-details p {
        font-size: 14px;
      }
    }
    
    @media (max-width: 360px) {
      .app-bar-title {
        font-size: 16px;
      }
      .debt-details h2 {
        font-size: 18px;
      }
      .debt-details p {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="app-bar">
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      chevron_left
    </span>
    <h1 class="app-bar-title">Debt Details</h1>
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
      more_horiz
    </span>
    <ul id="debt-dropdown" class="dropdown-content">
      <li>
        <a href="{{ route('debts.edit', $debt->id) }}">
          <span class="material-symbols-outlined">edit</span> Edit Debt
        </a>
      </li>
      <li>
        <form action="{{ route('debts.destroy', $debt->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit">
            <span class="material-symbols-outlined">delete</span> Delete Debt
          </button>
        </form>
      </li>
    </ul>
  </div>

  <div class="container">
    <img src="{{ asset('images/illustration2.png') }}" alt="Illustration" class="debt-illustration">
    <div class="debt-details">
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

      // Close dropdown if clicking outside
      document.addEventListener('click', function(event) {
        if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.remove('open');
        }
      });
    });
  </script>
</body>
</html>
