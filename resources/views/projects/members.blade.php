<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Share Project</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Material Icons Outlined -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
  
  <style>
    /* Global Styles */
    body {
      font-family: "Open Sans", sans-serif;
      background-color: #f5f5f5;
      color: #808080;
      margin: 0;
      box-sizing: border-box;
    }

    /* Top App Bar Styles */
    .app-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 56px;
      padding: 0 20px;
      background-color: #f5f5f5;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 1px solid #ddd;
    }

    /* Back Icon and Save Button Styles */
    .back-icon,
    .save-btn {
      cursor: pointer;
      color: #555;
      font-size: 24px;
      background: none;
      border: none;
      padding: 0;
    }

    /* Title Style */
    .app-bar-title {
      flex-grow: 1;
      text-align: center;
      font-size: 20px;
      font-weight: 500;
      color: #555;
      margin: 0;
    }

    /* Main Content Styles */
    main {
      margin-top: 56px;
      padding: 20px;
      text-align: center;
    }

    /* Illustration Section */
    .illustration {
      margin-bottom: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .illustration img {
      max-width: 100%;
      height: auto;
      max-height: 400px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Form Group Styles */
    .form-group {
      margin-top: 20px;
      margin-bottom: 25px;
      text-align: left;
      width: 100%;
      max-width: 500px;
      box-sizing: border-box;
      margin-left: auto;
      margin-right: auto;
    }

    /* Form Control Styles */
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

    /* Label Styles */
    .form-label {
      display: block;
      font-size: 14px;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }

    /* Placeholder Color */
    .form-control::placeholder {
      color: #808080;
      opacity: 1;
    }

    /* btn-get-started Styles */
    .btn-get-started {
      margin-top: 20px;
      background-color: #666;
      border: none;
      color: white;
      padding: 10px 20px;
      font-size: 1.25rem;
      font-weight: bold;
      border-radius: 10px;
      width: 265px;
      height: 56px;
      font-family: "Open Sans", sans-serif;
      cursor: pointer;
      display: inline-block;
      text-align: center;
      transition: background-color 0.3s ease;
    }

    .btn-get-started:hover {
      background-color: #555;
      color: white;
    }

    /* List Group Styles */
    .list-group {
      margin: 20px 0;
      padding-left: 0;
    }

    .list-group-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 767px) {
      .btn-get-started {
        width: 200px;
        font-size: 1rem;
      }
    }

    @media (max-width: 480px) {
      .app-bar {
        padding: 0 10px;
      }
      .app-bar-title {
        font-size: 18px;
      }
      .list-group-item {
        flex-direction: column;
        align-items: center;
      }
      .list-group-item form {
        margin-top: 10px;
      }
    }

    /* Mobile: Ensure the title "Share Project" is always centered */
    @media (max-width: 767px) {
      .app-bar {
        position: relative;
      }
      .app-bar-title {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 0;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <!-- Top App Bar -->
  <div class="app-bar d-flex align-items-center p-3 bg-light border-bottom">
    <span class="material-icons-outlined back-icon" onclick="window.history.back();" role="button">
      chevron_left
    </span>
    <h1 class="app-bar-title ms-3 mb-0">Share Project</h1>
  </div>

  <!-- Main Content -->
  <main class="container mt-4">
    <!-- Illustration Section -->
    <div class="illustration text-center mb-4">
      <img src="{{ asset('images/proj.png') }}" alt="Members Illustration">
    </div>

    <!-- Success and Error Messages -->
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

    <!-- Form to invite a new collaborator -->
    <div class="invite-member mb-4">
      <form action="{{ route('collaborations.invite', ['project' => $project->id]) }}" method="POST">
        @csrf
        <div class="form-group mb-3">
          <label for="email">Add Member by Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
          @error('email')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <button type="submit" class="btn-get-started">Send Invitation</button>
      </form>
    </div>

    <!-- Divider -->
    <hr class="my-4">

    <!-- Owner Section -->
    <h2 class="h5 mb-3">Project Owner</h2>
    <ul class="list-group mb-4">
      <li class="list-group-item d-flex flex-column align-items-center">
        <div>
          @if($project->owner)
            <strong>{{ $project->owner->name }}</strong>
            <span class="text-muted">({{ $project->owner->email }})</span>
            <span class="badge bg-primary ms-2">Owner</span>
          @else
            <strong>Owner not assigned</strong>
          @endif
        </div>
      </li>
    </ul>

    <!-- Collaborators Section -->
    <h2>Collaborators ({{ $project->acceptedCollaborators()->count() }})</h2>
    <ul class="list-group mb-4">
      @forelse($project->acceptedCollaborators as $collaborator)
        <li class="list-group-item d-flex flex-column align-items-center">
          <div>
            <strong>{{ $collaborator->name }}</strong> ({{ $collaborator->email }})
          </div>
          @if(Auth::id() === $project->owner->id)
            <form action="{{ route('collaborations.remove', [$project, $collaborator]) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-get-started">Remove</button>
            </form>
          @endif
        </li>
      @empty
        <li class="list-group-item">No collaborators yet.</li>
      @endforelse
    </ul>

    <!-- Pending Invitations Section -->
    <h2>Pending Invitations ({{ $project->pendingCollaborators()->count() }})</h2>
    <ul class="list-group mb-4">
      @forelse($project->pendingCollaborators as $pendingCollaborator)
        <li class="list-group-item d-flex flex-column align-items-center">
          <div>
            <strong>{{ $pendingCollaborator->name }}</strong> ({{ $pendingCollaborator->email }})
            <span class="badge bg-warning ms-2">Pending</span>
          </div>
          @if(Auth::id() === $project->owner->id)
            <form action="{{ route('collaborations.remove', ['project' => $project->id, 'user' => $pendingCollaborator->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this invitation?');">
              @csrf
              <button type="submit" class="btn-get-started">Cancel Invitation</button>
            </form>
          @endif
        </li>
      @empty
        <li class="list-group-item">No pending invitations.</li>
      @endforelse
    </ul>
  </main>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
