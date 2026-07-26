@extends('layouts.app')

@section('title', 'Pengumuman & Berita Kepegawaian - SIMPEG-SP Dinas Pendidikan')

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
                <i class="fas fa-bullhorn text-xs text-blue-300"></i> Pusat Informasi Resmi
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">Pengumuman &amp; Berita Kepegawaian</h1>
            <p class="text-sm md:text-base text-blue-100/90 max-w-2xl font-normal leading-relaxed">
                Informasi resmi seputar edaran verifikasi berkas, pemutakhiran sertifikasi pendidik, dan kebijakan Dinas Pendidikan.
            </p>
        </div>
    </div>

    <!-- ===== PENGUMUMAN LIST CONTENT ===== -->
    <main class="w-full px-6 md:px-12 py-16 space-y-10">
        
        <!-- Filter Tabs & Search Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 pb-4">
            <div class="flex items-center gap-2 text-xs font-bold">
                <button class="px-4 py-2 rounded-xl bg-blue-800 text-white shadow-sm">Semua Kategori</button>
                <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Verifikasi Berkas</button>
                <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Sertifikasi Pendidik</button>
                <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Kebijakan Dinas</button>
            </div>

            <div class="relative w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Cari pengumuman..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-8 pr-3 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
            </div>
        </div>

        <!-- Announcements Grid List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between text-xs">
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-[10px]">VERIFIKASI BERKAS</span>
                    <span class="text-gray-400 font-medium">25 Juli 2026</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 hover:text-blue-800 cursor-pointer transition">
                    Jadwal Verifikasi Berkas Kepegawaian Tahap II Tahun 2026
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Dinas Pendidikan membuka tahap verifikasi ulang berkas SK Kepegawaian bagi seluruh pegawai Non-ASN dan PPPK Paruh Waktu.
                </p>
                <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-800 hover:underline">
                    <span>Baca Selengkapnya</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between text-xs">
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">SERTIFIKASI PENDIDIK</span>
                    <span class="text-gray-400 font-medium">20 Juli 2026</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 hover:text-blue-800 cursor-pointer transition">
                    Pemutakhiran Data Sertifikasi Pendidik (Serdik) Guru SD &amp; SMP
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Himbauan kepada Operator Sekolah untuk memperbarui data sertifikasi guru di portal SIMPEG-SP sebelum batas waktu berakhir.
                </p>
                <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-800 hover:underline">
                    <span>Baca Selengkapnya</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between text-xs">
                    <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-bold text-[10px]">KEBIJAKAN DINAS</span>
                    <span class="text-gray-400 font-medium">15 Juli 2026</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 hover:text-blue-800 cursor-pointer transition">
                    Edaran Sistem Informasi Kepegawaian Satuan Pendidikan 2026
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Instruksi Kepala Dinas Pendidikan mengenai penggunaan resmi platform SIMPEG-SP untuk seluruh Kepala Sekolah dan Operator.
                </p>
                <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-800 hover:underline">
                    <span>Baca Selengkapnya</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
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
