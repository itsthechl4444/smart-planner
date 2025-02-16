<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Task Details</title>
   <!-- Favicon -->
   <link rel="icon" href="/images/LogoPNG.png" type="image/png">

  <!-- Optionally include Bootstrap 5 for consistency (local asset) -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  <!-- Materialize CSS (CDN) -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    integrity="sha512-5Mu4X0UL+H7OHM8xKLb7kPP8OH6kGdrAaNFeCz4nywsSBgj3vlpJbIFpJOVHTD9K1PLcIISViU6Ly6q4zsdZzQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
/>

  <!-- Material Icons -->
  <link 
    href="https://fonts.googleapis.com/css2?family=Material+Icons&family=Material+Symbols+Outlined" 
    rel="stylesheet"
  >

  <style>
    /* ============================
       1. Global Styles
    ============================ */
    body {
      font-family: "Open Sans", sans-serif;
      background: linear-gradient(to right, #f9f9f9, #f5f5f5);
      color: #808080;
      margin: 0;
      box-sizing: border-box;
    }

    /* ============================
       2. Top App Bar Styles
    ============================ */
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
    .dropdown-trigger {
      cursor: pointer;
      color: #555;
      font-size: 24px; /* Material icon size */
    }

    /* ============================
       3. Dropdown Menu Styles
    ============================ */
    .dropdown-content {
      position: absolute;
      top: 30px;
      right: 10px;
      display: none;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      z-index: 9999;
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

    /* Same left and right padding, minimal whitespace */
    .dropdown-content li {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      cursor: pointer;
      white-space: nowrap;
      font-size: 14px;
    }
    /* Light divider between items */
    .dropdown-content li + li {
      border-top: 1px solid #ddd;
    }

    /* No extra horizontal padding in link/button; 
       the <li> handles the main spacing. */
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
      font-size: 14px;
      padding: 0;
    }
    /* Icon margin for clarity */
    .dropdown-content li span.material-symbols-outlined {
      margin-right: 6px;
      font-size: 20px;
    }

    .dropdown-content li:hover {
      background-color: #f0f0f0;
    }
    .dropdown-content form {
      margin: 0;
    }

    /* ============================
       4. Main Content
    ============================ */
    .container {
      width: 90%;
      max-width: 800px;
      margin: 70px auto 40px; /* 70px to avoid the app bar overlap */
      padding-bottom: 40px;
    }
    .task-illustration {
      width: 80%;
      max-width: 300px;
      height: auto;
      display: block;
      margin: 0 auto 20px;
    }
    .task-details {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
    }
    .task-details h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }
    .task-details p {
      font-size: 16px;
      margin-bottom: 8px;
      color: #555;
    }
    .task-details strong {
      font-weight: bold;
    }
    .task-image {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* ============================
       5. Clickable Image & Lightbox
    ============================ */
    .clickable-image {
      cursor: pointer;
      transition: transform 0.2s;
    }
    .clickable-image:hover {
      transform: scale(1.02);
    }

    .download-link {
      color: #007bff;
      text-decoration: none;
    }
    .download-link:hover {
      text-decoration: underline;
    }

    .lightbox-modal {
      display: none;
      position: fixed;
      z-index: 2000;
      padding-top: 60px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.8);
    }
    .lightbox-modal .close {
      position: absolute;
      top: 30px;
      right: 35px;
      color: #fff;
      font-size: 40px;
      font-weight: bold;
      cursor: pointer;
    }
    .lightbox-content {
      margin: auto;
      display: block;
      max-width: 80%;
      max-height: 80%;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* ============================
       6. Responsive Breakpoints
    ============================ */
    @media (max-width: 768px) {
      .app-bar-title {
        font-size: 18px;
      }
      .task-details h2 {
        font-size: 20px;
      }
      .task-details p {
        font-size: 14px;
      }
      .task-illustration {
        width: 100%;
        max-width: 250px;
      }
    }
    @media (max-width: 360px) {
      .app-bar-title {
        font-size: 16px;
      }
      .task-details h2 {
        font-size: 18px;
      }
      .task-details p {
        font-size: 12px;
      }
      .task-illustration {
        width: 100%;
        max-width: 200px;
      }
    }
    @media only screen and (max-width: 700px) {
      .lightbox-content {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  @include('partials.loader')

  <!-- Top App Bar -->
  <div class="app-bar">
    <!-- Back icon (chevron_left) -->
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
      chevron_left
    </span>
    <h1 class="app-bar-title">Task Details</h1>
    
    <!-- "more_horiz" icon -->
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
      more_horiz
    </span>
    
    <!-- Dropdown Menu -->
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

  <!-- Main Content -->
  <div class="container">
    <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="task-illustration">
    <div class="task-details card-panel hoverable">
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
            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank" class="download-link">
              View / Download File
            </a>
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

  <!-- Scripts -->
  <!-- Bootstrap Bundle JS -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Include your custom loader JS file -->
    <script src="{{ asset('js/loader.js') }}"></script>

  <!-- Materialize JS (CDN) -->
  <script 
    src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
    integrity="sha512-ade4C/VZCvfO3Sq0j8I1NHTZAA3Xz3EJ+WpGSo4VkPy7AdA2LC8tPEFeE8+qSgLW3HLS4KzOQv0K2SV/d51dtg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>

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
</body>
</html>
