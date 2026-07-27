@extends('layouts.app')

@section('title', 'Verifikasi Data & Berkas - SIMPEG-SP')

@section('content')
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
                    <span>{{ number_format($menungguCount ?? 0, 0, ',', '.') }} Menunggu Verifikasi</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- SUMMARY METRIC CARDS (Exact Match to Hope UI Card Style) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Dokumen -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-folder-open text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Pegawai Terhubung</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalCount ?? 0, 0, ',', '.') }}
                        </p>
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
                        <p class="text-xl md:text-2xl font-extrabold text-amber-600 mt-0.5">
                            {{ number_format($menungguCount ?? 0, 0, ',', '.') }}
                        </p>
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
                        <p class="text-xs text-gray-400 font-medium">Disetujui &amp; Valid</p>
                        <p class="text-xl md:text-2xl font-extrabold text-emerald-600 mt-0.5">
                            {{ number_format($disetujuiCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 4: Revisi -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-rose-500 flex items-center justify-center text-rose-600 font-bold bg-rose-50/50 flex-shrink-0">
                        <i class="fas fa-triangle-exclamation text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Perlu Revisi (Dinas)</p>
                        <p class="text-xl md:text-2xl font-extrabold text-rose-600 mt-0.5">
                            {{ number_format($revisiCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

        </div>

        <!-- Filter Bar Panel -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4 relative z-30">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Filter &amp; Pencarian Dokumen Verifikasi
                </h3>
                @if(request('search') || request('status') || request('sekolah_id'))
                    <a href="{{ route('verifikasi.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1">
                        <i class="fas fa-arrows-rotate text-[10px]"></i> Reset Filter
                    </a>
                @endif
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ route('verifikasi.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                
                <!-- Search Keyword -->
                <div class="col-span-1 sm:col-span-2 xl:col-span-2">
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
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>Draft / Belum Upload</option>
                        <option value="MENUNGGU" {{ request('status') == 'MENUNGGU' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="REVISI" {{ request('status') == 'REVISI' ? 'selected' : '' }}>Revisi (Verifikasi Dinas)</option>
                        <option value="DISETUJUI" {{ request('status') == 'DISETUJUI' ? 'selected' : '' }}>Disetujui &amp; Valid</option>
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

        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan <span class="font-bold text-gray-800">{{ $pegawais->total() }}</span> Data Berkas Kepegawaian
                </span>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full font-bold">
                        <i class="fas fa-check-circle mr-1"></i> Data Real-time Verifikasi
                    </span>
                </div>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full min-w-[1200px] text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5 text-center">No.</th>
                            <th class="px-6 py-3.5">Nama Pegawai &amp; NIP</th>
                            <th class="px-6 py-3.5">Satuan Pendidikan (Sekolah)</th>
                            <th class="px-6 py-3.5">Kelengkapan Berkas</th>
                            <th class="px-6 py-3.5">Status Berkas</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(isset($pegawais) && count($pegawais) > 0)
                            @foreach($pegawais as $pegawai)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">
                                        {{ $loop->iteration + ($pegawais->currentPage() - 1) * $pegawais->perPage() }}
                                    </td>
                                    <!-- Nama Pegawai & NIP -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            @php
                                                $words = explode(' ', $pegawai->nama_lengkap);
                                                $initials = strtoupper(substr($words[0] ?? 'P', 0, 1) . substr($words[1] ?? 'T', 0, 1));
                                            @endphp
                                            <div class="w-8 h-8 rounded-full bg-blue-900 text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-gray-900 text-xs">{{ $pegawai->nama_lengkap }}</p>
                                                <p class="text-[10px] text-gray-500 font-medium">NIP/NIK: <span class="font-bold text-blue-950 font-mono">{{ $pegawai->nip_nik ?: '-' }}</span></p>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Nama Sekolah -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-blue-100">
                                                <i class="fas fa-school text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-xs">{{ $pegawai->sekolah->nama_sekolah ?? '-' }}</p>
                                                <p class="text-[10px] text-gray-400 font-mono">NPSN: {{ $pegawai->sekolah->npsn ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Kelengkapan Berkas -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-[11px]">
                                            <span class="px-2 py-0.5 rounded font-bold {{ $pegawai->file_sk ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-400' }}">
                                                SK: {{ $pegawai->file_sk ? 'Ada' : 'Kosong' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded font-bold {{ $pegawai->file_serdik ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-400' }}">
                                                Serdik: {{ $pegawai->file_serdik ? 'Ada' : 'Kosong' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded font-bold {{ $pegawai->file_ijazah ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-gray-100 text-gray-400' }}">
                                                Ijazah: {{ $pegawai->file_ijazah ? 'Ada' : 'Kosong' }}
                                            </span>
                                        </div>
                                    </td>
                                    <!-- Status Berkas -->
                                    <td class="px-6 py-4">
                                        @php
                                            $st = $pegawai->status_verifikasi ?? 'DRAFT';
                                        @endphp
                                        @if($st === 'DISETUJUI')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fas fa-circle-check text-emerald-600"></i> Disetujui &amp; Valid
                                            </span>
                                        @elseif($st === 'REVISI')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fas fa-triangle-exclamation text-rose-600"></i> Revisi (Verifikasi Dinas)
                                            </span>
                                        @elseif($st === 'MENUNGGU')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <i class="fas fa-hourglass-half text-amber-600"></i> Menunggu Verifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                <i class="fas fa-file-arrow-up text-gray-400"></i> Draft / Belum Upload
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Aksi -->
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('verifikasi.show', $pegawai->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-blue-800 hover:bg-blue-900 text-white font-bold text-xs shadow-sm hover:shadow-md transition cursor-pointer">
                                            <i class="fas fa-magnifying-glass-chart text-xs"></i>
                                            <span>Tinjau Berkas</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-folder-open text-3xl text-gray-300"></i>
                                        <p class="font-bold text-gray-600">Tidak ada antrean data verifikasi berkas.</p>
                                        <p class="text-gray-400">Silakan gunakan pencarian atau ubah kriteria filter di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            @if(isset($pegawais) && method_exists($pegawais, 'hasPages') && $pegawais->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-3.5 bg-gray-50/50 text-center lg:text-left">
                    <span class="text-xs text-gray-500 font-medium text-center lg:text-left">
                        Halaman <span class="font-bold text-gray-800">{{ $pegawais->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $pegawais->lastPage() }}</span> (Menampilkan {{ $pegawais->firstItem() }} - {{ $pegawais->lastItem() }} dari {{ $pegawais->total() }} Data Berkas)
                    </span>
                    <div class="flex items-center justify-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($pegawais->onFirstPage())
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $pegawais->previousPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($pegawais->getUrlRange(max(1, $pegawais->currentPage() - 2), min($pegawais->lastPage(), $pegawais->currentPage() + 2)) as $page => $url)
                            @if ($page == $pegawais->currentPage())
                                <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($pegawais->hasMorePages())
                            <a href="{{ $pegawais->nextPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
