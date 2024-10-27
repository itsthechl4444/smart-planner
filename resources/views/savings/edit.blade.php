<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Saving</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Edit Saving</h1>
        <button type="submit" form="edit-saving-form" class="save-btn">
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration2.png') }}" alt="Saving Illustration">
        </div>

        <div class="container">
            <form id="edit-saving-form" action="{{ route('savings.update', $saving->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $saving->name }}" placeholder="Name of the Saving" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $saving->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desired_amount" class="form-label">Desired Amount</label>
                    <input type="number" class="form-control" id="desired_amount" name="desired_amount" value="{{ $saving->desired_amount }}" required>
                    @error('desired_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desired_date" class="form-label">Desired Date</label>
                    <input type="date" class="form-control" id="desired_date" name="desired_date" value="{{ $saving->desired_date }}" required>
                    @error('desired_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="notes" name="notes" placeholder="Notes">{{ $saving->notes }}</textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="attachment" class="form-label">Current Attachment</label><br>
                    @if ($saving->attachment)
                        <a href="{{ asset('attachments/' . $saving->attachment) }}" target="_blank">{{ $saving->attachment }}</a>
                        <br><br>
                    @else
                        No attachment uploaded.
                    @endif
                    <input type="file" class="form-control mt-2" id="attachment" name="attachment">
                    @error('attachment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
