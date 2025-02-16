<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Project - {{ $project->name }}</title>
    <!-- Favicon -->
    <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    
  
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <!-- (Optional) Remove any conflicting custom CSS; we use inline styles for consistency -->
  
  <!-- Material Icons (Material Symbols Outlined) -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet" />
  
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
    .header-icon {
      cursor: pointer;
      color: #555;
      font-size: 24px;
      background: none;
      border: none;
      padding: 0;
    }
    .back-icon {
      transition: transform 0.3s ease;
    }
    .back-icon:hover {
      transform: rotate(90deg);
    }
    
    /* =========================================
       3. Main Content Styles
    ========================================= */
    main {
      margin-top: 56px; /* Leaves space for the fixed app bar */
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
      margin: 70px auto 40px;
    }
    
    /* =========================================
       4. Form Styles (Matching Task Edit)
    ========================================= */
    .form-group {
      margin: 20px auto 25px;
      text-align: left;
      width: 100%;
      box-sizing: border-box;
    }
    .form-label {
      display: block;
      font-size: 14px;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
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
    <span class="material-symbols-outlined back-icon header-icon" onclick="window.history.back();" tabindex="0" role="button" aria-label="Go Back" title="Go Back">
      chevron_left
    </span>
    <!-- Header title now shows only the project name -->
    <h1 class="app-bar-title">{{ $project->name }}</h1>
    <button type="submit" form="edit-project-form" class="header-icon" aria-label="Save Project" title="Save Project">
      <span class="material-symbols-outlined">check</span>
    </button>
  </div>

  <!-- Main Content -->
  <main>
    <!-- Illustration Section -->
    <div class="illustration">
      <img src="{{ asset('images/illustration1.png') }}" alt="Project Illustration">
    </div>

    <div class="container">
      <!-- Edit Project Form -->
      <form id="edit-project-form" action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
          <label for="name" class="form-label">Project Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Project Name" value="{{ $project->name }}" required>
        </div>
        
        <div class="form-group">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $project->description }}</textarea>
        </div>
        
        <div class="form-group">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $project->start_date }}" required>
        </div>
        
        <div class="form-group">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $project->end_date }}" required>
        </div>
      </form>
    </div>
  </main>

  <!-- Bootstrap 5 JS -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
