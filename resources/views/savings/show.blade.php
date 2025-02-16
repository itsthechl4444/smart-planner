<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show Saving</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Material Symbols Outlined -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
  
  <style>
    /* =========================================
       1. Global Styles
    ========================================= */
    body {
      font-family: "Open Sans", sans-serif;
      background-color: #f5f5f5;
      color: #808080;
      margin: 0;
      box-sizing: border-box;
    }

    /* =========================================
       2. Top App Bar Styles
    ========================================= */
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

    /* =========================================
       3. Dropdown Styles (Based on Income Details)
    ========================================= */
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
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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

    /* =========================================
       4. Main Content
    ========================================= */
    .container {
      width: 90%;
      max-width: 800px;
      margin: 70px auto 20px; /* Top margin for fixed header; 20px bottom margin for extra space */
      padding-bottom: 20px;  /* Extra bottom padding */
    }
    .saving-illustration {
      width: 100%;
      max-width: 400px;
      height: auto;
      display: block;
      margin: 0 auto 20px;
    }
    .saving-details {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 20px;
      margin-top: 20px;
      margin-bottom: 20px;
    }
    .saving-details h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }
    .saving-details p {
      font-size: 16px;
      margin-bottom: 8px;
      color: #555;
    }
    .saving-details strong {
      font-weight: bold;
    }
    .saving-attachment img {
      max-width: 100%;
      height: auto;
      margin-top: 10px;
    }
    .divider {
      margin: 20px 0;
    }
    /* Improved Total Container: White background, border, and refined box-shadow */
    .total-container {
      margin: 20px;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .save-amount-section {
      margin-top: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .save-amount-section h5 {
      margin-bottom: 20px;
    }
    .save-amount-section button {
      display: block;
      margin: 0 auto;
    }

    /* =========================================
       5. Form Styles
    ========================================= */
    .form-group {
      margin-top: 20px;
      margin-bottom: 25px;
      text-align: left;
      width: 100%;
      max-width: 500px;
      box-sizing: border-box;
      margin-left: auto;
      margin-right: auto;
    }
    .form-control {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      height: 50px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      font-family: "Open Sans", sans-serif;
      color: #555;
      margin-top: 5px;
    }
    .form-label {
      display: block;
      font-size: 14px;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }
    .form-control::placeholder {
      color: #808080;
      opacity: 1;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
    }
    .btn-gray {
      background-color: #808080;
      border: none;
      border-radius: 5px;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .btn-gray:hover {
      background-color: #6c757d;
    }

    /* =========================================
       6. Responsive Design
    ========================================= */
    @media (max-width: 768px) {
      .app-bar-title {
        font-size: 18px;
      }
      .saving-details h2 {
        font-size: 20px;
      }
      .saving-details p {
        font-size: 14px;
      }
    }
    @media (max-width: 360px) {
      .app-bar-title {
        font-size: 16px;
      }
      .saving-details h2 {
        font-size: 18px;
      }
      .saving-details p {
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
    <h1 class="app-bar-title">Saving Details</h1>
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
      more_horiz
    </span>
    <ul id="saving-dropdown" class="dropdown-content">
      <li>
        <a href="{{ route('savings.edit', $saving->id) }}">
          <span class="material-symbols-outlined">edit</span> Edit Saving
        </a>
      </li>
      <li>
        <form action="{{ route('savings.destroy', $saving->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this saving?');">
          @csrf
          @method('DELETE')
          <button type="submit">
            <span class="material-symbols-outlined">delete</span> Delete Saving
          </button>
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
      <p>
        <strong>Desired Amount:</strong>
        {{ number_format($saving->desired_amount, 2) }} {{ $saving->currency }}
      </p>
      <p>
        <strong>Amount Saved:</strong>
        {{ number_format($totalSaved, 2) }} {{ $saving->currency }}
      </p>
      <p>
        <strong>Remaining Amount:</strong>
        {{ number_format(max(0, $remainingAmount), 2) }} {{ $saving->currency }}
      </p>
      <p>
        <strong>Desired Date:</strong>
        @if($saving->desired_date)
          {{ \Carbon\Carbon::parse($saving->desired_date)->format('Y-m-d') }}
        @else
          Not Set
        @endif
      </p>
      <p><strong>Notes:</strong> {{ $saving->notes }}</p>
      @if ($saving->attachment)
        <div class="saving-attachment">
          <p><strong>Attachment:</strong></p>
          @php
            $extension = pathinfo($saving->attachment, PATHINFO_EXTENSION);
          @endphp
          @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
            <img src="{{ asset('storage/' . $saving->attachment) }}" alt="Saving Attachment">
          @else
            <a href="{{ asset('storage/' . $saving->attachment) }}" target="_blank">Download Attachment</a>
          @endif
        </div>
      @else
        <p>No attachment uploaded.</p>
      @endif
    </div>

    <hr class="divider">

    <!-- Total Saved Amount and Remaining Amount Container -->
    <div class="total-container">
      <h4>Total Saved Amount: ${{ number_format($totalSaved, 2) }}</h4>
      <h4>Remaining Amount: ${{ number_format(max(0, $remainingAmount), 2) }}</h4>
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
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-gray">Save Amount</button>
        </div>
      </form>
    </div>
  </div>

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
