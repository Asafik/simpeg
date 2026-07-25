@extends('layouts.app')

@section('title', 'Cek Data PTK - SIMPEG-SP Dinas Pendidikan')

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
                <i class="fas fa-magnifying-glass text-xs text-blue-300"></i> Pencarian Publik
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">Cek Status Verifikasi Data PTK</h1>
            <p class="text-sm md:text-base text-blue-100/90 max-w-2xl font-normal leading-relaxed">
                Verifikasi status keaktifan, kualifikasi 7 kriteria kepegawaian, dan kepemilikan Sertifikat Pendidik (Serdik) secara transparan.
            </p>
        </div>
    </div>

    <!-- ===== CEK PTK SEARCH CONTENT ===== -->
    <main class="max-w-4xl mx-auto px-6 md:px-12 py-16 space-y-10">
        
        <!-- Search Card Widget -->
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl p-8 space-y-6">
            <div class="space-y-2 text-center max-w-lg mx-auto">
                <h3 class="text-xl font-bold text-gray-900">Form Pencarian Data PTK</h3>
                <p class="text-xs text-gray-500">Masukkan 18 Digit NIP (Pegawai ASN) atau NIK / NUPTK untuk menampilkan rincian data kepegawaian.</p>
            </div>

            <form action="{{ url('/landing/cek-ptk') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Contoh NIP: 198503202010011005..." class="w-full bg-gray-50 border border-gray-300 text-xs text-gray-800 rounded-xl pl-10 pr-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-800/30 font-medium">
                </div>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold text-xs px-7 py-3.5 rounded-xl shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-magnifying-glass text-xs"></i>
                    <span>Cari Data PTK</span>
                </button>
            </form>
        </div>

        <!-- Verification Demo Result Card (Sample Data) -->
        <div class="bg-white rounded-3xl border border-gray-200/90 shadow-lg p-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-lg">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-base text-gray-900">Budi Santoso, S.Pd.</h4>
                        <p class="text-xs font-medium text-gray-500">NIP: 198503202010011005 • Guru Kelas SD</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center gap-1.5">
                    <i class="fas fa-check-circle text-xs"></i> DATA PTK TERVERIFIKASI
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-gray-50 space-y-1">
                    <span class="text-gray-400 font-medium">Satuan Pendidikan (Sekolah):</span>
                    <p class="font-bold text-gray-800">SD Negeri 01 Pusat Kota</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 space-y-1">
                    <span class="text-gray-400 font-medium">Status Kepegawaian (7 Kriteria):</span>
                    <p class="font-bold text-blue-800">Pegawai Negeri Sipil (PNS)</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 space-y-1">
                    <span class="text-gray-400 font-medium">Pangkat / Golongan Ruang:</span>
                    <p class="font-bold text-gray-800">Penata Muda Tk. I / III/b</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 space-y-1">
                    <span class="text-gray-400 font-medium">Status Sertifikasi Pendidik (Serdik):</span>
                    <p class="font-bold text-emerald-700">Bersertifikasi Pendidik (Aktif)</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 text-xs text-blue-900 flex items-center justify-between">
                <span class="font-medium">Data diperbarui secara otomatis dari SIMPEG-SP Dinas Pendidikan.</span>
                <span class="font-bold text-blue-800">25 Juli 2026</span>
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
