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
                <a href="{{ route('landing.pengumuman', ['category' => 'all']) }}" class="px-4 py-2 rounded-xl {{ request('category', 'all') == 'all' ? 'bg-blue-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">Semua Kategori</a>
                <a href="{{ route('landing.pengumuman', ['category' => 'Verifikasi']) }}" class="px-4 py-2 rounded-xl {{ request('category') == 'Verifikasi' ? 'bg-blue-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">Verifikasi Berkas</a>
                <a href="{{ route('landing.pengumuman', ['category' => 'Penting']) }}" class="px-4 py-2 rounded-xl {{ request('category') == 'Penting' ? 'bg-blue-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">Penting</a>
                <a href="{{ route('landing.pengumuman', ['category' => 'Surat Edaran']) }}" class="px-4 py-2 rounded-xl {{ request('category') == 'Surat Edaran' ? 'bg-blue-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">Surat Edaran</a>
            </div>

            <form action="{{ route('landing.pengumuman') }}" method="GET" class="relative w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-8 pr-3 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
            </form>
        </div>

        <!-- Announcements Grid List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if(isset($announcements) && count($announcements) > 0)
                @foreach($announcements as $item)
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm space-y-4 hover:shadow-md transition flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $item->kategori_badge_class }}">
                                    {{ strtoupper($item->kategori) }}
                                </span>
                                <span class="text-gray-400 font-medium text-[11px]">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 leading-snug">
                                {{ $item->judul }}
                            </h3>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                {{ $item->ringkasan ?: Str::limit(strip_tags($item->isi), 140) }}
                            </p>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[10px] text-gray-400 font-medium"><i class="fas fa-user-circle mr-1"></i> {{ $item->penulis_nama ?? 'Dinas Pendidikan' }}</span>
                            @if($item->lampiran_file)
                                <a href="{{ asset('storage/' . $item->lampiran_file) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-800 hover:underline">
                                    <span>Unduh Lampiran</span>
                                    <i class="fas fa-download text-[10px]"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-1 md:col-span-3 bg-white rounded-2xl border border-gray-200/80 p-12 text-center text-gray-400 space-y-3">
                    <i class="fas fa-bullhorn text-4xl text-gray-300"></i>
                    <p class="font-bold text-gray-600 text-sm">Belum ada pengumuman resmi yang diterbitkan saat ini.</p>
                </div>
            @endif
        </div>

        @if(isset($announcements) && method_exists($announcements, 'hasPages') && $announcements->hasPages())
            <div class="flex justify-center pt-4">
                {{ $announcements->links() }}
            </div>
        @endif

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
