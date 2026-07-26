<!-- Dynamic Scroll Sticky Navbar (Modular Landing Component) -->
<header id="landingNavbar" class="w-full fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent py-5">
    <div class="w-full px-6 md:px-12 flex items-center justify-between">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-200">
            <div>
                <h1 class="font-extrabold text-lg leading-tight text-white tracking-tight">SIMPEG-SP</h1>
                <p class="text-[10px] uppercase tracking-wider text-blue-200/80 font-semibold">Dinas Pendidikan</p>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-blue-100/90">
            <a href="{{ url('/') }}" class="{{ (Request::is('/') || Request::is('landing')) ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Beranda
            </a>
            <a href="{{ url('/statistik') }}" class="{{ Request::is('statistik*') || Request::is('landing/statistik*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Statistik Data
            </a>
            <a href="{{ url('/layanan') }}" class="{{ Request::is('layanan*') || Request::is('landing/layanan*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Layanan & Keunggulan
            </a>
            <a href="{{ url('/cek-ptk') }}" class="{{ Request::is('cek-ptk*') || Request::is('landing/cek-ptk*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Cek Data PTK
            </a>
            <a href="{{ url('/pengumuman') }}" class="{{ Request::is('pengumuman*') || Request::is('landing/pengumuman*') ? 'text-white font-bold border-b-2 border-white pb-1' : 'hover:text-white transition' }}">
                Pengumuman
            </a>
        </nav>

        <!-- CTA Buttons (Official System Palette) -->
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span>Buka Dashboard</span>
                </a>
            @else
                <a href="{{ url('/login') }}" class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-right-to-bracket text-xs"></i>
                    <span>Login</span>
                </a>
                <a href="{{ url('/cek-ptk') }}" class="hidden sm:flex bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition items-center gap-1.5">
                    <span>Cek Data PTK</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            @endauth
        </div>
    </div>
</header>
