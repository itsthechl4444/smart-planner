<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Label - {{ $label->name }}</title>
   <!-- Favicon -->
   <link rel="icon" href="/images/LogoPNG.png" type="image/png">
  
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />

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
      margin-top: 56px;
      padding: 20px;
      text-align: center;
    }
    .illustration {
      margin-bottom: 30px;
    }
    .illustration img {
      max-width: 100%;
      height: auto;
      max-height: 300px;
      border-radius: 10px;
    }
    .container {
      width: 90%;
      max-width: 600px;
      margin: 70px auto 40px; /* Ensure content does not overlap the app bar */
    }
    /* =========================================
       4. Form Styles
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
    @media (max-width: 768px) {
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
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      arrow_back
    </span>
    <!-- Header title shows only the label's name -->
    <h1 class="app-bar-title">{{ $label->name }}</h1>
    <button type="submit" form="edit-label-form" class="save-btn">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <!-- Illustration Section -->
    <div class="illustration">
      <img src="{{ asset('images/illustration2.png') }}" alt="Label Illustration">
    </div>

    <div class="container">
      <!-- The form action now includes a query parameter to redirect to the task management labels section -->
      <form id="edit-label-form" action="{{ route('labels.update', $label->id) }}?redirect=taskmanagement" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <input type="text" class="form-control" id="name" name="name" value="{{ $label->name }}" placeholder="Label Name" required>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $label->description }}</textarea>
          @error('description')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="color" class="form-label">Color</label>
          <input type="color" class="form-control" id="color" name="color" value="{{ $label->color }}">
          @error('color')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </form>
    </div>
  </main>

  <!-- Bootstrap 5 JS -->
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
