<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/taskmanagement.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Material Icons Outlined -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <style>
        /* =========================================
           1. Global Styling Enhancements
        ========================================= */
        html,
        body {
            font-family: "Open Sans", sans-serif;
            background: linear-gradient(-45deg, #f9f9f9, #e0e0e0, #f9f9f9, #e0e0e0);
            background-size: 400% 400%;
            animation: backgroundShift 15s ease infinite;
            color: #808080;
            margin: 0;
            box-sizing: border-box;
            min-height: 100vh;
        }
        
        @keyframes backgroundShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* =========================================
           2. Header Styles
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
    }
    .app-bar-title {
      flex-grow: 1;
      text-align: center;
      font-size: 20px;
      font-weight: 500;
      color: #555;
      margin: 0;
    }
        .back-icon {
            cursor: pointer;
            font-size: 24px;
            color: #555;
            transition: color 0.3s ease;
            text-decoration: none;
        }
        .back-icon:hover {
            color: #333;
        }

        /* =========================================
           3. Main Container Styling
        ========================================= */
        .container {
            max-width: 500px;
            margin: 80px auto 20px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* =========================================
           4. Profile Card Enhancements
        ========================================= */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px 20px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-4px);
        }
        .circle-avatar {
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin: 20px auto;
            overflow: hidden;
            border: 3px solid #17a2b8;
            animation: rotateAvatar 10s linear infinite;
        }
        @keyframes rotateAvatar {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .circle-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-card h5 {
            margin-top: 15px;
            font-size: 22px;
            color: #333;
        }
        .profile-info {
            margin-top: 10px;
            color: #666;
            font-size: 16px;
        }

        /* =========================================
           5. Action Buttons Styling
        ========================================= */
        .action-buttons button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            margin-bottom: 12px;
            background-color: rgba(128, 128, 128, 0.2);
            color: #333;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .action-buttons button:hover {
            background-color: rgba(128, 128, 128, 0.4);
            transform: translateY(-2px);
        }

        /* =========================================
           6. Logout Button Styling
        ========================================= */
        .btn-logout {
            width: 100%;
            height: 56px;
            background: #F5F5F5;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #333;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-logout:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
        }
        .btn-logout i {
            margin-right: 8px;
            vertical-align: middle;
            font-size: 20px;
        }

        /* =========================================
           7. Modals Enhancements
           (Remove the header close "x" icon)
        ========================================= */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hide the default header close button */
        .modal-header .btn-close {
            display: none;
        }

        /* =========================================
           8. Icon Button Styles (Modal Footer)
        ========================================= */
        .icon-button {
            width: 40px;
            height: 40px;
            border: none;
            background-color: #ffffff;
            color: #808080;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-left: 8px;
            outline: none;
        }
        .icon-button:hover {
            background-color: #808080;
            color: #ffffff;
        }
        .icon-button .material-icons-outlined {
            font-size: 24px;
        }

        /* =========================================
           9. Responsive Adjustments
        ========================================= */
        @media (max-width: 576px) {
            .profile-card {
                padding: 20px 15px;
            }
            .circle-avatar {
                width: 100px;
                height: 100px;
                border-width: 2px;
            }
            .profile-card h5 {
                font-size: 20px;
            }
            .profile-info {
                font-size: 14px;
            }
            .action-buttons button {
                font-size: 14px;
                padding: 10px;
            }
            .btn-logout {
                font-size: 14px;
                height: 48px;
            }
            .btn-logout i {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="app-bar">
        <!-- Back Icon (chevron_left) -->
        <a href="{{ route('dashboard') }}" class="material-icons-outlined back-icon" aria-label="Back to Dashboard">
            chevron_left
        </a>
        <h1 class="app-bar-title">Profile Management</h1>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Alert Container -->
        <div class="alert-container">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                <img src="{{ $user->avatar_url ?? asset('images/user.jpg') }}" alt="User Avatar">
            </div>
            <h5>{{ $user->name }}</h5>
            <p class="profile-info">{{ $user->email }}</p>
            <p class="profile-info">Joined on {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="button" class="btn-edit-name" data-bs-toggle="modal" data-bs-target="#editNameModal" title="Edit your display name">
                <i class="material-icons-outlined">edit</i> Edit Name
            </button>
            <button type="button" class="btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal" title="Change your account password">
                <i class="material-icons-outlined">lock</i> Change Password
            </button>
            <button type="button" class="btn-delete-account" data-bs-toggle="modal" data-bs-target="#deleteAccountModal" title="Permanently delete your account">
                <i class="material-icons-outlined">delete</i> Delete Account
            </button>
        </div>

        <!-- Logout Button -->
        <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal" title="Logout from your account">
            <i class="material-icons-outlined">logout</i> Logout
        </button>
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
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new-name" class="form-label">New Name</label>
                            <input type="text" class="form-control" id="new-name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel">
                            <span class="material-icons-outlined">close</span>
                        </button>
                        <button type="submit" class="icon-button" aria-label="Save Changes">
                            <span class="material-icons-outlined">send</span>
                        </button>
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
                    </div>
                    <div class="modal-body">
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
                        <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel">
                            <span class="material-icons-outlined">close</span>
                        </button>
                        <button type="submit" class="icon-button" aria-label="Update Password">
                            <span class="material-icons-outlined">send</span>
                        </button>
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
                    </div>
                    <div class="modal-body">
                        <p class="text-danger"><strong>Warning:</strong> Deleting your account is irreversible. All your data will be permanently removed.</p>
                        <div class="mb-3">
                            <label for="delete-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="delete-password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel">
                            <span class="material-icons-outlined">close</span>
                        </button>
                        <button type="submit" class="icon-button" aria-label="Delete Account">
                            <span class="material-icons-outlined">send</span>
                        </button>
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
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel">
                            <span class="material-icons-outlined">close</span>
                        </button>
                        <button type="submit" class="icon-button" aria-label="Confirm Logout">
                            <span class="material-icons-outlined">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize Bootstrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Reopen modal if there are validation errors
        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                changePasswordModal.show();
            @endif

            @if ($errors->has('name'))
                var editNameModal = new bootstrap.Modal(document.getElementById('editNameModal'));
                editNameModal.show();
            @endif
        });
    </script>
</body>
</html>
