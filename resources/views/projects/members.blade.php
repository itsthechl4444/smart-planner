<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Project</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/members.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar d-flex align-items-center p-3 bg-light border-bottom">
        <span class="material-icons-outlined back-icon" onclick="window.history.back();" role="button">
            arrow_back
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
            <li class="list-group-item d-flex justify-content-between align-items-center">
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
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $collaborator->name }}</strong> ({{ $collaborator->email }})
                    </div>
                    @if(Auth::id() === $project->owner->id)
                        <form action="{{ route('collaborations.remove', [$project, $collaborator]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
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
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $pendingCollaborator->name }}</strong> ({{ $pendingCollaborator->email }})
                        <span class="badge bg-warning ms-2">Pending</span>
                    </div>
                    @if(Auth::id() === $project->owner->id)

                    <form action="{{ route('collaborations.remove', ['project' => $project->id, 'user' => $pendingCollaborator->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this invitation?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Cancel Invitation</button>
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
