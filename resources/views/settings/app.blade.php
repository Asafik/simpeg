@extends('layouts.app')

@section('title', 'Pengaturan Sistem - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Pengaturan Sistem (Logo, Favicon & Tema)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Konfigurasi nama aplikasi, identitas instansi, logo, icon browser favicon, serta skema warna tema utama (termasuk Dark Mode).
                </p>
            </div>
            <button class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-save text-xs"></i>
                <span>Simpan Pengaturan Sistem</span>
            </button>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-sliders"></i> Informasi Aplikasi & Identity
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Nama Aplikasi System</label>
                    <input type="text" value="SIMPEG-SP" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Deskripsi / Subtitle Instansi</label>
                    <input type="text" value="Sistem Informasi Manajemen Pegawai Satuan Pendidikan" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
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
                        <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                            Ganti Logo
                            <input type="file" class="hidden" accept=".svg,.png">
                        </label>
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
                        <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                            Ganti Favicon
                            <input type="file" class="hidden" accept=".ico,.svg,.png">
                        </label>
                    </div>
                </div>

            </div>

            <!-- PILIHAN TEMA WARNA SYSTEM -->
            <div class="border-t border-gray-100 pt-5 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700">Pilihan Tema Warna Utama System (Theme Palette)</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <!-- Theme 1: Hope Deep Blue (Default) -->
                    <label class="border-2 border-blue-800 rounded-xl p-4 cursor-pointer bg-blue-50/30 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950"></div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Hope Deep Blue</p>
                                <p class="text-[10px] text-gray-400">Default Navy</p>
                            </div>
                        </div>
                        <input type="radio" name="system_theme" value="deep_blue" checked class="text-blue-800 focus:ring-blue-800 w-4 h-4">
                    </label>

                    <!-- Theme 2: Emerald Education -->
                    <label class="border border-gray-200 hover:border-emerald-600 rounded-xl p-4 cursor-pointer bg-gray-50/50 flex items-center justify-between transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-900 to-teal-800"></div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Emerald Education</p>
                                <p class="text-[10px] text-gray-400">Hijau Zamrud</p>
                            </div>
                        </div>
                        <input type="radio" name="system_theme" value="emerald" class="text-emerald-600 focus:ring-emerald-600 w-4 h-4">
                    </label>

                    <!-- Theme 3: Royal Purple -->
                    <label class="border border-gray-200 hover:border-purple-600 rounded-xl p-4 cursor-pointer bg-gray-50/50 flex items-center justify-between transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-950 to-indigo-900"></div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Royal Purple</p>
                                <p class="text-[10px] text-gray-400">Ungu Modern</p>
                            </div>
                        </div>
                        <input type="radio" name="system_theme" value="purple" class="text-purple-600 focus:ring-purple-600 w-4 h-4">
                    </label>

                    <!-- Theme 4: Dark Mode (Midnight Slate) -->
                    <label class="border border-gray-200 hover:border-blue-500 rounded-xl p-4 cursor-pointer bg-gray-900 text-white flex items-center justify-between transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 border border-slate-700 flex items-center justify-center text-xs">
                                <i class="fas fa-moon text-yellow-400"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Dark Mode</p>
                                <p class="text-[10px] text-slate-400">Midnight Slate</p>
                            </div>
                        </div>
                        <input type="radio" name="system_theme" value="dark" class="text-blue-500 focus:ring-blue-500 w-4 h-4">
                    </label>

                </div>
            </div>
        </div>

    </div>

    <!-- Live Theme Switcher Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = localStorage.getItem('simpegTheme') || 'deep_blue';
            const themeRadios = document.querySelectorAll('input[name="system_theme"]');
            
            themeRadios.forEach(radio => {
                if (radio.value === currentTheme) {
                    radio.checked = true;
                }
                
                radio.addEventListener('change', function() {
                    const selectedTheme = this.value;
                    localStorage.setItem('simpegTheme', selectedTheme);
                    document.documentElement.setAttribute('data-theme', selectedTheme);
                });
            });
        });
    </script>
@endsection
