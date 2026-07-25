@extends('layouts.app')

@section('title', 'Statistik Data Kepegawaian - SIMPEG-SP Dinas Pendidikan')

@section('content')
    <!-- ===== UNIFIED HERO HEADER BLOCK (MATCHING HOMEPAGE BRANDING) ===== -->
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white relative overflow-hidden shadow-2xl">
        
        <!-- Hope UI Background Wave Gradient Overlay -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 600">
            <path d="M 200,600 C 360,320 520,60 750,0 L 1000,0 L 1000,600 Z" fill="url(#landingWaveGrad1)"></path>
            <path d="M 450,600 C 600,300 780,140 1000,30 L 1000,600 Z" fill="url(#landingWaveGrad2)"></path>
            <defs>
                <linearGradient id="landingWaveGrad1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.55" />
                    <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.35" />
                </linearGradient>
                <linearGradient id="landingWaveGrad2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#030712" stop-opacity="0.85" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Dynamic Header Navbar Partial -->
        @include('landing.navbarlanding')

        <div class="w-full px-6 md:px-12 pt-32 pb-20 relative z-10 space-y-4">
            <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200 bg-white/10 px-3.5 py-1.5 rounded-full border border-white/15 inline-flex items-center gap-2">
                <i class="fas fa-chart-pie text-xs text-blue-300"></i> Publikasi Data Terbuka
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">Statistik Data Kepegawaian</h1>
            <p class="text-sm md:text-base text-blue-100/90 max-w-2xl font-normal leading-relaxed">
                Rangkuman visual statistik pemetaan 7 kriteria kepegawaian, verifikasi Sertifikat Pendidik (Serdik), serta sebaran data PTK di 48 Satuan Pendidikan.
            </p>
        </div>
    </div>

    <!-- ===== STATISTIK DETAIL CONTENT ===== -->
    <main class="w-full px-6 md:px-12 py-12 space-y-10">
        
        <!-- Stat Key Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total PTK Terdaftar</p>
                <h3 class="text-3xl font-extrabold text-gray-900">1.284</h3>
                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                    <i class="fas fa-arrow-up text-[9px]"></i> +12% dibanding semester lalu
                </span>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pegawai Bersertifikasi</p>
                <h3 class="text-3xl font-extrabold text-gray-900">950</h3>
                <span class="text-[11px] text-blue-600 font-semibold">74% dari total guru</span>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status PNS / PPPK</p>
                <h3 class="text-3xl font-extrabold text-gray-900">820</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">63.8% Aparatur Negara</span>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Satuan Pendidikan</p>
                <h3 class="text-3xl font-extrabold text-gray-900">48</h3>
                <span class="text-[11px] text-gray-500 font-semibold">SD, SMP, & TK Negeri</span>
            </div>
        </div>

        <!-- Charts Breakdown Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Chart Card 1 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-base text-gray-900">Sebaran Kualifikasi 7 Kriteria</h3>
                    <span class="text-xs font-semibold text-blue-800 bg-blue-100 px-2.5 py-1 rounded-full">Real-time</span>
                </div>
                <div class="space-y-3 pt-2">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
                            <span>PNS (Pegawai Negeri Sipil)</span>
                            <span>58% (745 Pegawai)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-blue-800 h-3 rounded-full" style="width: 58%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
                            <span>PPPK (Penuh Waktu)</span>
                            <span>24% (308 Pegawai)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: 24%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
                            <span>PPPK Paruh Waktu</span>
                            <span>10% (128 Pegawai)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-amber-500 h-3 rounded-full" style="width: 10%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
                            <span>Non-ASN / Honorer</span>
                            <span>8% (103 Pegawai)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gray-400 h-3 rounded-full" style="width: 8%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Card 2 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-base text-gray-900">Status Verifikasi Berkas Digital</h3>
                    <span class="text-xs font-semibold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full">98.5% Tervalidasi</span>
                </div>
                <div class="space-y-4 pt-2">
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-emerald-900">Berkas SK Kepegawaian Valid</p>
                            <p class="text-[11px] text-emerald-700">Telah diverifikasi oleh Tim Dinas Pendidikan</p>
                        </div>
                        <span class="text-lg font-extrabold text-emerald-800">1.265</span>
                    </div>

                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-blue-900">Sertifikat Pendidik (Serdik) Valid</p>
                            <p class="text-[11px] text-blue-700">Terdaftar di PDDikti / Kemendikbud</p>
                        </div>
                        <span class="text-lg font-extrabold text-blue-800">950</span>
                    </div>

                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-amber-900">Proses Perbaikan Berkas</p>
                            <p class="text-[11px] text-amber-700">Menunggu perbaikan dokumen dari sekolah</p>
                        </div>
                        <span class="text-lg font-extrabold text-amber-800">19</span>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Modular Footer Component -->
    @include('landing.footer')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('scroll', function() {
                    const navbar = document.getElementById('landingNavbar');
                    if (window.scrollY > 20) {
                        navbar.classList.add('bg-blue-950/95', 'backdrop-blur-md', 'shadow-xl', 'py-3.5', 'border-b', 'border-blue-800/40');
                        navbar.classList.remove('bg-transparent', 'py-5');
                    } else {
                        navbar.classList.remove('bg-blue-950/95', 'backdrop-blur-md', 'shadow-xl', 'py-3.5', 'border-b', 'border-blue-800/40');
                        navbar.classList.add('bg-transparent', 'py-5');
                    }
                });
            });
        </script>
    @endpush
@endsection
