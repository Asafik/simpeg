/* ===== SIMPEG-SP MAIN SYSTEM JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    // === MOBILE SIDEBAR TOGGLE ===
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (mobileToggle && sidebar && overlay) {
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }

        mobileToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('md:translate-x-0');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.remove('md:translate-x-0');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    }

});
