@extends('layouts.app')

@section('title', 'SIMPEG-SP - Pemusatan Data Kepegawaian Satuan Pendidikan Dinas Pendidikan')

@push('styles')
    <!-- ===== LANDING ANIMATION STYLES (SMOOTH TIMING) ===== -->
    <style>
        /* Entrance Animations for Hero Section (On Page Load) - 1.4s */
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

        /* Scroll Reveal Animations for Sections Below Hero - 1.2s */
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

        <!-- Dynamic Header Navbar Partial -->
        @include('landing.navbarlanding')

        <!-- Hero Section Grid -->
        <section id="beranda" class="w-full px-6 md:px-12 pt-20 lg:pt-16 pb-20 md:pb-28 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center flex-1 my-auto">

            <!-- Left Text Column -->
            <div class="space-y-6 text-left animate-fade-left order-2 lg:order-1">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-white">
                    Pemusatan Data Kepegawaian & Verifikasi Berkas Satuan Pendidikan
                </h1>

                <p class="text-sm md:text-base text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                    Platform terpadu Dinas Pendidikan untuk pemetaan kualifikasi 7 kriteria utama kepegawaian (PNS, PPPK, PPPK Paruh Waktu, & Non-ASN) serta validasi digital Sertifikasi Pendidik (Serdik) secara real-time.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ url('/login') }}" class="bg-white text-blue-900 hover:bg-blue-50 font-extrabold text-xs px-7 py-3.5 rounded-xl shadow-xl transition flex items-center gap-2">
                            <span>Masuk Portal SIMPEG-SP</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ url('/landing/cek-ptk') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-6 py-3.5 rounded-xl shadow-md transition flex items-center gap-2">
                            <i class="fas fa-search text-xs"></i>
                            <span>Cek Status Data PTK</span>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-2 text-[11px] font-semibold text-blue-200/80">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> {{ $totalSekolah }} Satuan Pendidikan
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> {{ number_format($totalPegawai) }}+ Data PTK Terdata
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-circle-check text-emerald-400 text-xs"></i> Monitoring Real-Time
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Header Illustration Image -->
            <div class="relative flex justify-center items-center lg:justify-end animate-fade-right order-1 lg:order-2">
                <img src="{{ asset('images/header.png') }}" alt="SIMPEG-SP Hero Header Illustration" class="w-full max-w-md lg:max-w-xl object-contain drop-shadow-2xl hover:scale-[1.02] transition-transform duration-300">
            </div>

        </section>

    </div>

    <!-- ===== REAL-TIME PUBLIC STATS CARDS ===== -->
    <section id="statistik" class="px-6 md:px-12 -mt-16 relative z-20 max-w-6xl mx-auto w-full reveal-on-scroll">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">{{ number_format($totalPegawai) }}</h3>
                    <p class="text-xs font-semibold text-gray-400">Total PTK Terdata</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">{{ $totalSekolah }}</h3>
                    <p class="text-xs font-semibold text-gray-400">Satuan Pendidikan</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">{{ $persenSerdik }}%</h3>
                    <p class="text-xs font-semibold text-gray-400">Pegawai Bersertifikasi</p>
                </div>
            </div>

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

    <!-- ===== WIDGET CEK DATA PTK ===== -->
    <section id="cek-ptk" class="px-6 md:px-12 py-16 max-w-6xl mx-auto w-full reveal-on-scroll">
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xl p-8 space-y-6">
            <div class="text-center max-w-xl mx-auto">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mt-2">Cek Status Verifikasi Data PTK</h2>
                <p class="text-xs text-gray-500 mt-1">Masukkan Nomor NIP atau NIK Pegawai untuk memverifikasi status keaktifan data di Dinas Pendidikan.</p>
            </div>

            <form action="{{ url('/landing/cek-ptk') }}" method="GET" class="flex flex-wrap items-center gap-3 max-w-2xl mx-auto pt-2">
                <div class="relative flex-1">
                    <i class="fas fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="keyword" placeholder="Masukkan 18 Digit NIP / NIK Pegawai..." class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-xl pl-9 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                </div>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fas fa-magnifying-glass text-xs"></i>
                    <span>Cari Data</span>
                </button>
            </form>
        </div>
    </section>

    <!-- ===== LAYANAN & KEUNGGULAN SECTION ===== -->
    <section id="layanan" class="px-6 md:px-12 py-16 bg-gray-100/60 border-y border-gray-200/80 reveal-on-scroll">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Layanan Kepegawaian Satuan Pendidikan</h2>
                <p class="text-xs text-gray-500">Fitur unggulan SIMPEG-SP yang dirancang untuk mempermudah tata kelola administrasi kepegawaian sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Pemetaan 7 Kriteria Kepegawaian</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pengelompokan status kualifikasi PNS, PPPK, PPPK Paruh Waktu, dan Non-ASN secara detail dan transparan.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-file-circle-check"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Verifikasi Berkas Digital</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Validasi dokumen SK Kepegawaian, Ijazah, dan Sertifikat Pendidik (Serdik) tanpa perlu mengumpulkan berkas fisik.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm space-y-4 hover:shadow-md hover:-translate-y-1 transition duration-300 md:col-span-2 lg:col-span-1">
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

    <!-- ===== PENGUMUMAN TERKINI SECTION ===== -->
    <section id="pengumuman" class="px-6 md:px-12 py-16 max-w-6xl mx-auto w-full space-y-8 reveal-on-scroll">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Pengumuman & Berita Kepegawaian</h2>
                <p class="text-xs text-gray-500 mt-1">Informasi resmi seputar sertifikasi, verifikasi berkas, dan kebijakan Dinas Pendidikan.</p>
            </div>
            <a href="{{ url('/landing/pengumuman') }}" class="text-xs font-bold text-blue-800 hover:underline flex items-center gap-1">
                <span>Lihat Semua Pengumuman</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($latestAnnouncements as $announcement)
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-3 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="flex items-center justify-between text-xs">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $announcement->kategori_badge_class }}">
                            {{ strtoupper($announcement->kategori) }}
                        </span>
                        <span class="text-gray-400 font-medium">
                            {{ $announcement->created_at ? $announcement->created_at->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 hover:text-blue-800 transition">
                        {{ $announcement->judul }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                        {{ $announcement->ringkasan ?? Str::limit(strip_tags($announcement->isi), 150) }}
                    </p>
                </div>
            @empty
                <div class="col-span-2 bg-white rounded-2xl border border-gray-200/80 p-8 text-center text-xs text-gray-500">
                    Belum ada pengumuman terbaru yang diterbitkan.
                </div>
            @endforelse
        </div>
    </section>

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

                const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -40px 0px' };
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
