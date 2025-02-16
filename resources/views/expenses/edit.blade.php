<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Expense - {{ $expense->name }}</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/project.css') }}" />
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
      margin: 70px auto 40px; /* Center container and leave room for app bar */
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
       5. Enhanced Attachments UI
    ========================================= */
    .custom-file-input-container {
      position: relative;
      display: inline-block;
      margin-top: 5px;
    }
    .custom-file-label {
      display: inline-block;
      padding: 10px 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      color: #555;
      cursor: pointer;
    }
    .custom-file-input {
      opacity: 0;
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }
    .attachments-preview {
      margin-top: 10px;
      list-style: none;
      padding: 0;
    }
    .attachments-preview li {
      padding: 5px 0;
      font-size: 14px;
      color: #555;
    }
    /* =========================================
       6. Responsive Styles
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
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      chevron_left
    </span>
    <!-- Header title displays the expense's name -->
    <h1 class="app-bar-title">{{ $expense->name }}</h1>
    <button type="submit" form="edit-expense-form" class="save-btn">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <!-- Animated Illustration Section -->
    <div class="illustration">
      <img src="{{ asset('images/illustration.png') }}" alt="Expense Illustration">
    </div>

    <div class="container">
      <!-- Edit Expense Form -->
      <form id="edit-expense-form" action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Expense Name -->
        <div class="form-group">
          <input type="text" class="form-control" id="name" name="name" placeholder="Expense Name" value="{{ old('name', $expense->name) }}" required>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Description -->
        <div class="form-group">
          <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description', $expense->description) }}</textarea>
          @error('description')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Amount -->
        <div class="form-group">
          <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" value="{{ old('amount', $expense->amount) }}" step="0.01" required>
          @error('amount')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Category -->
        <div class="form-group">
          <label for="category" class="form-label">Category</label>
          <select class="form-control" id="category" name="category" required>
            @foreach ($categories as $category)
              <option value="{{ $category }}" {{ old('category', $expense->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
          </select>
          @error('category')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Date -->
        <div class="form-group">
          <label for="date" class="form-label">Date</label>
          <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $expense->date) }}" required>
          @error('date')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Currency -->
        <div class="form-group">
          <label for="currency" class="form-label">Currency</label>
          <select class="form-control" id="currency" name="currency" required>
            @foreach ($currencies as $currency)
              <option value="{{ $currency }}" {{ old('currency', $expense->currency) == $currency ? 'selected' : '' }}>{{ $currency }}</option>
            @endforeach
          </select>
          @error('currency')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Payment Method -->
        <div class="form-group">
          <label for="payment_method" class="form-label">Payment Method</label>
          <select class="form-control" id="payment_method" name="payment_method" required>
            @foreach ($paymentMethods as $paymentMethod)
              <option value="{{ $paymentMethod }}" {{ old('payment_method', $expense->payment_method) == $paymentMethod ? 'selected' : '' }}>{{ $paymentMethod }}</option>
            @endforeach
          </select>
          @error('payment_method')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Notes -->
        <div class="form-group">
          <textarea class="form-control" id="notes" name="notes" placeholder="Notes">{{ old('notes', $expense->notes) }}</textarea>
          @error('notes')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- Enhanced Attachments UI -->
        <div class="form-group">
          <label for="attachment" class="form-label">Attachment</label>
          @if ($expense->attachment)
            <div class="current-attachment" style="margin-bottom: 10px;">
              <p><strong>Current Attachment:</strong></p>
              @php
                $extension = pathinfo($expense->attachment, PATHINFO_EXTENSION);
              @endphp
              @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                <img src="{{ asset('storage/' . $expense->attachment) }}" alt="Current Attachment" style="max-width: 100%; height: auto;">
              @else
                <a href="{{ asset('storage/' . $expense->attachment) }}" target="_blank" class="current-attachment-link">{{ basename($expense->attachment) }}</a>
              @endif
            </div>
          @endif
          <div class="custom-file-input-container">
            <span class="custom-file-label">Choose Files</span>
            <input type="file" class="custom-file-input" id="attachment" name="attachment" accept="image/*,application/pdf">
          </div>
          <ul id="attachments-preview" class="attachments-preview"></ul>
          @error('attachment')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <img id="attachment-preview" src="#" alt="Attachment Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
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

      // Enhanced Attachments UI: update label text and list selected file names
      const fileInput = document.getElementById('attachment');
      const customLabel = document.querySelector('.custom-file-label');
      const previewList = document.getElementById('attachments-preview');
      const attachmentPreview = document.getElementById('attachment-preview');

      fileInput.addEventListener('change', function() {
        // Update label text based on number of files (for single file, show file name)
        if (fileInput.files.length > 0) {
          customLabel.textContent = fileInput.files.length + ' file(s) selected';
        } else {
          customLabel.textContent = 'Choose Files';
        }
        // Clear previous preview list and add selected file names
        previewList.innerHTML = '';
        Array.from(fileInput.files).forEach(file => {
          const li = document.createElement('li');
          li.textContent = file.name;
          previewList.appendChild(li);
        });
        // For image files, show a preview
        const file = fileInput.files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            attachmentPreview.src = e.target.result;
            attachmentPreview.style.display = 'block';
          }
          reader.readAsDataURL(file);
        } else {
          attachmentPreview.src = '#';
          attachmentPreview.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>
