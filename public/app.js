/* ===== SIMPEG-SP MAIN SYSTEM JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    const mobileToggle = document.getElementById('mobileToggle');
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mainContent = document.getElementById('mainContent');

    // ===== SIDEBAR RESPONSIVE STATE MANAGEMENT =====
    // Mobile (<768px): hidden offscreen, toggled via hamburger
    // Tablet (768px - 1024px): DEFAULT TO MINI (Icon-Only Mode, w-[80px])
    // Desktop (>1024px): DEFAULT TO FULL SIDEBAR (w-[270px])

    // Clear legacy single key to prevent old test data sticky issues
    if (localStorage.getItem('sidebarMini') !== null) {
        localStorage.removeItem('sidebarMini');
    }

    function updateSidebarState() {
        const width = window.innerWidth;

        if (width > 1024) {
            // DESKTOP MODE: Default to FULL SIDEBAR (w-[270px])
            const desktopSaved = localStorage.getItem('sidebarMini_desktop');
            const shouldBeMini = desktopSaved === 'true';
            applyMiniSidebarState(shouldBeMini);
        } else if (width >= 768 && width <= 1024) {
            // TABLET MODE: Default to MINI SIDEBAR (Icon-Only Mode, w-[80px])
            const tabletSaved = localStorage.getItem('sidebarMini_tablet');
            const shouldBeMini = tabletSaved === null ? true : (tabletSaved === 'true');
            applyMiniSidebarState(shouldBeMini);
        } else {
            // MOBILE MODE: Remove mini class so when toggled via hamburger it shows full sidebar
            if (sidebar) sidebar.classList.remove('mini-sidebar');
        }
    }

    if (sidebar && mainContent) {
        updateSidebarState();
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
            const width = window.innerWidth;
            const currentlyMini = sidebar.classList.contains('mini-sidebar');
            const newState = !currentlyMini;
            applyMiniSidebarState(newState);

            if (width > 1024) {
                localStorage.setItem('sidebarMini_desktop', newState ? 'true' : 'false');
            } else if (width >= 768 && width <= 1024) {
                localStorage.setItem('sidebarMini_tablet', newState ? 'true' : 'false');
            }
        });
    }

    // === SETTING ACCORDION SUBMENU TOGGLE (WITH SMOOTH SLIDE ANIMATION) ===
    const settingButtons = document.querySelectorAll('#settingMenuBtn, #settingSubmenuToggleBtn');
    settingButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = btn.closest('.relative') || btn.parentElement;
            const submenu = (parent ? parent.querySelector('#settingSubmenu, #settingSubmenuList, .sidebar-accordion-submenu') : null) 
                            || document.getElementById('settingSubmenu') 
                            || document.getElementById('settingSubmenuList');
            const arrow = btn.querySelector('#settingArrow, #settingSubmenuArrow') || document.getElementById('settingArrow');

            if (submenu) {
                const isExpanded = submenu.classList.contains('accordion-expanded') || submenu.classList.contains('open-submenu');
                if (isExpanded) {
                    submenu.classList.remove('accordion-expanded', 'open-submenu');
                    if (arrow) arrow.classList.remove('rotate-90');
                } else {
                    submenu.classList.add('accordion-expanded');
                    if (arrow) arrow.classList.add('rotate-90');
                }
            }
        });
    });

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

    // === MOBILE SIDEBAR TOGGLE (WITH GUARANTEED OVERLAY BLUR & OUTSIDE CLICK CLOSE) ===
    if (mobileToggle && sidebar) {
        function openMobileSidebar(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            sidebar.classList.remove('-translate-x-full');
            if (overlay) overlay.classList.add('active');
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileSidebar() {
            sidebar.classList.add('-translate-x-full');
            if (overlay) overlay.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
        }

        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                openMobileSidebar(e);
            } else {
                closeMobileSidebar();
            }
        });

        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileSidebar();
            });
        }

        // Close mobile sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                const isSidebarOpen = !sidebar.classList.contains('-translate-x-full');
                if (isSidebarOpen) {
                    if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                        closeMobileSidebar();
                    }
                }
            }
        });

        // Auto reset state on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeMobileSidebar();
                updateSidebarState();
            } else {
                closeMobileSidebar();
            }
        });
    }
});
