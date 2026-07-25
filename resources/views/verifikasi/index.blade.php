@extends('layouts.app')

@section('title', 'Verifikasi Data & Berkas - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Exact Hope UI 2-Wave Design - Deep Blue) ===== -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Verifikasi & Validasi Berkas</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Peninjauan dokumen SK Kepegawaian, Sertifikat Pendidik, dan Ijazah yang diunggah oleh Operator Sekolah.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-amber-300 bg-white/15 backdrop-blur-md border border-white/20 px-3.5 py-2.5 rounded-lg shadow-sm">
                    <i class="fas fa-clock mr-1 text-amber-400"></i> 12 Berkas Menunggu Verifikasi
                </span>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">
        
        <!-- Status Tabs Card -->
        <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-2 text-xs font-bold">
            <button class="px-4 py-2 bg-blue-800 text-white rounded-lg shadow-sm">
                Menunggu Verifikasi (12)
            </button>
            <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                Disetujui (145)
            </button>
            <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                Ditolak (3)
            </button>
        </div>

        <!-- Verification Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-800 text-white font-bold text-xs flex items-center justify-center">RF</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-xs">Rina Febriani, S.Pd.</h3>
                            <p class="text-[10px] text-gray-400">NIP. 199508212021062011 • SD Negeri 1 Medan</p>
                        </div>
                    </div>
                    <span class="badge-custom bg-amber-100 text-amber-800">Baru Diunggah</span>
                </div>

                <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-1.5 border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Dokumen Yang Diunggah:</p>
                    <div class="flex items-center justify-between text-gray-700">
                        <span class="flex items-center gap-1.5"><i class="fas fa-file-pdf text-red-500"></i> SK_PPPK_PW_2026.pdf</span>
                        <a href="#" class="text-blue-800 font-bold hover:underline">Preview</a>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button class="px-3.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold rounded-lg transition">
                        <i class="fas fa-times mr-1"></i> Tolak Berkas
                    </button>
                    <button class="px-4 py-1.5 bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-bold rounded-lg transition shadow-sm">
                        <i class="fas fa-check mr-1"></i> Setujui & Kunci Data
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-600 text-white font-bold text-xs flex items-center justify-center">MU</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-xs">Dra. Maria Ulfa, M.M.</h3>
                            <p class="text-[10px] text-gray-400">NIP. 198212102002121003 • SMA Negeri 5 Yogyakarta</p>
                        </div>
                    </div>
                    <span class="badge-custom bg-amber-100 text-amber-800">Baru Diunggah</span>
                </div>

                <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-1.5 border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Dokumen Yang Diunggah:</p>
                    <div class="flex items-center justify-between text-gray-700">
                        <span class="flex items-center gap-1.5"><i class="fas fa-file-pdf text-red-500"></i> Sertifikat_Pendidik_2026.pdf</span>
                        <a href="#" class="text-blue-800 font-bold hover:underline">Preview</a>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button class="px-3.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold rounded-lg transition">
                        <i class="fas fa-times mr-1"></i> Tolak Berkas
                    </button>
                    <button class="px-4 py-1.5 bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-bold rounded-lg transition shadow-sm">
                        <i class="fas fa-check mr-1"></i> Setujui & Kunci Data
                    </button>
                </div>
            </div>

        </div>

    </div>
@endsection
