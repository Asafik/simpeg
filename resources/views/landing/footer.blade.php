<!-- Official System Theme Footer (Modular Landing Component) -->
<footer class="bg-blue-950 text-white mt-auto border-t border-blue-900">
    <div class="px-6 md:px-16 py-12 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-xs">

        <div class="space-y-3 md:col-span-2">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-9 h-9 object-contain">
                <div>
                    <h2 class="font-bold text-base text-white">GTK</h2>
                    <p class="text-[10px] uppercase text-blue-300 font-medium">Dinas Pendidikan</p>
                </div>
            </div>
            <p class="text-blue-200/80 leading-relaxed max-w-md">
                Sistem Informasi Manajemen Pegawai Satuan Pendidikan — Platform pemusatan data kepegawaian resmi Dinas
                Pendidikan.
            </p>
        </div>

        <div class="space-y-3">
            <h3 class="font-bold text-sm text-white">Tautan Cepat</h3>
            <ul class="space-y-2 text-blue-200/80">
                <li><a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a></li>
                <li><a href="{{ url('/statistik') }}" class="hover:text-white transition">Statistik Data</a></li>
                <li><a href="{{ url('/layanan') }}" class="hover:text-white transition">Layanan & Keunggulan</a></li>
                <li><a href="{{ url('/cek-ptk') }}" class="hover:text-white transition">Cek Data PTK</a></li>
                <li><a href="{{ url('/pengumuman') }}" class="hover:text-white transition">Pengumuman</a></li>
                <li><a href="{{ url('/login') }}" class="hover:text-white transition">Portal Login Admin</a></li>
            </ul>
        </div>

        <div class="space-y-3">
            <h3 class="font-bold text-sm text-white">Kontak Dinas</h3>
            <ul class="space-y-2 text-blue-200/80">
                <li><i class="fas fa-location-dot mr-2"></i> Jl. Pendidikan No. 45, Kota Pusat</li>
                <li><i class="fas fa-envelope mr-2"></i> info@dinas.go.id</li>
                <li><i class="fas fa-phone mr-2"></i> (021) 555-0192</li>
            </ul>
        </div>

    </div>

    <div class="px-6 md:px-16 py-4 border-t border-blue-900/60 text-center text-xs text-blue-300/60">
        &copy; 2026 <span class="font-bold text-blue-200">SIMPEG-SP</span> — Dinas Pendidikan. All rights reserved.
    </div>
</footer>