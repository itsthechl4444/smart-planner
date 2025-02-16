<!-- resources/views/partials/loader.blade.php -->
<div id="global-loader" class="loader-container">
    <!-- The Smart Planner logo is displayed using the asset() helper to reference public/images/LogoPNG.png -->
    <img src="{{ asset('images/LogoPNG.png') }}" alt="Smart Planner Logo" class="loader-logo">
    <!-- The spinner element: a circle that rotates -->
    <div class="spinner"></div>
</div>

<!-- Inline CSS for the loader (you can also move these styles to your CSS file) -->
<style>
    /* Ensure the loader covers the full viewport */
    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #f9f9f9;  /* Background color (customize as needed) */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;  /* Very high so it overlays all other content */
        text-align: center;
    }
    /* Logo styling: Adjust width as necessary */
    .loader-logo {
        width: 200px;
        height: auto;
    }
    /* Spinner styling: A circle spinner under the logo */
    .spinner {
        margin-top: 20px;
        width: 50px;
        height: 50px;
        border: 6px solid #ccc;  /* Light gray border */
        border-top: 6px solid #808080;  /* Darker part for the animated spinner */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    /* Keyframes for spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
