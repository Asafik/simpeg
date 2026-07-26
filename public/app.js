/* ===== SIMPEG-SP MAIN SYSTEM JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    const mobileToggle = document.getElementById('mobileToggle');
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mainContent = document.getElementById('mainContent');

    // Restore desktop sidebar mini state from localStorage
    const isMini = localStorage.getItem('sidebarMini') === 'true';
    if (isMini && sidebar && mainContent) {
        applyMiniSidebarState(true);
    }

    function applyMiniSidebarState(mini) {
        if (!sidebar) return;

        if (mini) {
            sidebar.classList.add('mini-sidebar');
            if (mainContent) {
                mainContent.classList.remove('md:ml-[270px]');
                mainContent.classList.add('md:ml-[80px]');
            }
            if (sidebarToggleIcon) {
                sidebarToggleIcon.classList.remove('fa-chevron-left');
                sidebarToggleIcon.classList.add('fa-chevron-right');
            }
        } else {
            sidebar.classList.remove('mini-sidebar');
            if (mainContent) {
                mainContent.classList.remove('md:ml-[80px]');
                mainContent.classList.add('md:ml-[270px]');
            }
            if (sidebarToggleIcon) {
                sidebarToggleIcon.classList.remove('fa-chevron-right');
                sidebarToggleIcon.classList.add('fa-chevron-left');
            }
        }
    }

    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentlyMini = sidebar.classList.contains('mini-sidebar');
            const newState = !currentlyMini;
            applyMiniSidebarState(newState);
            localStorage.setItem('sidebarMini', newState ? 'true' : 'false');
        });
    }

    // === SETTING ACCORDION SUBMENU TOGGLE (WITH SMOOTH SLIDE ANIMATION) ===
    const settingMenuBtn = document.getElementById('settingMenuBtn') || document.getElementById('settingSubmenuToggleBtn');
    const settingSubmenu = document.getElementById('settingSubmenu') || document.getElementById('settingSubmenuList');
    const settingArrow = document.getElementById('settingArrow') || document.getElementById('settingSubmenuArrow');

    if (settingMenuBtn && settingSubmenu) {
        settingMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = settingSubmenu.classList.contains('accordion-expanded') || settingSubmenu.classList.contains('open-submenu');
            
            if (isExpanded) {
                settingSubmenu.classList.remove('accordion-expanded', 'open-submenu');
                if (settingArrow) {
                    settingArrow.classList.remove('rotate-90');
                }
            } else {
                settingSubmenu.classList.add('accordion-expanded');
                if (settingArrow) {
                    settingArrow.classList.add('rotate-90');
                }
            }
        });
    }

    // === USER PROFILE DROPDOWN TOGGLE ===
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    if (userDropdownBtn && userDropdownMenu) {
        userDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!userDropdownMenu.contains(e.target) && !userDropdownBtn.contains(e.target)) {
                userDropdownMenu.classList.add('hidden');
            }
        });
    }

    // === MOBILE SIDEBAR TOGGLE ===
    if (mobileToggle && sidebar && overlay) {
        function toggleMobileSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }

        mobileToggle.addEventListener('click', toggleMobileSidebar);
        overlay.addEventListener('click', toggleMobileSidebar);
    }

});
