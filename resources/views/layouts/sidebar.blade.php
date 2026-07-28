<!-- ===== SIDEBAR ===== -->
<aside class="fixed top-0 left-0 h-full w-[270px] bg-white text-gray-800 border-r border-gray-200/80 shadow-sm z-50
               transform -translate-x-full md:translate-x-0 transition-all duration-300
               sidebar-scroll flex flex-col group"
       id="sidebar">

    <!-- Floating Edge Toggle Button (Hope UI Desktop Sidebar Collapse Arrow) -->
    <button id="sidebarToggleBtn"
            type="button"
            class="hidden md:flex absolute -right-3.5 top-6 w-7 h-7 rounded-full bg-blue-800 text-white items-center justify-center shadow-md shadow-blue-900/30 border-2 border-white hover:bg-blue-900 transition-all duration-300 z-50 cursor-pointer"
            title="Toggle Sidebar">
        <i class="fas fa-chevron-left text-[10px] transition-transform duration-300" id="sidebarToggleIcon"></i>
    </button>

    <!-- Brand -->
    <div class="px-6 py-6 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3 brand-container">
            <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain flex-shrink-0">
            <div class="sidebar-text transition-opacity duration-200">
                <h1 class="font-bold text-lg leading-tight text-gray-900">SIMPEG-SP</h1>
                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium">Dinas Pendidikan</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-4 sidebar-text">Main Menu</p>
        @if(Auth::check() && method_exists(Auth::user(), 'isOperatorSekolah') && Auth::user()->isOperatorSekolah())
            <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('operator/dashboard*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Dashboard Operator">
                <i class="fas fa-chart-pie w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Dashboard</span>
            </a>
            <a href="{{ route('operator.pegawai.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('operator/pegawai*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Data Pegawai">
                <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Data Pegawai</span>
            </a>
            <a href="{{ route('operator.sekolah.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('operator/sekolah*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Profil Sekolah">
                <i class="fas fa-school w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Profil Sekolah</span>
            </a>
            <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('operator/verifikasi*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Verifikasi Berkas">
                <i class="fas fa-check-circle w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Verifikasi Berkas</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('dashboard*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Dashboard">
                <i class="fas fa-chart-pie w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Dashboard</span>
            </a>
            <a href="{{ url('/pegawai') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('pegawai*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Data Pegawai">
                <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Data Pegawai</span>
            </a>
            @if(Auth::user() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas())
                <a href="{{ url('/sekolah') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('sekolah*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Kelola Sekolah">
                    <i class="fas fa-school w-5 text-center flex-shrink-0"></i>
                    <span class="font-medium text-sm sidebar-text">Kelola Sekolah</span>
                </a>
            @endif
            <a href="{{ url('/verifikasi') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('verifikasi*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Verifikasi Data">
                <i class="fas fa-check-circle w-5 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm sidebar-text">Verifikasi Data</span>
            </a>
        @endif
        </a>

        <!-- Publik Section -->
        <div class="mt-4 pt-4 border-t border-gray-100 space-y-1">
            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-2 sidebar-text">Publik</p>

            @if(Auth::user() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas())
                <a href="{{ url('/pengumuman') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('pengumuman*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Pengumuman">
                    <i class="fas fa-bullhorn w-5 text-center flex-shrink-0"></i>
                    <span class="font-medium text-sm sidebar-text">Pengumuman</span>
                </a>
            @endif
        </div>

        <!-- System Settings Accordion Menu -->
        <div class="mt-4 pt-4 border-t border-gray-100 space-y-1">
            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-2 sidebar-text">Pengaturan</p>

            @if(Auth::user() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas())
                <a href="{{ url('/users') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('users*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition" title="Kelola User">
                    <i class="fas fa-user-gear w-5 text-center flex-shrink-0"></i>
                    <span class="font-medium text-sm sidebar-text">Kelola User</span>
                </a>
            @endif

            <div class="relative">
                <button type="button"
                        id="settingMenuBtn"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg {{ Request::is('settings*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} transition cursor-pointer">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-sliders w-5 text-center flex-shrink-0"></i>
                        <span class="font-medium text-sm sidebar-text">Pengaturan Sistem</span>
                    </div>
                    <i class="fas fa-arrow-right text-[10px] transition-transform duration-300 {{ Request::is('settings*') ? 'rotate-90' : '' }} sidebar-text" id="settingArrow"></i>
                </button>

                <!-- Accordion Submenu Links (With Smooth Slide-down Animation) -->
                <div id="settingSubmenu" class="sidebar-accordion-submenu {{ Request::is('settings*') ? 'accordion-expanded' : '' }} pl-9 pr-2 py-2 space-y-1">
                    <a href="{{ route('settings.profile') }}"
                       class="block px-3 py-2 rounded-md text-xs font-semibold {{ Request::is('settings/profile') ? 'text-blue-800 bg-blue-50' : 'text-gray-500 hover:text-blue-800 hover:bg-gray-50' }} transition">
                        <i class="fas fa-arrow-right text-[10px] mr-2"></i> Profile Saya
                    </a>
                    <a href="{{ route('settings.app') }}"
                       class="block px-3 py-2 rounded-md text-xs font-semibold {{ Request::is('settings/app') ? 'text-blue-800 bg-blue-50' : 'text-gray-500 hover:text-blue-800 hover:bg-gray-50' }} transition">
                        <i class="fas fa-arrow-right text-[10px] mr-2"></i> Pengaturan Aplikasi
                    </a>
                    <a href="{{ route('settings.logs') }}"
                       class="block px-3 py-2 rounded-md text-xs font-semibold {{ Request::is('settings/logs') ? 'text-blue-800 bg-blue-50' : 'text-gray-500 hover:text-blue-800 hover:bg-gray-50' }} transition">
                        <i class="fas fa-arrow-right text-[10px] mr-2"></i> Log Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Section -->
    <div class="p-4 border-t border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3 px-2">
            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin Dinas') . '&background=1e40af&color=fff' }}" alt="User Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
            <div class="flex-1 min-w-0 sidebar-text">
                <p class="font-bold text-xs text-gray-900 truncate">{{ Auth::user()->name ?? 'Administrator Dinas' }}</p>
                <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email ?? 'admin@dinas.go.id' }}</p>
            </div>
            <a href="{{ route('logout') }}" class="text-gray-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition sidebar-text" title="Keluar">
                <i class="fas fa-right-from-bracket text-xs"></i>
            </a>
        </div>
    </div>
</aside>
