<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    
    <!-- Bootstrap CSS CDN (Integrity attributes removed for correctness) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS (Optional) -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <style>
        /* Global Styling */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
            color: #808080;
            font-family: 'Open Sans', sans-serif;
        }

        /* Top Bar Styling */
        .app-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 56px;
            padding: 0 20px;
            background-color: #F5F5F5;
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
        }

        /* Main Container Styling */
        .container {
            max-width: 500px;
            margin: 80px auto 0;
            padding: 20px;
        }

        .profile-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .circle-avatar {
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin: 20px auto;
        }

        /* Action Button Styling */
        .action-buttons button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-edit-name {
            background-color: #0d6efd;
        }

        .btn-edit-name:hover {
            background-color: #0b5ed7;
        }

        .btn-change-password {
            background-color: #6c757d;
        }

        .btn-change-password:hover {
            background-color: #5c636a;
        }

        .btn-delete-account {
            background-color: #dc3545;
        }

        .btn-delete-account:hover {
            background-color: #c82333;
        }

        .btn-logout {
            width: 100%;
            height: 56px;
            background: #F5F5F5;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            font-weight: 700;
        }

        .btn-logout:hover {
            background-color: #e0e0e0;
        }

        /* Alert Positioning */
        .alert-container {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 1050;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="app-bar">
        <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
            arrow_back
        </span>
        <h1 class="app-bar-title">Profile Management</h1>
        <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
            more_vert
        </span>
    </div>

    <div class="container">
        <!-- Alert Container -->
        <div class="alert-container">
            <!-- Display Success Message -->
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="circle-avatar">
                <i class="material-symbols-outlined" style="font-size: 48px;">person</i>
            </div>
            <h5>{{ $user->name }}</h5>
            <p class="text-muted">{{ $user->email }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="button" class="btn-edit-name" data-bs-toggle="modal" data-bs-target="#editNameModal">Edit Name</button>
            <button type="button" class="btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
            <button type="button" class="btn-delete-account" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
        </div>

        <!-- Logout Button -->
        <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
    </div>

    <!-- Edit Name Modal -->
    <div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNameModalLabel">Edit Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new-name" class="form-label">New Name</label>
                            <input type="text" class="form-control" id="new-name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Fields -->
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current-password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new-password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal Actions -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger"><strong>Warning:</strong> Deleting your account is irreversible. All your data will be permanently removed.</p>
                        <div class="mb-3">
                            <label for="delete-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="delete-password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal Actions -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal Actions -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dropdown for additional options
        const dropdownTrigger = document.querySelector('#dropdown-trigger');
        dropdownTrigger.addEventListener('click', function() {
            // You can implement additional dropdown options here if needed
            alert('Additional options could be implemented here.');
        });

        // Reopen modal if there are validation errors
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                changePasswordModal.show();
            @endif

            @if ($errors->has('name'))
                var editNameModal = new bootstrap.Modal(document.getElementById('editNameModal'));
                editNameModal.show();
            @endif

            @if ($errors->has('password') && request()->is('profile'))
                // Add more conditions if necessary
            @endif
        });
    </script>
</body>
</html>
