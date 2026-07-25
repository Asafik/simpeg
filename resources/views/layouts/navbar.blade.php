<!-- ===== TOPBAR (Mentok Atas & Full Width) ===== -->
<header class="bg-white border-b border-gray-200/80 px-4 md:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-40">
    <div class="flex items-center gap-3">
        <!-- Mobile Toggle -->
        <button class="md:hidden text-gray-700 text-xl w-9 h-9 rounded-lg hover:bg-gray-100 flex items-center justify-center transition" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Back Arrow Icon -->
        <button class="w-8 h-8 rounded-full bg-blue-800 text-white flex items-center justify-center hover:bg-blue-900 transition shadow-sm shadow-blue-900/20 text-xs">
            <i class="fas fa-arrow-left"></i>
        </button>
        <!-- Search Box -->
        <div class="relative">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" placeholder="Search..." class="bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-9 pr-4 py-2 w-40 sm:w-60 md:w-72 focus:outline-none focus:ring-2 focus:ring-blue-800/20 transition">
        </div>
    </div>

    <!-- Right Controls & User Profile -->
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

        <!-- User Profile Badge -->
        <div class="flex items-center gap-2.5 pl-2 border-l border-gray-200">
            <div class="w-9 h-9 rounded-full bg-blue-800 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                AD
            </div>
            <div class="hidden md:block text-left">
                <p class="text-xs font-bold text-gray-800 leading-tight">Admin Dinas</p>
                <p class="text-[10px] text-gray-400">Administrator Dinas</p>
            </div>
        </div>
    </div>
</header>
