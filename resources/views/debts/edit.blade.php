<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Debt - {{ $debt->name }}</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/debt.css') }}" />
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
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
    .save-btn {
      cursor: pointer;
      color: #555;
      font-size: 24px;
      background: none;
      border: none;
      padding: 0;
    }
    /* =========================================
       3. Main Content Styles
    ========================================= */
    main {
      margin-top: 56px; /* Leave space for the app bar */
      padding: 20px;
      text-align: center;
    }
    .illustration {
      margin-bottom: 30px;
    }
    /* Floating animation for illustration */
    @keyframes float {
      0%   { transform: translateY(0); }
      50%  { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }
    .illustration img {
      max-width: 100%;
      height: auto;
      max-height: 300px;
      border-radius: 10px;
      animation: float 3s ease-in-out infinite;
    }
    .container {
      width: 90%;
      max-width: 600px;
      margin: 70px auto 40px; /* Center the container and leave room for the app bar */
    }
    /* =========================================
       4. Enhanced Form Styles
    ========================================= */
    .form-group {
      margin: 20px auto 25px;
      text-align: left;
      width: 100%;
      box-sizing: border-box;
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
    textarea.form-control {
      height: 150px;
      resize: vertical;
    }
    /* =========================================
       5. Responsive Styles
    ========================================= */
    @media (max-width: 1023px) {
      .app-bar {
        height: 56px;
        padding: 0 20px;
      }
      .app-bar-title {
        font-size: 18px;
      }
      main {
        margin-top: 56px;
        padding: 20px;
      }
    }
    @media (max-width: 360px) {
      .app-bar {
        height: 50px;
        padding: 0 15px;
      }
      .app-bar-title {
        font-size: 16px;
      }
      main {
        margin-top: 50px;
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <!-- Top App Bar -->
  <div class="app-bar">
    <!-- Back icon changed to chevron_left -->
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      chevron_left
    </span>
    <!-- Header title displays the debt's name -->
    <h1 class="app-bar-title">{{ $debt->name }}</h1>
    <button type="submit" form="edit-debt-form" class="save-btn">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <!-- Animated Illustration Section -->
    <div class="illustration">
      <img src="{{ asset('images/illustration.png') }}" alt="Debt Illustration">
    </div>

    <div class="container">
      <form id="edit-debt-form" action="{{ route('debts.update', $debt->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Debt Name -->
        <div class="form-group">
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $debt->name) }}" placeholder="Debt Name" required>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Description -->
        <div class="form-group">
          <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description', $debt->description) }}</textarea>
          @error('description')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Amount -->
        <div class="form-group">
          <label for="amount" class="form-label">Amount</label>
          <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="{{ old('amount', $debt->amount) }}" required>
          @error('amount')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Currency -->
        <div class="form-group">
          <label for="currency" class="form-label">Currency</label>
          <select class="form-control" id="currency" name="currency" required>
            @foreach ($currencies as $currency)
              <option value="{{ $currency }}" {{ old('currency', $debt->currency) == $currency ? 'selected' : '' }}>{{ $currency }}</option>
            @endforeach
          </select>
          @error('currency')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Type -->
        <div class="form-group">
          <label for="type" class="form-label">Type</label>
          <select class="form-control" id="type" name="type" required>
            <option value="borrowed" {{ old('type', $debt->type) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
            <option value="lent" {{ old('type', $debt->type) == 'lent' ? 'selected' : '' }}>Lent</option>
          </select>
          @error('type')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Due Date -->
        <div class="form-group">
          <label for="due_date" class="form-label">Due Date</label>
          <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $debt->due_date) }}">
          @error('due_date')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Reminder -->
        <div class="form-group form-check">
          <input type="hidden" name="reminder" value="0">
          <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder', $debt->reminder) ? 'checked' : '' }}>
          <label class="form-check-label" for="reminder">Set Reminder</label>
          @error('reminder')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </form>
    </div>
  </main>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Bootstrap tooltips if needed
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
</body>
</html>
