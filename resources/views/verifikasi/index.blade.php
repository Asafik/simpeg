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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Verifikasi & Validasi Berkas Pegawai</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Peninjauan dan keabsahan dokumen kepegawaian (SK, Sertifikat Pendidik, Ijazah) yang diunggah oleh Operator Sekolah.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-amber-300 bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2">
                    <i class="fas fa-clock text-amber-400"></i>
                    <span>12 Berkas Menunggu Verifikasi</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">

        <!-- SUMMARY METRIC CARDS (Exact Match to Hope UI Card Style) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Pengajuan -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-folder-open text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Dokumen</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">168</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: Menunggu Verifikasi -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-amber-500 flex items-center justify-center text-amber-600 font-bold bg-amber-50/50 flex-shrink-0">
                        <i class="fas fa-hourglass-half text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Menunggu Verifikasi</p>
                        <p class="text-xl md:text-2xl font-extrabold text-amber-600 mt-0.5">12</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: Disetujui -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-circle-check text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Disetujui & Valid</p>
                        <p class="text-xl md:text-2xl font-extrabold text-emerald-600 mt-0.5">145</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 4: Ditolak / Draft -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-rose-500 flex items-center justify-center text-rose-600 font-bold bg-rose-50/50 flex-shrink-0">
                        <i class="fas fa-circle-xmark text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Ditolak / Perlu Perbaikan</p>
                        <p class="text-xl md:text-2xl font-extrabold text-rose-600 mt-0.5">11</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

        </div>

        <!-- Filter Bar Panel (Exact Match to Sekolah & User Index UI) -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4 relative z-30">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Filter &amp; Pencarian Dokumen Verifikasi
                </h3>
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ url('/verifikasi') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                
                <!-- Search Keyword -->
                <div class="col-span-1 sm:col-span-2 md:col-span-2">
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari NIP / Nama Pegawai / Sekolah</label>
                    <div class="relative flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik NIP, nama pegawai, atau nama sekolah..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-3 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                        <button type="submit" class="absolute right-1 w-7 h-7 bg-blue-800 hover:bg-blue-900 text-white rounded-md transition flex items-center justify-center shadow-sm cursor-pointer" title="Cari Data">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Filter Status Verifikasi</label>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Status</option>
                        <option value="MENUNGGU" selected>Menunggu Verifikasi (12)</option>
                        <option value="DISETUJUI">Disetujui (145)</option>
                        <option value="DITOLAK">Ditolak (3)</option>
                        <option value="DRAFT">Draft / Belum Upload (8)</option>
                    </select>
                </div>

                <!-- Filter Submit Button -->
                <div class="flex items-end justify-end gap-2">
                    <button type="submit" class="w-full py-2 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card Container (Exact Match to Sekolah Index Table) -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan <span class="font-bold text-gray-800">8</span> Antrean Dokumen Berkas Pegawai
                </span>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full font-bold">
                        <i class="fas fa-check-circle mr-1"></i> Data Real-time Verifikasi
                    </span>
                </div>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5 text-center">No.</th>
                            <th class="px-6 py-3.5">Nama Pegawai &amp; NIP</th>
                            <th class="px-6 py-3.5">Satuan Pendidikan (Sekolah)</th>
                            <th class="px-6 py-3.5">Jenis Berkas</th>
                            <th class="px-6 py-3.5">Status Berkas</th>
                            <th class="px-6 py-3.5 text-right">Aksi &amp; Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <!-- Row 1: Menunggu Verifikasi -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">1</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-900 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        SU
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">SURAHMAT, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">198503122010011002</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Balung Lor 01
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-file-pdf text-rose-600 text-sm"></i>
                                    <span>SK Kepegawaian (SK_PNS_2026.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-hourglass-half text-amber-700"></i> Menunggu Verifikasi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="openVerificationModal('SURAHMAT, S.Pd.', 'SDN Balung Lor 01', 'SK Kepegawaian', 'SK_PNS_2026.pdf')" class="px-2.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                        <i class="fas fa-eye"></i> Tinjau &amp; Verifikasi
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2: Disetujui -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">2</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        SN
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">SITI NURHALIZA, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">199004152014022005</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Balung Lor 02
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-certificate text-emerald-600 text-sm"></i>
                                    <span>Sertifikat Pendidik (Serdik_2025.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-circle-check text-emerald-700"></i> Disetujui &amp; Valid
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="alert('Dokumen ini sudah terverifikasi valid.')" class="px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition">
                                        <i class="fas fa-circle-info"></i> Detail Validasi
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3: Ditolak -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">3</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-rose-700 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        BH
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">BAMBANG HERMANTO, S.T.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">197811092005011003</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Balung Lor 03
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-graduation-cap text-purple-600 text-sm"></i>
                                    <span>Ijazah Terakhir (Ijazah_S1.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-circle-xmark text-rose-700"></i> Ditolak (File Buram)
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="alert('Alasan Penolakan: Berkas scan ijazah buram dan nomor ijazah tidak terbaca.')" class="px-2.5 py-1.5 bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold rounded-lg transition hover:bg-rose-100">
                                        <i class="fas fa-circle-exclamation"></i> Alasan Ditolak
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4: Menunggu Verifikasi -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">4</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-900 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        RM
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">RETNO MUSTIKA RINI, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">198205202008012010</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Gelang 01
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-file-pdf text-rose-600 text-sm"></i>
                                    <span>SK Kepegawaian (SK_Kepsek_2026.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-hourglass-half text-amber-700"></i> Menunggu Verifikasi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="openVerificationModal('RETNO MUSTIKA RINI, S.Pd.', 'SDN Gelang 01', 'SK Kepegawaian', 'SK_Kepsek_2026.pdf')" class="px-2.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                        <i class="fas fa-eye"></i> Tinjau &amp; Verifikasi
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5: Disetujui -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">5</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        LH
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">LUKMAN HADI, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">198701012011011004</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Gelang 04
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-certificate text-emerald-600 text-sm"></i>
                                    <span>Sertifikat Pendidik (Serdik_Lukman.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-circle-check text-emerald-700"></i> Disetujui &amp; Valid
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="alert('Dokumen ini sudah terverifikasi valid.')" class="px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition">
                                        <i class="fas fa-circle-info"></i> Detail Validasi
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 6: Draft / Belum Upload -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">6</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gray-600 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        AR
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">AHMAD RIFAI, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">199208142022031001</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Curahlele 01
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-400 italic">
                                    <i class="fas fa-file-circle-minus text-gray-400 text-sm"></i>
                                    <span>Belum Diunggah</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 border border-gray-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-clock-rotate-left text-gray-500"></i> Draft / Belum Upload
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <span class="text-xs text-gray-400 italic">Menunggu Ops Sekolah</span>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 7: Menunggu Verifikasi -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">7</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-900 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        DA
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">DEWI ANGGRAENI, S.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">199512032023012002</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SDN Puger 01
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-graduation-cap text-purple-600 text-sm"></i>
                                    <span>Ijazah Terakhir (Ijazah_S1_Dewi.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-hourglass-half text-amber-700"></i> Menunggu Verifikasi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="openVerificationModal('DEWI ANGGRAENI, S.Pd.', 'SDN Puger 01', 'Ijazah Terakhir', 'Ijazah_S1_Dewi.pdf')" class="px-2.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                        <i class="fas fa-eye"></i> Tinjau &amp; Verifikasi
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 8: Ditolak -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">8</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-rose-700 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                        HP
                                    </div>
                                    <div class="truncate">
                                        <p class="font-extrabold text-gray-900 text-xs truncate">HERU PRASETYO, M.Pd.</p>
                                        <p class="text-[10px] text-gray-500 font-medium">NIP. <span class="font-bold text-blue-950 font-mono">197906182006041005</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-school text-gray-500"></i> SMPN 1 Balung
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                                    <i class="fas fa-file-pdf text-rose-600 text-sm"></i>
                                    <span>SK Kepegawaian (SK_Golongan_IV.pdf)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-200 text-[11px] font-bold inline-flex items-center gap-1">
                                    <i class="fas fa-circle-xmark text-rose-700"></i> Ditolak (SK Kedaluwarsa)
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="alert('Alasan Penolakan: Masa berlaku SK telah berakhir, harap unggah SK Jabatan terbaru.')" class="px-2.5 py-1.5 bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold rounded-lg transition hover:bg-rose-100">
                                        <i class="fas fa-circle-exclamation"></i> Alasan Ditolak
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Pagination (Matches Custom SIMPEG-SP UI Styling) -->
            <div class="px-6 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 bg-gray-50/50">
                <span class="text-xs text-gray-500 font-medium">
                    Halaman <span class="font-bold text-gray-800">1</span> dari <span class="font-bold text-gray-800">1</span> (Menampilkan 1 - 8 dari 8 Dokumen Verifikasi)
                </span>
                <div class="flex items-center gap-1">
                    <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                    <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg shadow-sm">1</span>
                    <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL TINJAU & VERIFIKASI BERKAS -->
    <div id="verificationModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-5 animate-fadeIn">
            
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                    <i class="fas fa-shield-halved text-blue-800"></i>
                    Verifikasi Dokumen Pegawai
                </h3>
                <button onclick="closeVerificationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="space-y-3 bg-gray-50/80 rounded-xl p-4 border border-gray-100 text-xs">
                <div class="grid grid-cols-3 gap-2">
                    <span class="text-gray-400 font-semibold">Nama Pegawai:</span>
                    <span id="modalPegawaiName" class="col-span-2 font-bold text-gray-900"></span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <span class="text-gray-400 font-semibold">Satuan Pendidikan:</span>
                    <span id="modalSekolahName" class="col-span-2 font-bold text-gray-900"></span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <span class="text-gray-400 font-semibold">Jenis Dokumen:</span>
                    <span id="modalJenisDoc" class="col-span-2 font-bold text-blue-800"></span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <span class="text-gray-400 font-semibold">Nama File:</span>
                    <span id="modalFileName" class="col-span-2 font-mono font-bold text-gray-700"></span>
                </div>
            </div>

            <!-- PDF Viewer Mock Preview -->
            <div class="bg-gray-900 rounded-xl p-8 text-center text-white space-y-2 border border-gray-800">
                <i class="fas fa-file-pdf text-4xl text-rose-500"></i>
                <p class="text-xs font-bold">Preview Dokumen Digital</p>
                <p id="modalFileNameSub" class="text-[10px] text-gray-400 font-mono"></p>
                <button onclick="alert('Membuka file dokumen di tab baru...')" class="inline-block mt-2 px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-bold shadow-xs">
                    <i class="fas fa-external-link-alt text-[10px] mr-1"></i> Buka Fullscreen PDF
                </button>
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <button onclick="closeVerificationModal()" class="px-4 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    Batal
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="handleRejectAction()" class="px-4 py-2 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 text-xs font-bold rounded-lg transition">
                        <i class="fas fa-times-circle mr-1"></i> Tolak Berkas
                    </button>
                    <button onclick="handleApproveAction()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-md shadow-emerald-600/20">
                        <i class="fas fa-check-circle mr-1"></i> Setujui &amp; Sahkan
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        function openVerificationModal(name, sekolah, jenis, file) {
            document.getElementById('modalPegawaiName').innerText = name;
            document.getElementById('modalSekolahName').innerText = sekolah;
            document.getElementById('modalJenisDoc').innerText = jenis;
            document.getElementById('modalFileName').innerText = file;
            document.getElementById('modalFileNameSub').innerText = file;
            
            document.getElementById('verificationModal').classList.remove('hidden');
        }

        function closeVerificationModal() {
            document.getElementById('verificationModal').classList.add('hidden');
        }

        function handleApproveAction() {
            alert('Sukses! Berkas dokumen berhasil disetujui dan disahkan.');
            closeVerificationModal();
        }

        function handleRejectAction() {
            const reason = prompt('Masukkan alasan penolakan berkas:');
            if (reason) {
                alert(`Berkas ditolak dengan alasan: "${reason}"`);
                closeVerificationModal();
            }
        }
    </script>
@endsection
