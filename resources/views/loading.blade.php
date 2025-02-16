<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading - Smart Planner</title>
    <style>
        /* Ensure the html and body take the full height of the viewport */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #f9f9f9; /* Light background color */
            font-family: Arial, sans-serif;
        }
        /* Loader container fills the viewport and centers its contents */
        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;  /* Centers content horizontally */
            justify-content: center; /* Centers content vertically */
            height: 100%;
            text-align: center;
        }
        /* Logo styling: Adjust width as necessary; height auto maintains aspect ratio */
        .loader-logo {
            width: 200px;
            height: auto;
        }
        /* Circle spinner styling */
        .spinner {
            margin-top: 20px; /* Space between logo and spinner */
            width: 50px;
            height: 50px;
            border: 6px solid #ccc; /* Light gray border */
            border-top: 6px solid #808080; /* Darker gray for the animated part */
            border-radius: 50%; /* Makes the div circular */
            animation: spin 1s linear infinite; /* Continuously rotates the spinner */
        }
        /* Keyframes for spinner animation: rotates from 0 to 360 degrees */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loader-container">
        <!-- The Smart Planner logo is displayed using the asset() helper to reference the public/images folder -->
        <img src="{{ asset('images/LogoPNG.png') }}" alt="Smart Planner Logo" class="loader-logo">
        <!-- The spinner element is a simple div styled to appear as a rotating circle -->
        <div class="spinner"></div>
    </div>
</body>
</html>
