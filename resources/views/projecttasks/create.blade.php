<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project Task</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- Top App Bar -->
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Create Project Task</h1>
        <button type="submit" form="create-task-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <div class="illustration">
            <img src="{{ asset('images/illustration1.png') }}" alt="Task Illustration">
        </div>

        <div class="container">
            <form id="create-task-form" action="{{ route('projecttasks.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Task Title" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                    @error('due_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control" id="priority" name="priority">
                        <option value="" disabled selected>Select Priority</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    </select>
                    @error('priority')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="label_id" class="form-label">Label</label>
                    <select class="form-control" id="label_id" name="label_id">
                        <option value="" disabled selected>Select Label</option>
                        @foreach($labels as $label)
                            <option value="{{ $label->id }}" {{ old('label_id') == $label->id ? 'selected' : '' }}>{{ $label->name }}</option>
                        @endforeach
                    </select>
                    @error('label_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="notes" name="notes" placeholder="Notes">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="attachments" class="form-label">Attachments</label>
                    <input type="file" class="form-control" id="attachments" name="attachments">
                    @error('attachments')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group form-check">
                    <input type="hidden" name="reminder" value="0">
                    <input type="checkbox" class="form-check-input" id="reminder" name="reminder" value="1" {{ old('reminder') ? 'checked' : '' }}>
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
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</body>
</html>
