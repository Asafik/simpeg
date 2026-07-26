@extends('layouts.app')

@section('title', 'Layanan & Keunggulan - SIMPEG-SP Dinas Pendidikan')

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
                <i class="fas fa-layer-group text-xs text-blue-300"></i> Sistem Manajemen Terpadu
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">Layanan &amp; Keunggulan Sistem</h1>
            <p class="text-sm md:text-base text-blue-100/90 max-w-2xl font-normal leading-relaxed">
                Fitur unggulan SIMPEG-SP yang dirancang untuk mendukung transformasi digital tata kelola kepegawaian di seluruh Satuan Pendidikan.
            </p>
        </div>
    </div>

    <!-- ===== LAYANAN DETAIL CONTENT ===== -->
    <main class="w-full px-6 md:px-12 py-16 space-y-16">
        
        <!-- Feature 1 Detailed Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-sitemap"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Pemetaan 7 Kriteria Utama Kepegawaian</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem secara otomatis mengelompokkan pegawai berdasarkan 7 kriteria utama: PNS, PPPK Penuh Waktu, PPPK Paruh Waktu, CPNS, Honorer K2, Non-ASN Daerah, dan Tenaga Pendukung. Setiap kriteria memiliki indikator pemantauan hak dan verifikasi berkas secara khusus.
                </p>
                <ul class="space-y-2 text-xs font-semibold text-gray-700">
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Integrasi Nomor Induk Pegawai &amp; NIK otomatis</li>
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Pemetaan unit kerja per Satuan Pendidikan</li>
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Laporan rekapitulasi kepegawaian siap cetak</li>
                </ul>
            </div>
            <div class="bg-gray-100 rounded-3xl p-8 border border-gray-200 text-center space-y-4">
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500">Kualifikasi PTK</span>
                        <span class="text-xs font-bold text-blue-800 bg-blue-100 px-2 py-0.5 rounded">Aktif</span>
                    </div>
                    <div class="text-left space-y-2">
                        <div class="p-3 rounded-xl bg-blue-50 border border-blue-200 text-xs font-bold text-blue-900 flex justify-between">
                            <span>1. Pegawai Negeri Sipil (PNS)</span>
                            <span>58%</span>
                        </div>
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-900 flex justify-between">
                            <span>2. PPPK Penuh Waktu</span>
                            <span>24%</span>
                        </div>
                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs font-bold text-amber-900 flex justify-between">
                            <span>3. PPPK Paruh Waktu</span>
                            <span>10%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        <!-- Feature 2 Detailed Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1 bg-gray-100 rounded-3xl p-8 border border-gray-200 space-y-4">
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200/80 space-y-3">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                        <i class="fas fa-certificate text-emerald-600 text-xl"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Validasi Digital Serdik</h4>
                            <p class="text-[10px] text-gray-400">Verifikasi Dokumen Pendidik</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Status Verifikasi:</span>
                            <span class="font-bold text-emerald-600">VERIFIKASI VALID</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Bidang Studi:</span>
                            <span class="font-bold text-gray-800">Guru Kelas SD</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Tahun Sertifikasi:</span>
                            <span class="font-bold text-gray-800">2024</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 md:order-2 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-file-circle-check"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Verifikasi Berkas Digital &amp; Sertifikasi</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Menghilangkan kerumitan pengumpulan berkas fisik. Seluruh dokumen SK Kenaikan Pangkat, SK Jabatan, Ijazah Terakhir, serta Sertifikat Pendidik (Serdik) diunggah dan diverifikasi secara online oleh tim validator Dinas Pendidikan.
                </p>
                <ul class="space-y-2 text-xs font-semibold text-gray-700">
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Pratinjau dokumen PDF digital cepat</li>
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Catatan verifikasi langsung ke Operator Sekolah</li>
                    <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-500"></i> Riwayat perubahan dokumen tersimpan rapi</li>
                </ul>
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
