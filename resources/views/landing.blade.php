@extends('layouts.app')

@section('title', 'SIMPEG-SP - Pemusatan Data Kepegawaian Satuan Pendidikan Dinas Pendidikan')

@push('styles')
    <!-- ===== LANDING ANIMATION STYLES (SMOOTH & SLOWER TIMING) ===== -->
    <style>
        /* Entrance Animations for Hero Section (On Page Load) - Slower & Smoother (1.4s) */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-left {
            animation: fadeInLeft 1.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-right {
            animation: fadeInRight 1.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Scroll Reveal Animations for Sections Below Hero - Slower & Smoother (1.2s) */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-on-scroll.is-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        /* Staggered Delay Utilities */
        .delay-100 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 300ms; }
        .delay-300 { transition-delay: 450ms; }
    </style>
@endpush

@section('content')
    <!-- ===== UNIFIED FULL-SCREEN HERO HEADER BLOCK ===== -->
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white relative overflow-hidden min-h-screen flex flex-col justify-between shadow-2xl">

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

        <!-- 1. Sticky Dynamic Navbar (Official System Palette, 100% Mentok Kanan Kiri) -->
        <header id="landingNavbar" class="w-full fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent py-5">
            <div class="w-full px-6 md:px-12 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="{{ url('/landing') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-200">
                    <div>
                        <h1 class="font-extrabold text-lg leading-tight text-white tracking-tight">SIMPEG-SP</h1>
                        <p class="text-[10px] uppercase tracking-wider text-blue-200/80 font-semibold">Dinas Pendidikan</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-blue-100/90">
                    <a href="#beranda" class="hover:text-white transition">Beranda</a>
                    <a href="#statistik" class="hover:text-white transition">Statistik Data</a>
                    <a href="#layanan" class="hover:text-white transition">Layanan & Keunggulan</a>
                    <a href="#cek-ptk" class="hover:text-white transition">Cek Data PTK</a>
                    <a href="#pengumuman" class="hover:text-white transition">Pengumuman</a>
                </nav>

                <!-- CTA Buttons (Official System Palette) -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/') }}" class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                            <i class="fas fa-chart-pie text-xs"></i>
                            <span>Buka Dashboard</span>
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="bg-blue-800 hover:bg-blue-900 border border-blue-400/30 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                            <i class="fas fa-right-to-bracket text-xs"></i>
                            <span>Login</span>
                        </a>
                        <a href="#cek-ptk" class="hidden sm:flex bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition items-center gap-1.5">
                            <span>Cek Data PTK</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- 2. Hero Section Grid (Entrance Animations: Slower 1.4s Slide In) -->
        <section id="beranda" class="w-full px-6 md:px-12 pt-24 md:pt-32 pb-20 md:pb-28 relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center flex-1 my-auto">

            <!-- Left Text Column (Slides in Slower from Left - 1.4s) -->
            <div class="space-y-6 text-left animate-fade-left">
                <!-- Main Title Header -->
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-white">
                    Pemusatan Data Kepegawaian & Verifikasi Berkas Satuan Pendidikan
                </h1>

                <!-- Subtitle Description -->
                <p class="text-sm md:text-base text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                    Platform terpadu Dinas Pendidikan untuk pemetaan kualifikasi 7 kriteria utama kepegawaian (PNS, PPPK, PPPK Paruh Waktu, & Non-ASN) serta validasi digital Sertifikasi Pendidik (Serdik) secara real-time.
                </p>

                <!-- Action Buttons & Micro Highlights -->
                <div class="space-y-4 pt-2">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ url('/login') }}" class="bg-white text-blue-900 hover:bg-blue-50 font-extrabold text-xs px-7 py-3.5 rounded-xl shadow-xl transition flex items-center gap-2">
                            <span>Masuk Portal SIMPEG-SP</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="#cek-ptk" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-6 py-3.5 rounded-xl shadow-md transition flex items-center gap-2">
                            <i class="fas fa-search text-xs"></i>
                            <span>Cek Status Data PTK</span>
                        </a>
                    </div>

                    <!-- Micro Highlights Bar -->
                    <div class="flex flex-wrap items-center gap-6 pt-2 text-[11px] font-semibold text-blue-200/80">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> 48 Satuan Pendidikan
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> 1.284+ Data PTK Terdata
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> Monitoring Real-Time
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Illustration Column (Replaced with header.png) -->
            <div class="relative flex justify-center items-center md:justify-end animate-fade-right">
                <img src="{{ asset('images/header.png') }}" alt="SIMPEG-SP Hero Header Illustration" class="w-full max-w-lg md:max-w-xl object-contain drop-shadow-2xl hover:scale-[1.02] transition-transform duration-300">
            </div>

        </section>

    </div>

    <!-- ===== REAL-TIME PUBLIC STATS CARDS (SLOWER SCROLL REVEAL - 1.2s) ===== -->
    <section id="statistik" class="px-6 md:px-12 -mt-16 relative z-20 max-w-6xl mx-auto w-full reveal-on-scroll">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

            <!-- Stat 1 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">1.284+</h3>
                    <p class="text-xs font-semibold text-gray-400">Total PTK Terdata</p>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">48</h3>
                    <p class="text-xs font-semibold text-gray-400">Satuan Pendidikan</p>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">74%</h3>
                    <p class="text-xs font-semibold text-gray-400">Pegawai Bersertifikasi</p>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">100%</h3>
                    <p class="text-xs font-semibold text-gray-400">Monitoring Real-time</p>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== WIDGET CEK DATA PTK (SLOWER SCROLL REVEAL - 1.2s) ===== -->
    <section id="cek-ptk" class="px-6 md:px-12 py-16 max-w-6xl mx-auto w-full reveal-on-scroll">
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xl p-8 space-y-6">
            <div class="text-center max-w-xl mx-auto">
                <span class="text-[10px] uppercase font-bold tracking-wider text-blue-800 bg-blue-100 px-3 py-1 rounded-full">Fitur Pencarian Publik</span>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mt-2">Cek Status Verifikasi Data PTK</h2>
                <p class="text-xs text-gray-500 mt-1">Masukkan Nomor NIP atau NIK Pegawai untuk memverifikasi status keaktifan data di Dinas Pendidikan.</p>
            </div>

            <!-- Search Form Bar -->
            <form action="#" method="GET" class="flex flex-wrap items-center gap-3 max-w-2xl mx-auto pt-2" onclick="event.preventDefault()">
                <div class="relative flex-1">
                    <i class="fas fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Masukkan 18 Digit NIP / NIK Pegawai..." class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-xl pl-9 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                </div>
                <button type="button" class="bg-blue-800 hover:bg-blue-900 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fas fa-magnifying-glass text-xs"></i>
                    <span>Cari Data</span>
                </button>
            </form>
        </div>
    </section>

    <!-- ===== LAYANAN & KEUNGGULAN SECTION (SLOWER SCROLL REVEAL - 1.2s) ===== -->
    <section id="layanan" class="px-6 md:px-12 py-16 bg-gray-100/60 border-y border-gray-200/80 reveal-on-scroll">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-[10px] uppercase font-bold tracking-wider text-blue-800 bg-blue-100 px-3 py-1 rounded-full">Keunggulan Sistem</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Layanan Kepegawaian Satuan Pendidikan</h2>
                <p class="text-xs text-gray-500">Fitur unggulan SIMPEG-SP yang dirancang untuk mempermudah tata kelola administrasi kepegawaian sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Pemetaan 7 Kriteria Kepegawaian</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pengelompokan status kualifikasi PNS, PPPK, PPPK Paruh Waktu, dan Non-ASN secara detail dan transparan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-file-circle-check"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Verifikasi Berkas Digital</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Validasi dokumen SK Kepegawaian, Ijazah, dan Sertifikat Pendidik (Serdik) tanpa perlu mengumpulkan berkas fisik.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Monitoring Real-Time Dinas</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Dashboard eksekutif yang memberikan data statistik instan sebagai bahan acuan pengambilan kebijakan Dinas Pendidikan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== PENGUMUMAN TERKINI SECTION (SLOWER SCROLL REVEAL - 1.2s) ===== -->
    <section id="pengumuman" class="px-6 md:px-12 py-16 max-w-6xl mx-auto w-full space-y-8 reveal-on-scroll">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Pengumuman & Berita Kepegawaian</h2>
                <p class="text-xs text-gray-500 mt-1">Informasi resmi seputar sertifikasi, verifikasi berkas, dan kebijakan Dinas Pendidikan.</p>
            </div>
            <a href="#" class="text-xs font-bold text-blue-800 hover:underline flex items-center gap-1">
                <span>Lihat Semua Pengumuman</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card 1 -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-3 hover:shadow-md hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between text-xs">
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-[10px]">VERIFIKASI BERKAS</span>
                    <span class="text-gray-400 font-medium">25 Juli 2026</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 hover:text-blue-800 cursor-pointer transition">
                    Jadwal Verifikasi Berkas Kepegawaian Tahap II Tahun 2026
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Dinas Pendidikan membuka tahap verifikasi ulang berkas SK Kepegawaian bagi seluruh pegawai Non-ASN dan PPPK Paruh Waktu.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-3 hover:shadow-md hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between text-xs">
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-[10px]">SERTIFIKASI PENDIDIK</span>
                    <span class="text-gray-400 font-medium">20 Juli 2026</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 hover:text-blue-800 cursor-pointer transition">
                    Pemutakhiran Data Sertifikasi Pendidik (Serdik) Guru SD & SMP
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Himbauan kepada Operator Sekolah untuk memperbarui data sertifikasi guru di portal SIMPEG-SP sebelum batas waktu berakhir.
                </p>
            </div>

        </div>
    </section>

    <!-- ===== FOOTER RESMI (DEEP BLUE NAVY) ===== -->
    <footer class="bg-blue-950 text-white mt-auto border-t border-blue-900">
        <div class="px-6 md:px-16 py-12 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-xs">

            <div class="space-y-3 md:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-9 h-9 object-contain">
                    <div>
                        <h2 class="font-bold text-base text-white">SIMPEG-SP</h2>
                        <p class="text-[10px] uppercase text-blue-300 font-medium">Dinas Pendidikan</p>
                    </div>
                </div>
                <p class="text-blue-200/80 leading-relaxed max-w-md">
                    Sistem Informasi Manajemen Pegawai Satuan Pendidikan — Platform pemusatan data kepegawaian resmi Dinas Pendidikan.
                </p>
            </div>

            <div class="space-y-3">
                <h3 class="font-bold text-sm text-white">Tautan Cepat</h3>
                <ul class="space-y-2 text-blue-200/80">
                    <li><a href="#beranda" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#statistik" class="hover:text-white transition">Statistik Data</a></li>
                    <li><a href="#cek-ptk" class="hover:text-white transition">Cek Data PTK</a></li>
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

    @push('scripts')
        <!-- Dynamic Scroll & Intersection Observer Animation Controllers -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Dynamic Navbar Sticky Scroll Handler
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

                // Intersection Observer for Scroll-Reveal Animations (Slower Timing)
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -40px 0px'
                };

                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.reveal-on-scroll').forEach(section => {
                    revealObserver.observe(section);
                });
            });
        </script>
    @endpush
@endsection
