<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Project Task Details</title>
  <link rel="stylesheet" href="{{ asset('css/task_details.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="app-bar">
    <!-- Back Icon -->
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();" tabindex="0" role="button" aria-label="Go Back" title="Go Back">
      arrow_back
    </span>
    <h1 class="app-bar-title">Project Task Details</h1>

    <!-- More Options (Edit, Delete) -->
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false" title="More Options">
      more_vert
    </span>

    <ul id="task-dropdown" class="dropdown-content">
      <li>
        <a href="{{ route('projecttasks.edit', ['project' => $project->id, 'task' => $task->id]) }}">
          <span class="material-symbols-outlined">edit</span>
          Edit Task
        </a>
      </li>
      <li>
        <!-- No confirmation: immediate deletion -->
        <form action="{{ route('projecttasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit">
            <span class="material-symbols-outlined">delete</span>
            Delete Task
          </button>
        </form>
      </li>
    </ul>
  </div>

  <div class="container">
    <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="task-illustration" />
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
          $imageExtensions = ['jpg','jpeg','png','gif'];
        @endphp

        @if (in_array($fileType, $imageExtensions))
          <p><strong>Attachments:</strong></p>
          <img src="{{ asset('storage/' . $task->attachments) }}" alt="Task Attachment" class="task-image img-fluid clickable-image" />
        @else
          <p><strong>Attachments:</strong> 
            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">View Attachment</a>
          </p>
        @endif
      @endif
    </div>
  </div>

  <!-- Lightbox Modal for Images -->
  <div id="lightbox-modal" class="lightbox-modal">
    <span class="close" tabindex="0" role="button" aria-label="Close">&times;</span>
    <img class="lightbox-content" id="lightbox-image" />
  </div>

  <!-- Optional Loading Overlay -->
  <div class="loading-overlay d-none" id="loading-overlay" aria-hidden="true">
    <div class="loading-spinner"></div>
  </div>

  <!-- Bootstrap + Optional Scripts -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Dropdown for More Options
      const dropdownTrigger = document.querySelector('#dropdown-trigger');
      const dropdownMenu = document.querySelector('#task-dropdown');

      dropdownTrigger.addEventListener('click', function() {
        dropdownMenu.classList.toggle('open');
      });

      dropdownTrigger.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          dropdownTrigger.click();
        }
      });

      document.addEventListener('click', function(e) {
        if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
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

      closeBtn.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          lightboxModal.style.display = 'none';
        }
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
