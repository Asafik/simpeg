<!-- ===== SIDEBAR ===== -->
<aside class="fixed top-0 left-0 h-full w-[270px] bg-white text-gray-800 border-r border-gray-200/80 shadow-sm z-50 
               transform -translate-x-full md:translate-x-0 transition-transform duration-300 
               sidebar-scroll overflow-y-auto flex flex-col"
       id="sidebar">
    
    <!-- Brand -->
    <div class="px-6 py-6 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain flex-shrink-0">
            <div>
                <h1 class="font-bold text-lg leading-tight text-gray-900">SIMPEG-SP</h1>
                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium">Dinas Pendidikan</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-4">Main Menu</p>
        
        <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('/') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition">
            <i class="fas fa-chart-pie w-5 text-center"></i>
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        <a href="{{ url('/pegawai') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('pegawai*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition">
            <i class="fas fa-users w-5 text-center"></i>
            <span class="font-medium text-sm">Data Pegawai</span>
        </a>
        <a href="{{ url('/sekolah') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('sekolah*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition">
            <i class="fas fa-school w-5 text-center"></i>
            <span class="font-medium text-sm">Kelola Sekolah</span>
        </a>
        <a href="{{ url('/verifikasi') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('verifikasi*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition">
            <i class="fas fa-check-circle w-5 text-center"></i>
            <span class="font-medium text-sm">Verifikasi Data</span>
            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">12</span>
        </a>
        <a href="{{ url('/users') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ Request::is('users*') ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }} mb-1 transition">
            <i class="fas fa-user-shield w-5 text-center"></i>
            <span class="font-medium text-sm">Manajemen User</span>
        </a>

        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mt-8 mb-4">Laporan</p>
        
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-blue-800 transition mb-1">
            <i class="fas fa-file-excel w-5 text-center text-green-500"></i>
            <span class="font-medium text-sm">Export Excel</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-blue-800 transition mb-1">
            <i class="fas fa-file-pdf w-5 text-center text-red-500"></i>
            <span class="font-medium text-sm">Export PDF</span>
        </a>
    </nav>

    <!-- User Footer -->
    <div class="px-4 py-5 border-t border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-blue-900/10 text-blue-800 border border-blue-900/20 flex items-center justify-center font-semibold text-sm">
                AD
            </div>
            <div class="flex-1">
                <p class="font-semibold text-sm text-gray-800">Admin Dinas</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
            <a href="{{ url('/login') }}" class="text-gray-400 hover:text-red-500 transition" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>
