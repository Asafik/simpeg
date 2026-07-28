@extends('layouts.app')

@section('title', 'Kelola Sekolah - SIMPEG-SP')

@section('content')
    <!-- Reusable Loading Overlay Component -->
    @include('components.loading-overlay', [
        'id' => 'sekolahLoadingOverlay',
        'title' => 'Memuat & Menyaring Data Sekolah...',
        'subtitle' => 'Mohon tunggu sebentar, sistem sedang memproses data Satuan Pendidikan.'
    ])

    <!-- ===== HERO BLUE BANNER (Exact Hope UI 2-Wave Design - Deep Blue) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-20 md:pb-24 shadow-lg shadow-blue-950/20 overflow-hidden">
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Satuan Pendidikan (Sekolah)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Master data 980+ Satuan Pendidikan, Kepala Sekolah, dan pemetaan akun Operator Sekolah se-Kabupaten.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('sekolah.create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Tambah Sekolah</span>
                </a>
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
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs cursor-pointer">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        @endif
        
        <!-- ===== 4 OVERLAPPING SUMMARY METRIC CARDS (DASHBOARD STYLE) ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Satuan Pendidikan -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-school text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Satuan Pendidikan</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ isset($sekolahs) && method_exists($sekolahs, 'total') ? $sekolahs->total() : (\App\Models\Sekolah::count()) }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: Kepsek Definitif -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-user-check text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Kepsek Definitif</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ \App\Models\Sekolah::where('status_kepala_sekolah', 'Definitif')->count() }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: Plt. Kepsek -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-amber-500 flex items-center justify-center text-amber-600 font-bold bg-amber-50/50 flex-shrink-0">
                        <i class="fas fa-user-clock text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Plt. Kepala Sekolah</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ \App\Models\Sekolah::where('status_kepala_sekolah', 'Plt')->count() }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 4: Operator Terdaftar -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-indigo-500 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50/50 flex-shrink-0">
                        <i class="fas fa-laptop-code text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Operator Terdaftar</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ \App\Models\User::where('role', 'OPERATOR_SEKOLAH')->count() }}
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
                    Filter &amp; Pencarian Satuan Pendidikan
                </h3>
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ url('/sekolah') }}" method="GET" id="sekolahFilterForm" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                
                <!-- Search Input -->
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari NPSN / Nama / Kepsek</label>
                    <div class="relative flex items-center">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Ketik NPSN / Nama Sekolah..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-3 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                        <button type="submit" class="absolute right-1 w-7 h-7 bg-blue-800 hover:bg-blue-900 text-white rounded-md transition flex items-center justify-center shadow-sm cursor-pointer" title="Cari Data">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Kecamatan Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Filter Kecamatan</label>
                    <select name="kecamatan" class="js-auto-filter w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Kecamatan</option>
                        @if(isset($listKecamatan))
                            @foreach($listKecamatan as $kec)
                                <option value="{{ $kec }}" {{ $kecamatan == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Status Kepsek Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Status Kepala Sekolah</label>
                    <select name="status_kepala_sekolah" class="js-auto-filter w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Status Kepsek</option>
                        <option value="Definitif" {{ $statusKepsek == 'Definitif' ? 'selected' : '' }}>Definitif</option>
                        <option value="Plt" {{ $statusKepsek == 'Plt' ? 'selected' : '' }}>Plt. Kepala Sekolah</option>
                    </select>
                </div>

                <!-- Jenjang Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Jenjang Sekolah</label>
                    <select name="jenjang" class="js-auto-filter w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Jenjang (SD/SMP/TK)</option>
                        <option value="SD" {{ $jenjang == 'SD' ? 'selected' : '' }}>SD / SDN</option>
                        <option value="SMP" {{ $jenjang == 'SMP' ? 'selected' : '' }}>SMP / SMPN</option>
                        <option value="TK" {{ $jenjang == 'TK' ? 'selected' : '' }}>TK / TKN</option>
                    </select>
                </div>

                <!-- Filter Submit Button -->
                <div class="col-span-1 sm:col-span-2 md:col-span-4 flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    @if($search || $kecamatan || $statusKepsek || $jenjang)
                        <a href="{{ url('/sekolah') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                            <i class="fas fa-rotate-left text-[10px]"></i> Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-filter text-xs"></i>
                        <span>Terapkan Filter Data</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan {{ isset($sekolahs) && method_exists($sekolahs, 'total') ? $sekolahs->total() : (\App\Models\Sekolah::count()) }} Master Data Satuan Pendidikan
                </span>
                @if($search || $kecamatan || $statusKepsek || $jenjang)
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full font-bold">
                            <i class="fas fa-check-circle mr-1"></i> Filter Aktif: 
                            @if($kecamatan) Kecamatan {{ $kecamatan }} @endif
                            @if($statusKepsek) | Kepsek {{ $statusKepsek }} @endif
                            @if($jenjang) | Jenjang {{ $jenjang }} @endif
                        </span>
                    </div>
                @endif
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full min-w-[1200px] text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5 text-center">No.</th>
                            <th class="px-6 py-3.5">NPSN</th>
                            <th class="px-6 py-3.5">Nama Sekolah</th>
                            <th class="px-6 py-3.5">Kecamatan</th>
                            <th class="px-6 py-3.5 text-center">Jumlah Pegawai</th>
                            <th class="px-6 py-3.5">Kepala Sekolah</th>
                            <th class="px-6 py-3.5">Status Kepsek</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(isset($sekolahs) && count($sekolahs) > 0)
                            @foreach($sekolahs as $sekolah)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">
                                        {{ $loop->iteration + ((method_exists($sekolahs, 'firstItem') ? ($sekolahs->firstItem() ?? 1) : 1) - 1) }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-800 text-xs font-mono">
                                        {{ $sekolah->npsn }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900 text-xs">{{ $sekolah->nama_sekolah }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $sekolah->email_sekolah }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-700 font-semibold">
                                        <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 text-[11px]">
                                            <i class="fas fa-location-dot text-[9px] mr-1 text-gray-400"></i>{{ $sekolah->kecamatan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(($sekolah->pegawais_count ?? 0) > 0)
                                            <span class="px-2.5 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] font-extrabold inline-flex items-center gap-1">
                                                <i class="fas fa-users text-[10px] text-blue-600"></i>
                                                {{ $sekolah->pegawais_count }} Pegawai
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[11px] font-bold inline-flex items-center gap-1" title="Sekolah ini belum memiliki data pegawai terdaftar">
                                                <i class="fas fa-user-slash text-[10px] text-rose-500"></i>
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-800 text-xs">{{ $sekolah->nama_kepala_sekolah ?? '-' }}</p>
                                        <p class="text-[10px] text-gray-500 font-mono">NIP: {{ $sekolah->nip_kepala_sekolah ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(($sekolah->status_kepala_sekolah ?? 'Definitif') === 'Plt')
                                            <span class="badge-custom bg-amber-100 text-amber-800 font-bold text-[10px]">Plt. Kepala Sekolah</span>
                                        @else
                                            <span class="badge-custom bg-emerald-100 text-emerald-800 font-bold text-[10px]">Definitif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('sekolah.show', $sekolah->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-blue-800 hover:text-white text-xs font-semibold rounded-lg transition text-gray-700 flex items-center gap-1" title="Detail Sekolah">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('sekolah.edit', $sekolah->id) }}" class="w-7 h-7 bg-gray-100 hover:bg-amber-500 hover:text-white text-xs font-semibold rounded-lg transition text-gray-700 flex items-center justify-center" title="Edit Data Sekolah">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="{{ route('sekolah.riwayat', $sekolah->id) }}" class="w-7 h-7 bg-gray-100 hover:bg-indigo-600 hover:text-white text-xs font-semibold rounded-lg transition text-gray-700 flex items-center justify-center" title="Riwayat Perubahan">
                                                <i class="fas fa-clock-rotate-left"></i>
                                            </a>
                                            <form action="{{ route('sekolah.destroy', $sekolah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sekolah {{ $sekolah->nama_sekolah }}?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-7 h-7 bg-gray-100 hover:bg-red-600 hover:text-white text-xs font-semibold rounded-lg transition text-gray-700 flex items-center justify-center cursor-pointer" title="Hapus Sekolah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-xs text-gray-400 font-medium">
                                    Tidak ada data sekolah yang ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination (Matches Custom SIMPEG-SP UI Styling) -->
            @if(isset($sekolahs) && method_exists($sekolahs, 'hasPages') && $sekolahs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-3.5 bg-gray-50/50 text-center lg:text-left">
                    <span class="text-xs text-gray-500 font-medium text-center lg:text-left">
                        Halaman <span class="font-bold text-gray-800">{{ $sekolahs->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $sekolahs->lastPage() }}</span> (Menampilkan {{ $sekolahs->firstItem() }} - {{ $sekolahs->lastItem() }} dari {{ $sekolahs->total() }} Sekolah)
                    </span>
                    <div class="flex items-center justify-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($sekolahs->onFirstPage())
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $sekolahs->previousPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($sekolahs->getUrlRange(max(1, $sekolahs->currentPage() - 2), min($sekolahs->lastPage(), $sekolahs->currentPage() + 2)) as $page => $url)
                            @if ($page == $sekolahs->currentPage())
                                <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 bg-white rounded-lg transition font-medium border border-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($sekolahs->hasMorePages())
                            <a href="{{ $sekolahs->nextPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @elseif(isset($sekolahs) && method_exists($sekolahs, 'total'))
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <span class="text-xs text-gray-500 font-medium">Menampilkan {{ $sekolahs->total() }} Satuan Pendidikan</span>
                </div>
            @endif

        </div>

    </div>

    <!-- Automatic Event Listener Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sekolahFilterForm');
            if (!form) return;

            form.addEventListener('submit', function() {
                if (typeof showLoadingOverlay === 'function') {
                    showLoadingOverlay('Memproses Filter Sekolah...', 'Sistem sedang menyaring master data Satuan Pendidikan...');
                }
            });

            const selects = form.querySelectorAll('.js-auto-filter');
            selects.forEach(function(s) {
                s.addEventListener('change', function() {
                    if (typeof showLoadingOverlay === 'function') {
                        showLoadingOverlay('Memuat Data Sekolah...', 'Sistem sedang memproses filter Satuan Pendidikan...');
                    }
                    form.submit();
                });
            });
        });
    </script>
@endsection
