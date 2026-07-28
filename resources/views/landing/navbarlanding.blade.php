<!-- Dynamic Scroll Sticky Navbar (Modular Landing Component) -->
<header id="landingNavbar"
    class="w-full fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent py-5">
    <div class="w-full px-6 md:px-12 flex items-center justify-between">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo"
                class="w-10 h-10 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-200">
            <div>
                <h1 class="font-extrabold text-lg leading-tight text-white tracking-tight">GTK</h1>
                <p class="text-[10px] uppercase tracking-wider text-blue-200/80 font-semibold">Dinas Pendidikan</p>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden xl:flex items-center gap-8 text-xs font-semibold text-blue-100/90">
            <a href="{{ url('/') }}"
                class="{{ (Request::is('/') || Request::is('landing')) && !Request::is('statistik*') && !Request::is('layanan*') && !Request::is('cek-ptk*') && !Request::is('pengumuman*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Beranda
            </a>
            <a href="{{ url('/statistik') }}"
                class="{{ Request::is('statistik*') || Request::is('landing/statistik*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Statistik Data
            </a>
            <a href="{{ url('/layanan') }}"
                class="{{ Request::is('layanan*') || Request::is('landing/layanan*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Layanan & Keunggulan
            </a>
            <a href="{{ url('/cek-ptk') }}"
                class="{{ Request::is('cek-ptk*') || Request::is('landing/cek-ptk*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Cek Data PTK
            </a>
            <a href="{{ url('/pengumuman') }}"
                class="{{ Request::is('pengumuman*') || Request::is('landing/pengumuman*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Pengumuman
            </a>
        </nav>

        <!-- CTA Buttons (Official System Palette) & Mobile Toggle -->
        <div class="flex items-center gap-3">
            <!-- Desktop CTA Buttons -->
            <div class="hidden xl:flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-chart-pie text-xs"></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ url('/login') }}"
                        class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-right-to-bracket text-xs"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ url('/cek-ptk') }}"
                        class="hidden sm:flex bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition items-center gap-1.5">
                        <span>Cek Data PTK</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <button id="mobileMenuToggle"
                class="xl:hidden text-white hover:text-blue-200 focus:outline-none p-2 rounded-lg bg-white/10 border border-white/20 transition">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Drawer -->
<div id="mobileSidebar"
    class="fixed inset-0 z-50 translate-x-full transition-transform duration-300 ease-in-out pointer-events-none">
    <!-- Backdrop -->
    <div id="mobileSidebarBackdrop"
        class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300 ease-in-out pointer-events-none">
    </div>

    <!-- Drawer Content -->
    <div
        class="absolute right-0 top-0 bottom-0 w-72 bg-blue-950 text-white shadow-2xl flex flex-col justify-between p-6 pointer-events-auto border-l border-blue-800/40">
        <div class="space-y-8">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-8 h-8 object-contain">
                    <div>
                        <h2 class="font-extrabold text-sm leading-tight text-white">SIMPEG-SP</h2>
                        <p class="text-[9px] uppercase tracking-wider text-blue-200/80 font-semibold">Dinas Pendidikan
                        </p>
                    </div>
                </div>
                <button id="mobileSidebarClose"
                    class="text-white hover:text-blue-200 focus:outline-none p-1.5 rounded-lg bg-white/10 border border-white/20 transition">
                    <i class="fas fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-4 text-sm font-semibold text-blue-100/90">
                <a href="{{ url('/') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-white/10 hover:text-white transition {{ (Request::is('/') || Request::is('landing')) && !Request::is('statistik*') && !Request::is('layanan*') && !Request::is('cek-ptk*') && !Request::is('pengumuman*') ? 'bg-white/15 text-white font-bold' : '' }}">
                    <i class="fas fa-house text-xs w-5"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ url('/statistik') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-white/10 hover:text-white transition {{ Request::is('statistik*') || Request::is('landing/statistik*') ? 'bg-white/15 text-white font-bold' : '' }}">
                    <i class="fas fa-chart-pie text-xs w-5"></i>
                    <span>Statistik Data</span>
                </a>
                <a href="{{ url('/layanan') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-white/10 hover:text-white transition {{ Request::is('layanan*') || Request::is('landing/layanan*') ? 'bg-white/15 text-white font-bold' : '' }}">
                    <i class="fas fa-layer-group text-xs w-5"></i>
                    <span>Layanan & Keunggulan</span>
                </a>
                <a href="{{ url('/cek-ptk') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-white/10 hover:text-white transition {{ Request::is('cek-ptk*') || Request::is('landing/cek-ptk*') ? 'bg-white/15 text-white font-bold' : '' }}">
                    <i class="fas fa-magnifying-glass text-xs w-5"></i>
                    <span>Cek Data PTK</span>
                </a>
                <a href="{{ url('/pengumuman') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-white/10 hover:text-white transition {{ Request::is('pengumuman*') || Request::is('landing/pengumuman*') ? 'bg-white/15 text-white font-bold' : '' }}">
                    <i class="fas fa-bullhorn text-xs w-5"></i>
                    <span>Pengumuman</span>
                </a>
            </nav>
        </div>

        <!-- Footer / CTA Buttons -->
        <div class="space-y-3 pt-6 border-t border-blue-900">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs py-3 rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span>Buka Dashboard</span>
                </a>
            @else
                <a href="{{ url('/login') }}"
                    class="w-full bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs py-3 rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-right-to-bracket text-xs"></i>
                    <span>Login Portal</span>
                </a>
                <a href="{{ url('/cek-ptk') }}"
                    class="w-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                    <i class="fas fa-search text-xs"></i>
                    <span>Cek Data PTK</span>
                </a>
            @endauth
            <div class="text-center text-[10px] text-blue-300/50 pt-2">
                &copy; 2026 SIMPEG-SP
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobileMenuToggle');
        const closeBtn = document.getElementById('mobileSidebarClose');
        const sidebar = document.getElementById('mobileSidebar');
        const backdrop = document.getElementById('mobileSidebarBackdrop');

        function openSidebar() {
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.remove('pointer-events-none');
            backdrop.classList.remove('pointer-events-none', 'opacity-0');
            backdrop.classList.add('opacity-100');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('translate-x-full');
            sidebar.classList.add('pointer-events-none');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }

        if (toggleBtn && closeBtn && sidebar && backdrop) {
            toggleBtn.addEventListener('click', openSidebar);
            closeBtn.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);
        }
    });
</script>