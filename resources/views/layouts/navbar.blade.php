<!-- ===== TOPBAR (Mentok Atas & Full Width) ===== -->
<header class="bg-white border-b border-gray-200/80 px-4 md:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-30">
    <div class="flex items-center gap-3">
        <!-- Mobile Toggle -->
        <button class="md:hidden text-gray-700 text-xl w-9 h-9 rounded-lg hover:bg-gray-100 flex items-center justify-center transition" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Search Box -->
        <div class="relative">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" placeholder="Search..." class="bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-9 pr-4 py-2 w-40 sm:w-60 md:w-72 focus:outline-none focus:ring-2 focus:ring-blue-800/20 transition">
        </div>
    </div>

    <!-- Right Controls & User Profile Dropdown -->
    <div class="flex items-center gap-3">
        <!-- Notification Bell -->
        <button class="relative w-9 h-9 rounded-lg bg-gray-50 border border-gray-200/80 hover:bg-gray-100 transition flex items-center justify-center text-gray-600">
            <i class="far fa-bell text-sm"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- Envelope / Messages -->
        <button class="w-9 h-9 rounded-lg bg-gray-50 border border-gray-200/80 hover:bg-gray-100 transition flex items-center justify-center text-gray-600">
            <i class="far fa-envelope text-sm"></i>
        </button>

        <!-- User Profile Dropdown Toggle Area (No Chevron) -->
        <div class="relative pl-2 border-l border-gray-200">
            <button type="button" id="userDropdownBtn" class="flex items-center gap-2.5 hover:opacity-80 transition cursor-pointer focus:outline-none">
                <div class="w-9 h-9 rounded-full bg-blue-800 text-white font-bold flex items-center justify-center text-xs shadow-sm flex-shrink-0">
                    AD
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-gray-800 leading-tight">Admin Dinas</p>
                    <p class="text-[10px] text-gray-400">Administrator Dinas</p>
                </div>
            </button>

            <!-- Dropdown Menu Content -->
            <div id="userDropdownMenu" class="hidden absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 transition-all duration-200">
                <!-- User Header Summary -->
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                    <p class="text-xs font-bold text-gray-900">Administrator Dinas</p>
                    <p class="text-[10px] text-gray-400 font-medium truncate">admin@dinas.go.id</p>
                    <span class="inline-block mt-1.5 px-2 py-0.5 bg-blue-100 text-blue-800 font-bold text-[9px] rounded-full">ADMIN DINAS</span>
                </div>

                <!-- Dropdown Links -->
                <div class="py-1 text-xs">
                    <a href="{{ url('/settings') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-gray-700 hover:bg-blue-50/50 hover:text-blue-800 transition">
                        <i class="fas fa-user-gear text-gray-400 text-xs"></i>
                        <span class="font-medium">Pengaturan Akun</span>
                    </a>
                    <a href="{{ url('/users') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-gray-700 hover:bg-blue-50/50 hover:text-blue-800 transition">
                        <i class="fas fa-users-gear text-gray-400 text-xs"></i>
                        <span class="font-medium">Manajemen User</span>
                    </a>
                </div>

                <!-- Logout Button Form -->
                <div class="border-t border-gray-100 pt-1 mt-1">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition text-left">
                            <i class="fas fa-arrow-right-from-bracket text-red-500"></i>
                            <span>Keluar (Logout)</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
