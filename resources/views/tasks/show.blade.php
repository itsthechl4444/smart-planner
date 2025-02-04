<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Details</title>
  <link rel="stylesheet" href="{{ asset('css/task_details.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body>
  <div class="app-bar">
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      arrow_back
    </span>
    <h1 class="app-bar-title">Task Details</h1>
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
      more_vert
    </span>
    <ul id="task-dropdown" class="dropdown-content">
      <li>
        <a href="{{ route('tasks.edit', $task->id) }}">
          <span class="material-symbols-outlined">edit</span> Edit Task
        </a>
      </li>
      <li>
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit">
            <span class="material-symbols-outlined">delete</span> Delete Task
          </button>
        </form>
      </li>
      @if ($task->status !== 'completed')
      <li>
        <form action="{{ route('tasks.markAsCompleted', $task->id) }}" method="POST" id="complete-task-form">
          @csrf
          <button type="submit" id="complete-task-btn">
            <span class="material-symbols-outlined">check_circle</span> Mark as Completed
          </button>
        </form>
      </li>
      @endif
    </ul>
  </div>

  <div class="container">
    <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="task-illustration">
    <div class="task-details">
      <h2>{{ $task->title }}</h2>
      <p><strong>Description:</strong> {{ $task->description }}</p>
      <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
      <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
      <p><strong>Label:</strong> {{ $task->label ? $task->label->name : 'None' }}</p>
      <p><strong>Notes:</strong> {{ $task->notes }}</p>

      <!-- Attachment Display -->
      @if ($task->attachments)
        @php
          $fileType = strtolower(pathinfo($task->attachments, PATHINFO_EXTENSION));
          $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        @endphp

        @if (in_array($fileType, $imageExtensions))
          <p><strong>Attachment:</strong></p>
          <!-- Image is clickable and opens in a lightbox -->
          <img src="{{ asset('storage/' . $task->attachments) }}" alt="Task Attachment" class="task-image img-fluid clickable-image">
        @else
          <p><strong>Attachment:</strong>
            <!-- Non-image file: provide a link to view/download -->
            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">View / Download File</a>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Dropdown menu functionality
      const dropdownTrigger = document.querySelector('#dropdown-trigger');
      const dropdownMenu = document.querySelector('#task-dropdown');
      dropdownTrigger.addEventListener('click', function () {
        dropdownMenu.classList.toggle('open');
      });
      document.addEventListener('click', function (event) {
        if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.remove('open');
        }
      });

      // Prevent multiple submissions for marking as completed
      const completeTaskForm = document.getElementById('complete-task-form');
      const completeTaskBtn = document.getElementById('complete-task-btn');
      if (completeTaskForm && completeTaskBtn) {
        completeTaskForm.addEventListener('submit', function () {
          completeTaskBtn.disabled = true;
        });
      }

      // Lightbox functionality for clickable image attachments
      const clickableImages = document.querySelectorAll('.clickable-image');
      const lightboxModal = document.getElementById('lightbox-modal');
      const lightboxImage = document.getElementById('lightbox-image');
      const closeBtn = document.querySelector('.lightbox-modal .close');
      clickableImages.forEach(function (image) {
        image.addEventListener('click', function (event) {
          event.preventDefault();
          lightboxModal.style.display = 'block';
          lightboxImage.src = this.src;
        });
      });
      closeBtn.addEventListener('click', function () {
        lightboxModal.style.display = 'none';
      });
      window.addEventListener('click', function (event) {
        if (event.target == lightboxModal) {
          lightboxModal.style.display = 'none';
        }
      });
    });
  </script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
