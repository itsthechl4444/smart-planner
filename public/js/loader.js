// public/js/loader.js

// When the entire page (including images, CSS, etc.) is fully loaded,
// fade out and hide the global loader.
window.addEventListener("load", function () {
    var loader = document.getElementById("global-loader");
    if (loader) {
        // Optional: Add a fade-out transition by setting opacity to 0.
        loader.style.opacity = 0;
        // After a short delay, remove the loader from view.
        setTimeout(function () {
            loader.style.display = "none";
        }, 300); // Adjust the delay (in milliseconds) as needed
    }
});
