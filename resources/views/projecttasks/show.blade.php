<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $task->title }}</title>
   <!-- Favicon -->
   <link rel="icon" href="/images/LogoPNG.png" type="image/png">
  <!-- Task Details CSS (for page-specific styles) -->
  <link rel="stylesheet" href="{{ asset('css/task_details.css') }}">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Label Details CSS (for header styles) -->
  <link rel="stylesheet" href="{{ asset('css/label_details.css') }}">
  <!-- Materialize CSS (for dropdown styling) -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    integrity="sha512-5Mu4X0UL+H7OHM8xKLb7kPP8OH6kGdrAaNFeCz4nywsSBgj3vlpJbIFpJOVHTD9K1PLcIISViU6Ly6q4zsdZzQ=="
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
  />
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="app-bar">
    <!-- Back icon (chevron_left) -->
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      chevron_left
    </span>

    <!-- Header Title: Displaying the Task Title -->
    <h1 class="app-bar-title">{{ $task->title }}</h1>

    <!-- "more_horiz" icon for Dropdown -->
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
      more_horiz
    </span>
      
    <!-- Dropdown Menu (copied from Label show page with adjusted routes/text) -->
    <ul id="task-dropdown" class="dropdown-content">
      <li>
        <a href="{{ route('projecttasks.edit', ['project' => $project->id, 'task' => $task->id]) }}">
          <span class="material-symbols-outlined">edit</span> Edit Task
        </a>
      </li>
      <li>
        <form action="{{ route('projecttasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit">
            <span class="material-symbols-outlined">delete</span> Delete Task
          </button>
        </form>
      </li>
    </ul>
  </div>

  <div class="container">
    <img src="{{ asset('images/illustration1.png') }}" alt="Task Illustration" class="task-illustration">
    <div class="task-details">
      <h2>{{ $task->title }}</h2>
      <p><strong>Description:</strong> {{ $task->description }}</p>
      <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
      <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
      <p><strong>Label:</strong> {{ $task->label ? $task->label->name : 'None' }}</p>
      <p><strong>Notes:</strong> {{ $task->notes }}</p>
      <p><strong>Reminder:</strong> {{ $task->reminder ? 'Yes' : 'No' }}</p>

      @if ($task->attachments)
        @php
          $fileType = strtolower(pathinfo($task->attachments, PATHINFO_EXTENSION));
          $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        @endphp

        @if (in_array($fileType, $imageExtensions))
          <p><strong>Attachments:</strong></p>
          <img src="{{ asset('storage/' . $task->attachments) }}" alt="Task Attachment" class="task-image img-fluid clickable-image">
        @else
          <p>
            <strong>Attachments:</strong>
            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">View Attachment</a>
          </p>
        @endif
      @endif
    </div>
  </div>

  <!-- Lightbox Modal for Images -->
  <div id="lightbox-modal" class="lightbox-modal">
    <span class="close">&times;</span>
    <img class="lightbox-content" id="lightbox-image">
  </div>

  <!-- Optional Loading Overlay -->
  <div class="loading-overlay d-none" id="loading-overlay" aria-hidden="true">
    <div class="loading-spinner"></div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Dropdown for More Options (matching the Label dropdown behavior)
      const dropdownTrigger = document.querySelector('#dropdown-trigger');
      const dropdownMenu = document.querySelector('#task-dropdown');

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
      
      // Lightbox for Image Attachments
      const images = document.querySelectorAll('.clickable-image');
      const lightboxModal = document.getElementById('lightbox-modal');
      const lightboxImage = document.getElementById('lightbox-image');
      const closeBtn = document.querySelector('.lightbox-modal .close');

      images.forEach(img => {
          img.addEventListener('click', function(e) {
              e.preventDefault();
              lightboxModal.style.display = 'block';
              lightboxImage.src = this.src;
          });
      });

      closeBtn.addEventListener('click', function() {
          lightboxModal.style.display = 'none';
      });

      window.addEventListener('click', function(e) {
          if (e.target === lightboxModal) {
              lightboxModal.style.display = 'none';
          }
      });
    });
  </script>
</body>
</html>
