<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Project Task</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Custom Project Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/project.css') }}">
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <!-- Top App Bar -->
  <div class="app-bar">
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();" tabindex="0" role="button" aria-label="Go Back" title="Go Back">
      arrow_back
    </span>
    <h1 class="app-bar-title">Edit Project Task</h1>
    <!-- Save Button triggers form submission -->
    <button type="submit" form="edit-task-form" class="save-btn" title="Save Task">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <div class="illustration">
      <img src="{{ asset('images/illustration1.png') }}" alt="Task Illustration">
    </div>

    <div class="container">
      <form id="edit-task-form" action="{{ route('projecttasks.update', ['project' => $project->id, 'task' => $task->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Task Title -->
        <div class="form-group">
          <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" placeholder="Task Title" required>
          @error('title')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Description -->
        <div class="form-group">
          <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description', $task->description) }}</textarea>
          @error('description')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Due Date -->
        <div class="form-group">
          <label for="due_date" class="form-label">Due Date</label>
          <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}" required>
          @error('due_date')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Priority -->
        <div class="form-group">
          <label for="priority" class="form-label">Priority</label>
          <select class="form-control" id="priority" name="priority" required>
            <option value="" disabled>Select Priority</option>
            <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High</option>
            <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
            <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low</option>
          </select>
          @error('priority')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Notes -->
        <div class="form-group">
          <textarea class="form-control" id="notes" name="notes" placeholder="Notes">{{ old('notes', $task->notes) }}</textarea>
          @error('notes')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Attachments -->
        <div class="form-group">
          <label for="attachments" class="form-label">Attachments</label>
          <input type="file" class="form-control" id="attachments" name="attachments">
          @error('attachments')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Reminder -->
        <div class="form-group form-check">
          <input type="hidden" name="reminder" value="0">
          <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder', $task->reminder) ? 'checked' : '' }}>
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
      // Initialize Bootstrap's tooltips if needed
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
</body>
</html>
