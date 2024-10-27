<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Expense</title>
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
        <h1 class="app-bar-title">Create Expense</h1>
        <button type="submit" form="create-expense-form" class="save-btn">
            <span class="material-symbols-outlined">
                check
            </span>
        </button>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('images/illustration.png') }}" alt="Expense Illustration">
        </div>

        <div class="container">
            <form id="create-expense-form" action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Expense Name -->
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Expense Name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Description -->
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Amount -->
                <div class="form-group">
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Category -->
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Date -->
                <div class="form-group">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Currency -->
                <div class="form-group">
                    <label for="currency" class="form-label">Currency</label>
                    <select class="form-control" id="currency" name="currency" required>
                        <option value="" disabled selected>Select Currency</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}">{{ $currency }}</option>
                        @endforeach
                    </select>
                    @error('currency')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Payment Method -->
                <div class="form-group">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="" disabled selected>Select Payment Method</option>
                        @foreach ($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod }}">{{ $paymentMethod }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Notes -->
                <div class="form-group">
                    <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Attachment with Preview -->
                <div class="form-group">
                    <label for="attachment" class="form-label">Attachment</label>
                    <input type="file" class="form-control" id="attachment" name="attachment" accept="image/*,application/pdf">
                    @error('attachment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <img id="attachment-preview" src="#" alt="Attachment Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
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

            // Attachment Image Preview
            const attachmentInput = document.getElementById('attachment');
            const attachmentPreview = document.getElementById('attachment-preview');

            attachmentInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Check if the file is an image
                        if (file.type.startsWith('image/')) {
                            attachmentPreview.src = e.target.result;
                            attachmentPreview.style.display = 'block';
                        } else {
                            attachmentPreview.src = '#';
                            attachmentPreview.style.display = 'none';
                        }
                    }
                    reader.readAsDataURL(file);
                } else {
                    attachmentPreview.src = '#';
                    attachmentPreview.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
