<!-- ===== SIDEBAR ===== -->
<aside class="fixed top-0 left-0 h-full w-[270px] bg-white text-gray-800 border-r border-gray-200/80 shadow-sm z-50 
               transform -translate-x-full md:translate-x-0 transition-all duration-300 
               sidebar-scroll flex flex-col group" id="sidebar">

    <!-- Floating Edge Toggle Button (Hope UI Desktop Sidebar Collapse Arrow) -->
    <button id="sidebarToggleBtn" type="button"
        class="hidden md:flex absolute -right-3.5 top-6 w-7 h-7 rounded-full bg-blue-800 text-white items-center justify-center shadow-md shadow-blue-900/30 border-2 border-white hover:bg-blue-900 transition-all duration-300 z-50 cursor-pointer"
        title="Toggle Sidebar">
        <i class="fas fa-chevron-left text-[10px] transition-transform duration-300" id="sidebarToggleIcon"></i>
    </button>

    <!-- Brand -->
    <div class="px-6 py-6 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3 brand-container">
            <img src="{{ asset('logo/logo.svg') }}" alt="GTK Logo" class="w-10 h-10 object-contain flex-shrink-0">
            <div class="sidebar-text transition-opacity duration-200">
                <h1 class="font-bold text-lg leading-tight text-gray-900">GTK</h1>
                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium">Dinas Pendidikan</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-4 sidebar-text">Main Menu</p>

        <a href="{{ url('/') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('/') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition"
            title="Dashboard">
            <i class="fas fa-chart-pie w-5 text-center flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Dashboard</span>
        </a>
        <a href="{{ url('/pegawai') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('pegawai*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition"
            title="Data Pegawai">
            <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Data Pegawai</span>
        </a>
        <a href="{{ url('/sekolah') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('sekolah*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition"
            title="Kelola Sekolah">
            <i class="fas fa-school w-5 text-center flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Kelola Sekolah</span>
        </a>
        <a href="{{ url('/verifikasi') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('verifikasi*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition"
            title="Verifikasi Data">
            <i class="fas fa-check-circle w-5 text-center flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Verifikasi Data</span>
            <span
                class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full sidebar-text">12</span>
        </a>

        <!-- MANAJEMEN SECTION -->
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mt-8 mb-4 sidebar-text">
            Manajemen</p>

        <a href="{{ url('/users') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('users*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition"
            title="Manajemen User">
            <i class="fas fa-user-shield w-5 text-center flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Manajemen User</span>
        </a>

        <!-- Setting System Submenu Dropdown Parent -->
        <div class="mb-1">
            <button type="button" id="settingSubmenuToggleBtn"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg {{ Request::is('settings*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} transition cursor-pointer"
                title="Setting System">
                <div class="flex items-center gap-3">
                    <i class="fas fa-cog w-5 text-center flex-shrink-0"></i>
                    <span class="font-medium text-sm sidebar-text">Setting System</span>
                </div>
                <i class="fas fa-arrow-down text-[10px] transition-transform duration-300 sidebar-text {{ Request::is('settings*') ? 'rotate-180' : '' }}"
                    id="settingSubmenuArrow"></i>
            </button>

            <!-- Nested Submenu Children with Slide-Down Animation & Real Arrow Indicators (fa-arrow-right) -->
            <div id="settingSubmenuList"
                class="{{ Request::is('settings*') ? 'open-submenu' : 'hidden-submenu' }} pl-9 pr-2 space-y-1">
                <a href="{{ url('/settings/profile') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold {{ Request::is('settings/profile') ? 'bg-blue-100 text-blue-800 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} transition">
                    <i class="fas fa-arrow-right text-[10px] opacity-70"></i>
                    <span class="sidebar-text">Profil Pengguna</span>
                </a>
                <a href="{{ url('/settings/app') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold {{ (Request::is('settings/app') || Request::is('settings')) ? 'bg-blue-100 text-blue-800 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} transition">
                    <i class="fas fa-arrow-right text-[10px] opacity-70"></i>
                    <span class="sidebar-text">Pengaturan Sistem</span>
                </a>
                <a href="{{ url('/settings/logs') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold {{ Request::is('settings/logs') ? 'bg-blue-100 text-blue-800 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} transition">
                    <i class="fas fa-arrow-right text-[10px] opacity-70"></i>
                    <span class="sidebar-text">Log Aktivitas</span>
                </a>
            </div>
        </div>

        <!-- LAPORAN SECTION -->
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mt-8 mb-4 sidebar-text">Laporan
        </p>

        <a href="#"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-blue-800 transition mb-1"
            title="Export Excel">
            <i class="fas fa-file-excel w-5 text-center text-green-500 flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Export Excel</span>
        </a>
        <a href="#"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-blue-800 transition mb-1"
            title="Export PDF">
            <i class="fas fa-file-pdf w-5 text-center text-red-500 flex-shrink-0"></i>
            <span class="font-medium text-sm sidebar-text">Export PDF</span>
        </a>
    </nav>

    <!-- User Footer -->
    <div class="px-4 py-5 border-t border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3 user-footer-container">
            <div
                class="w-9 h-9 rounded-full bg-blue-900/10 text-blue-800 border border-blue-900/20 flex items-center justify-center font-semibold text-sm flex-shrink-0">
                AD
            </div>
            <div class="flex-1 sidebar-text">
                <p class="font-semibold text-sm text-gray-800">Admin Dinas</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="sidebar-text">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition cursor-pointer" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>