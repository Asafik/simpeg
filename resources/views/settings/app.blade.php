@extends('layouts.app')

@section('title', 'Pengaturan Sistem - SIMPEG-SP')

@section('content')
    @php
        $isAdmin = Auth::user() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas();
    @endphp

    <!-- ===== HERO BLUE BANNER ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGrad1)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGrad2)"></path>
            <defs>
                <linearGradient id="hopeWaveGrad1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.55" />
                    <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.35" />
                </linearGradient>
                <linearGradient id="hopeWaveGrad2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#030712" stop-opacity="0.85" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>

        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Pengaturan Sistem (Logo, Favicon &amp; Tema)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Konfigurasi nama aplikasi, identitas instansi, logo, icon browser favicon, serta skema warna tema utama.
                </p>
            </div>
            @if($isAdmin)
                <button type="submit" form="appSettingsForm" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition cursor-pointer">
                    <i class="fas fa-save text-xs"></i>
                    <span>Simpan Pengaturan Sistem</span>
                </button>
            @else
                <span class="bg-white/15 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 backdrop-blur-md">
                    <i class="fas fa-lock text-xs"></i>
                    <span>Mode Pratinjau (Hanya Baca)</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">

        @if(!$isAdmin)
            <div class="bg-amber-50 border border-amber-200 text-amber-900 text-xs rounded-xl p-4 shadow-md flex items-center justify-between">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-lock text-amber-600 text-sm"></i>
                    <span>Anda berada dalam mode pratinjau. Hanya Admin Dinas Pendidikan yang berhak mengubah Pengaturan Aplikasi.</span>
                </div>
            </div>
        @endif

        <form id="appSettingsForm" action="{{ route('settings.app') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-sliders"></i> Informasi Aplikasi &amp; Identitas Instansi
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Aplikasi System</label>
                        <input type="text" name="app_name" value="SIMPEG-SP" {{ !$isAdmin ? 'disabled' : '' }}
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800 disabled:opacity-75 disabled:cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Deskripsi / Subtitle Instansi</label>
                        <input type="text" name="app_desc" value="Sistem Informasi Manajemen Pegawai Satuan Pendidikan" {{ !$isAdmin ? 'disabled' : '' }}
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800 disabled:opacity-75 disabled:cursor-not-allowed">
                    </div>
                </div>

                <!-- UPLOAD LOGO & FAVICON -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">

                    <!-- Upload Logo -->
                    <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-gray-800">Logo Aplikasi (SVG / PNG)</h4>
                            <span class="text-[10px] text-gray-400">Rekomendasi 512x512px</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-3 rounded-lg border border-gray-200">
                            <img src="{{ asset('logo/logo.svg') }}" alt="Logo App" class="w-12 h-12 object-contain">
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-800">logo.svg</p>
                                <p class="text-[10px] text-gray-400">public/logo/logo.svg</p>
                            </div>
                            @if($isAdmin)
                                <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                                    Ganti Logo
                                    <input type="file" name="logo" class="hidden" accept=".svg,.png">
                                </label>
                            @else
                                <span class="bg-gray-200 text-gray-500 text-xs font-semibold px-3 py-1.5 rounded-lg cursor-not-allowed">Hanya Baca</span>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Favicon -->
                    <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-gray-800">Favicon Browser Icon (.ico / .svg)</h4>
                            <span class="text-[10px] text-gray-400">Rekomendasi 32x32px</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-3 rounded-lg border border-gray-200">
                            <img src="{{ asset('logo/logo.svg') }}" alt="Favicon" class="w-8 h-8 object-contain">
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-800">favicon.ico</p>
                                <p class="text-[10px] text-gray-400">public/favicon.ico</p>
                            </div>
                            @if($isAdmin)
                                <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                                    Ganti Favicon
                                    <input type="file" name="favicon" class="hidden" accept=".ico,.svg,.png">
                                </label>
                            @else
                                <span class="bg-gray-200 text-gray-500 text-xs font-semibold px-3 py-1.5 rounded-lg cursor-not-allowed">Hanya Baca</span>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- PILIHAN TEMA (THEME SWITCHER) -->
                <div class="border-t border-gray-100 pt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                            <i class="fas fa-palette"></i> Personalisasi Tema Tampilan
                        </h3>
                        <span class="text-[10px] text-gray-400">Pilihan tema disimpan di browser Anda</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <!-- Deep Blue -->
                        <button type="button" onclick="changeTheme('deep_blue')" id="theme-btn-deep_blue" class="theme-card relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-blue-800 transition cursor-pointer bg-white">
                            <div class="w-10 h-10 rounded-full bg-blue-800 mb-2 flex items-center justify-center text-white">
                                <i class="fas fa-check opacity-0 theme-check"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-800">Deep Blue</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Default Biru</span>
                        </button>

                        <!-- Emerald Green -->
                        <button type="button" onclick="changeTheme('emerald')" id="theme-btn-emerald" class="theme-card relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-emerald-600 transition cursor-pointer bg-white">
                            <div class="w-10 h-10 rounded-full bg-emerald-700 mb-2 flex items-center justify-center text-white">
                                <i class="fas fa-check opacity-0 theme-check"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-800">Emerald Green</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Hijau Edukasi</span>
                        </button>

                        <!-- Royal Purple -->
                        <button type="button" onclick="changeTheme('purple')" id="theme-btn-purple" class="theme-card relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-600 transition cursor-pointer bg-white">
                            <div class="w-10 h-10 rounded-full bg-purple-700 mb-2 flex items-center justify-center text-white">
                                <i class="fas fa-check opacity-0 theme-check"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-800">Royal Purple</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Ungu Kerajaan</span>
                        </button>

                        <!-- Midnight Slate (Dark Mode) -->
                        <button type="button" onclick="changeTheme('dark')" id="theme-btn-dark" class="theme-card relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-slate-800 transition cursor-pointer bg-white">
                            <div class="w-10 h-10 rounded-full bg-slate-800 mb-2 flex items-center justify-center text-white">
                                <i class="fas fa-check opacity-0 theme-check"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-800">Midnight Slate</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Mode Gelap</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection

@push('scripts')
<script>
    // Function to change theme
    function changeTheme(themeName) {
        // Save to localStorage
        localStorage.setItem('simpegTheme', themeName);

        // Apply to document element
        document.documentElement.setAttribute('data-theme', themeName);

        // Update UI buttons state
        updateThemeUI(themeName);
    }

    // Function to update UI buttons state
    function updateThemeUI(activeTheme) {
        // Reset all buttons
        document.querySelectorAll('.theme-card').forEach(btn => {
            btn.classList.remove('border-blue-800', 'border-emerald-600', 'border-purple-600', 'border-slate-800', 'bg-blue-50/30');
            btn.classList.add('border-gray-200');
            btn.querySelector('.theme-check').classList.add('opacity-0');
        });

        // Set active button
        const activeBtn = document.getElementById('theme-btn-' + activeTheme);
        if (activeBtn) {
            activeBtn.classList.remove('border-gray-200');

            // Add specific border color based on theme
            if (activeTheme === 'deep_blue') {
                activeBtn.classList.add('border-blue-800', 'bg-blue-50/30');
            } else if (activeTheme === 'emerald') {
                activeBtn.classList.add('border-emerald-600', 'bg-emerald-50/30');
            } else if (activeTheme === 'purple') {
                activeBtn.classList.add('border-purple-600', 'bg-purple-50/30');
            } else if (activeTheme === 'dark') {
                activeBtn.classList.add('border-slate-800', 'bg-slate-50/30');
            }

            activeBtn.querySelector('.theme-check').classList.remove('opacity-0');
        }
    }

    // Initialize theme UI on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentTheme = localStorage.getItem('simpegTheme') || 'deep_blue';
        updateThemeUI(currentTheme);
    });
</script>
@endpush
