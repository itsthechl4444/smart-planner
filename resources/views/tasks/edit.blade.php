<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Task - {{ $task->title }}</title>
   <!-- Favicon -->
   <link rel="icon" href="/images/LogoPNG.png" type="image/png">

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  <!-- Materialize CSS (Optional for consistency) -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    integrity="sha512-5Mu4X0UL+H7OHM8xKLb7kPP8OH6kGdrAaNFeCz4nywsSBgj3vlpJbIFpJOVHTD9K1PLcIISViU6Ly6q4zsdZzQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
  />

  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />

  <style>
    /* =========================================
       1. Global Styles
    ========================================= */
    body {
      font-family: "Open Sans", sans-serif;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
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
      margin-top: 56px; /* Leave space for fixed app bar */
      padding: 20px;
      text-align: center;
    }
    .illustration {
      margin-bottom: 30px;
    }
    /* Add a gentle floating animation to the illustration image */
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
       4. Form Styles (Matching Edit Label)
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
    <!-- Header title now shows only the task's name -->
    <h1 class="app-bar-title">{{ $task->title }}</h1>
    <button type="submit" form="edit-task-form" class="save-btn">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <!-- Illustration Section -->
    <div class="illustration">
      <img src="{{ asset('images/illustration2.png') }}" alt="Edit Task Illustration">
    </div>

    <div class="container">
      <!-- Success / Error Messages -->
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      <!-- Edit Task Form -->
      <form id="edit-task-form" action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ $task->user_id }}">

        <div class="form-group">
          <input
            type="text"
            class="form-control"
            id="title"
            name="title"
            value="{{ old('title', $task->title) }}"
            placeholder="Task Title"
            required
          >
          @error('title')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <textarea
            class="form-control"
            id="description"
            name="description"
            placeholder="Description"
          >{{ old('description', $task->description) }}</textarea>
          @error('description')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="due_date" class="form-label">Due Date</label>
          <input
            type="date"
            class="form-control"
            id="due_date"
            name="due_date"
            value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
            required
          >
          @error('due_date')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="priority" class="form-label">Priority</label>
          <select class="form-control" id="priority" name="priority" required>
            <option value="High"   {{ old('priority', $task->priority) == 'High'   ? 'selected' : '' }}>High</option>
            <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
            <option value="Low"    {{ old('priority', $task->priority) == 'Low'    ? 'selected' : '' }}>Low</option>
          </select>
          @error('priority')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="label_id" class="form-label">Label</label>
          <select class="form-control" id="label_id" name="label_id">
            <option value="">None</option>
            @foreach($labels as $label)
              <option value="{{ $label->id }}" {{ old('label_id', $task->label_id) == $label->id ? 'selected' : '' }}>
                {{ $label->name }}
              </option>
            @endforeach
          </select>
          @error('label_id')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <textarea
            class="form-control"
            id="notes"
            name="notes"
            placeholder="Notes"
          >{{ old('notes', $task->notes) }}</textarea>
          @error('notes')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Enhanced Attachments UI -->
        <div class="form-group">
          <label for="attachments" class="form-label">Attachments</label>
          <div class="custom-file-input-container">
            <span class="custom-file-label">Choose Files</span>
            <input type="file" class="custom-file-input" id="attachments" name="attachments[]" multiple>
          </div>
          <ul id="attachments-preview" class="attachments-preview"></ul>
          @error('attachments')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          @if (is_array($task->attachments) && count($task->attachments) > 0)
            <div class="mt-2">
              <strong>Existing Attachments:</strong><br>
              @foreach ($task->attachments as $key => $attachment)
                @php
                  $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                  $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                @endphp
                <div class="attachment-item mb-2">
                  @if ($isImage)
                    <img src="{{ asset('storage/' . $attachment) }}" alt="{{ basename($attachment) }}" style="max-width: 100px; max-height: 100px;">
                  @else
                    <a href="{{ asset('storage/' . $attachment) }}" download="{{ basename($attachment) }}">{{ basename($attachment) }}</a>
                  @endif
                  <form action="{{ route('tasks.removeAttachment', [$task->id, $key]) }}" method="POST" style="display:inline; margin-left:10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                  </form>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        <!-- Reminder Checkbox -->
        <div class="form-group form-check">
          <input type="hidden" name="reminder" value="0">
          <input
            type="checkbox"
            class="form-check-input"
            id="reminder"
            name="reminder"
            value="1"
            {{ old('reminder', $task->reminder) ? 'checked' : '' }}
          >
          <label class="form-check-label" for="reminder">Set Reminder</label>
          @error('reminder')
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

      // Enhanced Attachments UI: update label text and list selected file names
      const fileInput = document.getElementById('attachments');
      const customLabel = document.querySelector('.custom-file-label');
      const previewList = document.getElementById('attachments-preview');

      fileInput.addEventListener('change', function() {
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
      });
    });
  </script>
</body>
</html>
