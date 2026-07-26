@extends('layouts.app')

@section('title', 'Detail Pegawai - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">Profil & Berkas Pegawai</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Rincian profil 7 kriteria utama dan dokumen terverifikasi Dinas Pendidikan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('/pegawai') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-print"></i> Cetak Profil
                </button>
                <a href="{{ url('/pegawai/create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <i class="fas fa-pen"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 w-full -mt-8 relative z-20">
        
        <!-- PROFILE SUMMARY CARD -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-blue-800 text-white text-2xl font-extrabold flex items-center justify-center shadow-lg shadow-blue-900/30">
                    AF
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold text-gray-900">Dr. Ahmad Fauzi, M.Pd.</h2>
                        <span class="badge-custom bg-blue-100 text-blue-800">PNS</span>
                        <span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Serdik</span>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 mt-0.5">NIP. 197503212005011002 • SMA Negeri 1 Jakarta</p>
                    <p class="text-xs text-gray-400 mt-1">Jabatan: Guru Ahli Muda (Guru Mapel Matematika)</p>
                </div>
            </div>
            <div class="text-right border-l border-gray-100 pl-6 hidden sm:block">
                <p class="text-xs text-gray-400">Status Verifikasi Berkas</p>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full mt-1">
                    <i class="fas fa-circle-check"></i> Terverifikasi Dinas
                </span>
            </div>
        </div>

        <!-- 7 KRITERIA GRID SUMMARY -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-list-check"></i> Rincian 7 Kriteria Pendataan Utama
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">1. Status Kepegawaian</p>
                    <p class="font-bold text-gray-800 mt-0.5">PNS</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">2. Jabatan Fungsional</p>
                    <p class="font-bold text-gray-800 mt-0.5">Guru Ahli Muda</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">3. Sertifikasi Pendidik</p>
                    <p class="font-bold text-emerald-600 mt-0.5">Serdik (Bersertifikasi)</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">4. Jenis PTK</p>
                    <p class="font-bold text-gray-800 mt-0.5">Pendidik (Guru)</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">5. Jenis Guru</p>
                    <p class="font-bold text-gray-800 mt-0.5">Guru Mata Pelajaran</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">6. Tingkat Pendidikan</p>
                    <p class="font-bold text-gray-800 mt-0.5">Magister (S2)</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">7. Usia (Hitung Real-time)</p>
                    <p class="font-bold text-gray-800 mt-0.5">51 Tahun (21 Mar 1975)</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-[10px] text-gray-400 font-medium">Satuan Pendidikan</p>
                    <p class="font-bold text-gray-800 mt-0.5">SMA Negeri 1 Jakarta</p>
                </div>
            </div>
        </div>

        <!-- PREVIEW BERKAS TERLAMPIR (SK, SERDIK, IJAZAH) -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-folder-open"></i> Berkas Lampiran PDF Terverifikasi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <!-- Card Berkas 1: SK -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">SK Kepegawaian.pdf</p>
                            <p class="text-[10px] text-gray-400">Terunggah • 1.4 MB</p>
                        </div>
                    </div>
                    <button class="w-full py-2 bg-blue-800 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center justify-center gap-1">
                        <i class="fas fa-eye"></i> Preview SK
                    </button>
                </div>

                <!-- Card Berkas 2: Serdik -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Sertifikat_Pendidik.pdf</p>
                            <p class="text-[10px] text-gray-400">Terunggah • 1.8 MB</p>
                        </div>
                    </div>
                    <button class="w-full py-2 bg-blue-800 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center justify-center gap-1">
                        <i class="fas fa-eye"></i> Preview Serdik
                    </button>
                </div>

                <!-- Card Berkas 3: Ijazah -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Ijazah_S2.pdf</p>
                            <p class="text-[10px] text-gray-400">Terunggah • 1.2 MB</p>
                        </div>
                    </div>
                    <button class="w-full py-2 bg-blue-800 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center justify-center gap-1">
                        <i class="fas fa-eye"></i> Preview Ijazah
                    </button>
                </div>

            </div>
        </div>

    </div>
@endsection
