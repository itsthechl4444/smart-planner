document.addEventListener("DOMContentLoaded", () => {
    const menuIcon = document.getElementById("menu-icon");
    const sidebar = document.getElementById("sidebar");

    menuIcon.addEventListener("click", (e) => {
        e.stopPropagation();
        sidebar.classList.toggle("open");
        menuIcon.classList.toggle("hidden");
    });

    // Close the sidebar when clicking outside of it
    document.addEventListener("click", (e) => {
        if (
            !sidebar.contains(e.target) &&
            !menuIcon.contains(e.target) &&
            sidebar.classList.contains("open")
        ) {
            sidebar.classList.remove("open");
            menuIcon.classList.remove("hidden");
        }
    });
});
