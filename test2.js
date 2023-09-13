$(document).ready(function() {
    const toggleBtn = $(".toggle-btn");
    const sidebar = $(".sidebar");

    toggleBtn.click(function() {
        sidebar.toggleClass("open");
    });
});
