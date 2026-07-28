@extends('layouts.app')

@section('title', 'Kelola Data Pegawai - SIMPEG-SP')

@section('content')
    <!-- Reusable Loading Overlay Component -->
    @include('components.loading-overlay', [
        'id' => 'pegawaiLoadingOverlay',
        'title' => 'Memuat & Menyaring Data Pegawai...',
        'subtitle' => 'Mohon tunggu sebentar, sistem sedang memproses data Pendidik & Tenaga Kependidikan.'
    ])

    <!-- ===== HERO BLUE BANNER (Exact Hope UI 2-Wave Design - Deep Blue) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <!-- Exact Hope UI 2 Diagonal Wave Shapes Overlay -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Data Pegawai (PTK)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola master data pendidik &amp; tenaga kependidikan berbasis 7 kriteria utama Dinas Pendidikan.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ url('/pegawai/create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Tambah Pegawai</span>
                </a>
                <button type="button" onclick="openImportModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition cursor-pointer">
                    <i class="fas fa-file-import text-xs"></i>
                    <span>Import Data</span>
                </button>
                <a href="{{ route('pegawai.template') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition" title="Unduh Template Excel (.xlsx)">
                    <i class="fas fa-file-excel text-xs text-blue-200"></i>
                    <span>Template Excel</span>
                </a>
                <a href="{{ route('pegawai.export.excel', request()->query()) }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition">
                    <i class="fas fa-file-excel text-xs text-emerald-400"></i>
                    <span>Export Excel</span>
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
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- SUMMARY METRIC CARDS (Exact Match to Sekolah Index UI) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Pegawai -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-users text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Pegawai</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalPegawaiCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: Pegawai PNS -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-user-tie text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Pegawai PNS</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalPnsCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: Pegawai PPPK & PW -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-amber-500 flex items-center justify-center text-amber-600 font-bold bg-amber-50/50 flex-shrink-0">
                        <i class="fas fa-id-badge text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Pegawai PPPK & PW</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalPppkCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 4: Pegawai Serdik -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-indigo-500 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50/50 flex-shrink-0">
                        <i class="fas fa-award text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Pegawai Serdik</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalSerdikCount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

        </div>

        <!-- 7 KRITERIA MULTI-FILTER BAR -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4 relative z-30">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Multi-Filter Kombinasi (7 Kriteria PRD)
                </h3>
            </div>

            <!-- Filter Grid 7 Dropdowns + Search Form -->
            <form action="{{ url('/pegawai') }}" method="GET" id="pegawaiFilterForm" onsubmit="handlePegawaiSubmit(event)" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                
                <!-- Search Keyword -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari NIP / Nama / Sekolah</label>
                    <div class="relative flex items-center">
                        <i class="fas fa-search absolute left-3 text-gray-400 text-xs pointer-events-none"></i>
                        <input type="text" id="pegawaiSearchInput" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-8 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                        <button type="submit" class="absolute right-1 w-7 h-7 bg-blue-800 hover:bg-blue-900 text-white rounded-md transition flex items-center justify-center shadow-sm cursor-pointer" title="Cari Data">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- 1. Status Kepegawaian -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">1. Status Kepegawaian</label>
                    <select name="status_kepegawaian" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Status (PNS, PPPK, dll)</option>
                        <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="PPPK PW" {{ request('status_kepegawaian') == 'PPPK PW' ? 'selected' : '' }}>PPPK PW (Paruh Waktu)</option>
                        <option value="Non-ASN" {{ request('status_kepegawaian') == 'Non-ASN' ? 'selected' : '' }}>Non-ASN</option>
                    </select>
                </div>

                <!-- 2. Jabatan Fungsional -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">2. Jabatan Fungsional</label>
                    <select name="jabatan_fungsional" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Jabatan</option>
                        @if(isset($jabatanList))
                            @foreach($jabatanList as $jbt)
                                <option value="{{ $jbt }}" {{ request('jabatan_fungsional') == $jbt ? 'selected' : '' }}>{{ $jbt }}</option>
                            @endforeach
                        @else
                            <option value="Guru Ahli Pertama" {{ request('jabatan_fungsional') == 'Guru Ahli Pertama' ? 'selected' : '' }}>Guru Ahli Pertama</option>
                            <option value="Guru Ahli Muda" {{ request('jabatan_fungsional') == 'Guru Ahli Muda' ? 'selected' : '' }}>Guru Ahli Muda</option>
                            <option value="Kepala Sekolah" {{ request('jabatan_fungsional') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Penilik" {{ request('jabatan_fungsional') == 'Penilik' ? 'selected' : '' }}>Penilik</option>
                        @endif
                    </select>
                </div>

                <!-- 3. Sertifikasi Pendidik (Serdik) -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">3. Sertifikasi (Serdik)</label>
                    <select name="serdik" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Status Serdik</option>
                        <option value="1" {{ (request('serdik') === '1' || request('is_serdik') === '1') ? 'selected' : '' }}>Sudah Serdik</option>
                        <option value="0" {{ (request('serdik') === '0' || request('is_serdik') === '0') ? 'selected' : '' }}>Belum Serdik</option>
                    </select>
                </div>

                <!-- 4. Jenis PTK -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">4. Jenis PTK</label>
                    <select name="jenis_ptk" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua PTK</option>
                        <option value="Pendidik" {{ request('jenis_ptk') == 'Pendidik' ? 'selected' : '' }}>Pendidik (Guru)</option>
                        <option value="Tenaga Kependidikan" {{ request('jenis_ptk') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan (TU/Laboran)</option>
                    </select>
                </div>

                <!-- 5. Jenis Guru -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">5. Jenis Guru</label>
                    <select name="jenis_guru" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Jenis Guru</option>
                        <option value="Guru Kelas" {{ request('jenis_guru') == 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
                        <option value="Guru Mapel" {{ (request('jenis_guru') == 'Guru Mapel' || request('jenis_guru') == 'Guru Mata Pelajaran') ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                        <option value="Guru BK" {{ request('jenis_guru') == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                    </select>
                </div>

                <!-- 6. Tingkat Pendidikan -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">6. Tingkat Pendidikan</label>
                    <select name="tingkat_pendidikan" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Tingkat (SMA/S1/S2)</option>
                        <option value="SMA/K" {{ request('tingkat_pendidikan') == 'SMA/K' ? 'selected' : '' }}>SMA/K</option>
                        <option value="D3" {{ request('tingkat_pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1/D4" {{ request('tingkat_pendidikan') == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                        <option value="S2" {{ request('tingkat_pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ request('tingkat_pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <!-- 7. Kelompok Usia -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">7. Kelompok Usia</label>
                    <select name="kelompok_usia" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Kelompok Usia</option>
                        <option value="<30" {{ request('kelompok_usia') == '<30' ? 'selected' : '' }}>&lt; 30 Tahun</option>
                        <option value="31-40" {{ request('kelompok_usia') == '31-40' ? 'selected' : '' }}>31 - 40 Tahun</option>
                        <option value="41-50" {{ request('kelompok_usia') == '41-50' ? 'selected' : '' }}>41 - 50 Tahun</option>
                        <option value=">55" {{ request('kelompok_usia') == '>55' ? 'selected' : '' }}>&gt; 55 Tahun (Pensiun)</option>
                    </select>
                </div>

                <!-- 8. Penugasan / Multi-Sekolah -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">8. Penugasan Sekolah</label>
                    <select name="multi_sekolah" onchange="triggerPegawaiFilter(this)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Penugasan Sekolah</option>
                        <option value="1" {{ (request('multi_sekolah') == '1' || request('multi_sekolah') == 'ya') ? 'selected' : '' }}>&gt; 1 Sekolah (Multi-Sekolah) [{{ $totalMultiSekolahCount ?? 176 }}]</option>
                        <option value="0" {{ (request('multi_sekolah') == '0' || request('multi_sekolah') == 'tidak') ? 'selected' : '' }}>1 Sekolah Saja</option>
                    </select>
                </div>

                <!-- Filter Action Buttons Bar -->
                <div class="col-span-1 sm:col-span-2 md:col-span-4 flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    @if(request('search') || request('status_kepegawaian') || request('jabatan_fungsional') || request('serdik') || request('is_serdik') || request('jenis_ptk') || request('jenis_guru') || request('tingkat_pendidikan') || request('kelompok_usia') || request('multi_sekolah'))
                        <a href="{{ route('pegawai.index') }}" onclick="showLoadingOverlay('Mereset Filter...', 'Mengembalikan daftar master data Pegawai...')" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
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

        <!-- BULK DELETE FLOATING ACTION BAR & DYNAMIC DATA TABLE -->
        <form id="bulkDeleteForm" method="POST" action="{{ route('pegawai.bulk-destroy') }}">
            @csrf
            <div id="bulkActionBar" class="hidden bg-slate-900 text-white rounded-xl px-5 py-3 shadow-xl flex items-center justify-between border border-slate-700 animate-fade-in">
                <div class="flex items-center gap-3 text-xs font-semibold">
                    <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold" id="selectedCountBadge">0</span>
                    <span>Pegawai terpilih untuk dihapus</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="unselectAllCheckboxes()" class="text-xs text-gray-400 hover:text-white px-3 py-1.5 transition">
                        Batal
                    </button>
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh data pegawai terpilih?')" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-md transition flex items-center gap-1.5">
                        <i class="fas fa-trash-can text-xs"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </div>
            </div>

            <!-- PEGAWAI DATA TABLE -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden mt-4">
                
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs text-gray-500 font-bold">
                        Menampilkan {{ isset($pegawais) && method_exists($pegawais, 'total') ? $pegawais->total() : (\App\Models\Pegawai::count()) }} Master Data Pegawai (PTK)
                    </span>
                    @if(request('search') || request('status_kepegawaian') || request('jabatan_fungsional') || request('serdik') || request('is_serdik') || request('jenis_ptk') || request('jenis_guru') || request('tingkat_pendidikan') || request('kelompok_usia') || request('multi_sekolah'))
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full font-bold">
                                <i class="fas fa-check-circle mr-1"></i> Filter Aktif: 
                                @if(request('status_kepegawaian')) Status: {{ request('status_kepegawaian') }} @endif
                                @if(request('jabatan_fungsional')) | Jabatan: {{ request('jabatan_fungsional') }} @endif
                                @if(request('jenis_ptk')) | PTK: {{ request('jenis_ptk') }} @endif
                                @if(request('jenis_guru')) | Guru: {{ request('jenis_guru') }} @endif
                                @if(request('multi_sekolah')) | Penugasan: {{ request('multi_sekolah') == '1' ? '>1 Sekolah (Multi)' : '1 Sekolah' }} @endif
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Table Wrapper -->
                <div class="table-scroll overflow-x-auto">
                    <table class="w-full min-w-[1300px] text-sm text-left">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                            <tr>
                                <th class="px-4 py-3.5 w-10 text-center">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-800 focus:ring-blue-800 cursor-pointer">
                                </th>
                                <th class="px-4 py-3.5">NIP / NIK</th>
                                <th class="px-4 py-3.5">Nama & Profil</th>
                                <th class="px-4 py-3.5">Satuan Pendidikan</th>
                                <th class="px-4 py-3.5">Status</th>
                                <th class="px-4 py-3.5">Jabatan & Jenis</th>
                                <th class="px-4 py-3.5">Serdik</th>
                                <th class="px-4 py-3.5">Pendidikan</th>
                                <th class="px-4 py-3.5">Usia</th>
                                <th class="px-4 py-3.5">Berkas (PDF)</th>
                                <th class="px-4 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if(isset($pegawais) && count($pegawais) > 0)
                                @foreach($pegawais as $pegawai)
                                    <tr class="hover:bg-blue-50/30 transition">
                                        <td class="px-4 py-3.5 text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $pegawai->id }}" class="pegawai-checkbox rounded border-gray-300 text-blue-800 focus:ring-blue-800 cursor-pointer">
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <p class="font-bold text-gray-800 text-xs">{{ $pegawai->nip_nik ?: '-' }}</p>
                                            @if($pegawai->nik && $pegawai->nik !== $pegawai->nip_nik)
                                                <p class="text-[10px] text-gray-400 font-mono">NIK: {{ $pegawai->nik }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                @if($pegawai->photo_profile)
                                                    <img src="{{ $pegawai->profile_picture_url }}" alt="{{ $pegawai->nama_lengkap }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0 border border-gray-200">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-blue-800 text-white font-bold text-xs flex items-center justify-center flex-shrink-0">
                                                        {{ $pegawai->initials }}
                                                     </div>
                                                @endif
                                                <div>
                                                    <p class="font-bold text-gray-900 text-xs">{{ $pegawai->nama_lengkap }}</p>
                                                    <div class="flex items-center gap-1.5 mt-0.5">
                                                        <span class="text-[10px] text-gray-500 font-medium">{{ $pegawai->jenis_ptk }}</span>
                                                        @if($pegawai->pangkat_golongan && $pegawai->pangkat_golongan !== '-')
                                                            <span class="text-[9px] bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded font-semibold">Gol: {{ $pegawai->pangkat_golongan }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-bold text-gray-900">{{ $pegawai->sekolah->nama_sekolah ?? '-' }}</span>
                                                    @if($pegawai->sekolahs->count() > 1)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200" title="Pegawai ini bertugas di {{ $pegawai->sekolahs->count() }} sekolah">
                                                            <i class="fas fa-layer-group text-[9px]"></i>
                                                            {{ $pegawai->sekolahs->count() }} Sekolah
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($pegawai->sekolahs->count() > 1)
                                                    <div class="text-[10px] text-gray-500 space-y-0.5 pt-0.5">
                                                        @foreach($pegawai->sekolahs as $sek)
                                                            @if(!$sek->pivot->is_primary)
                                                                <p class="text-gray-500 flex items-center gap-1">
                                                                    <i class="fas fa-building-columns text-[9px] text-amber-600"></i>
                                                                    <span>{{ $sek->nama_sekolah }}</span>
                                                                </p>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @php
                                                $badgeClasses = match($pegawai->status_kepegawaian) {
                                                    'PNS' => 'bg-blue-100 text-blue-800',
                                                    'PPPK' => 'bg-emerald-100 text-emerald-800',
                                                    'PPPK PW' => 'bg-amber-100 text-amber-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="badge-custom px-2.5 py-1 rounded-full text-[10px] font-bold {{ $badgeClasses }}">
                                                {{ $pegawai->status_kepegawaian }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <p class="text-xs text-gray-800 font-medium">{{ $pegawai->jabatan_fungsional ?: '-' }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $pegawai->jenis_guru ?: '-' }}</p>
                                            @if($pegawai->jumlah_jp)
                                                <p class="text-[9px] text-blue-600 font-semibold">{{ $pegawai->jumlah_jp }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($pegawai->is_serdik)
                                                <span class="badge-custom px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Serdik
                                                </span>
                                                @if($pegawai->no_serdik)
                                                    <p class="text-[9px] text-gray-400 mt-1 font-mono truncate max-w-[120px]" title="No Serdik: {{ $pegawai->no_serdik }}">No: {{ $pegawai->no_serdik }}</p>
                                                @endif
                                            @else
                                                <span class="badge-custom px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Non-Serdik
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <p class="text-xs text-gray-700 font-medium">{{ $pegawai->tingkat_pendidikan }}</p>
                                            @if($pegawai->jurusan_prodi)
                                                <p class="text-[10px] text-gray-400 truncate max-w-[110px]" title="{{ $pegawai->jurusan_prodi }}">{{ $pegawai->jurusan_prodi }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-xs text-gray-700">
                                            {{ $pegawai->usia }} thn
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-1.5 text-xs">
                                                @if(!empty($pegawai->file_sk) && is_array($pegawai->file_sk) && count($pegawai->file_sk) > 0)
                                                    <button type="button" onclick='openFileModal("SK Kepegawaian - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_sk))' class="text-blue-500 hover:text-blue-700 relative group" title="SK Kepegawaian ({{ count($pegawai->file_sk) }} File)">
                                                        <i class="fas fa-images"></i>
                                                        @if(count($pegawai->file_sk) > 1)
                                                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[8px] font-bold px-1 rounded-full leading-none py-[2px]">{{ count($pegawai->file_sk) }}</span>
                                                        @endif
                                                    </button>
                                                @endif
                                                @if(!empty($pegawai->file_serdik) && is_array($pegawai->file_serdik) && count($pegawai->file_serdik) > 0)
                                                    <button type="button" onclick='openFileModal("Sertifikat Pendidik - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_serdik))' class="text-emerald-500 hover:text-emerald-700 relative group" title="Sertifikat Pendidik ({{ count($pegawai->file_serdik) }} File)">
                                                        <i class="fas fa-images"></i>
                                                        @if(count($pegawai->file_serdik) > 1)
                                                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[8px] font-bold px-1 rounded-full leading-none py-[2px]">{{ count($pegawai->file_serdik) }}</span>
                                                        @endif
                                                    </button>
                                                @endif
                                                @if(!empty($pegawai->file_ijazah) && is_array($pegawai->file_ijazah) && count($pegawai->file_ijazah) > 0)
                                                    <button type="button" onclick='openFileModal("Ijazah Terakhir - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_ijazah))' class="text-purple-500 hover:text-purple-700 relative group" title="Ijazah Terakhir ({{ count($pegawai->file_ijazah) }} File)">
                                                        <i class="fas fa-images"></i>
                                                        @if(count($pegawai->file_ijazah) > 1)
                                                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[8px] font-bold px-1 rounded-full leading-none py-[2px]">{{ count($pegawai->file_ijazah) }}</span>
                                                        @endif
                                                    </button>
                                                @endif
                                                @if(empty($pegawai->file_sk) && empty($pegawai->file_serdik) && empty($pegawai->file_ijazah))
                                                    <span class="text-gray-300 text-[10px] italic">Tidak ada</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-800 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route('pegawai.riwayat', $pegawai->id) }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition text-xs" title="Riwayat Perubahan">
                                                    <i class="fas fa-clock-rotate-left"></i>
                                                </a>
                                                <button type="button" onclick="confirmDeletePegawai({{ $pegawai->id }}, '{{ addslashes($pegawai->nama_lengkap) }}')" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-rose-600 hover:text-white flex items-center justify-center transition text-xs text-gray-500" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-users-slash text-3xl mb-2 text-gray-300 block"></i>
                                        <p class="font-semibold text-xs text-gray-500">Belum ada data pegawai terdaftar.</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Klik <a href="{{ url('/pegawai/create') }}" class="text-blue-800 font-bold hover:underline">Tambah Pegawai</a> atau gunakan tombol <button type="button" onclick="openImportModal()" class="text-emerald-600 font-bold hover:underline">Import Data</button> untuk mengunggah file Excel/CSV.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Table Pagination (Matches Custom SIMPEG-SP UI Styling) -->
                @if(isset($pegawais) && method_exists($pegawais, 'hasPages') && $pegawais->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-3.5 bg-gray-50/50 text-center lg:text-left">
                        <span class="text-xs text-gray-500 font-medium text-center lg:text-left">
                            Halaman <span class="font-bold text-gray-800">{{ $pegawais->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $pegawais->lastPage() }}</span> (Menampilkan {{ $pegawais->firstItem() }} - {{ $pegawais->lastItem() }} dari {{ $pegawais->total() }} Data Pegawai)
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
                                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 bg-white rounded-lg transition font-medium border border-gray-200">{{ $page }}</a>
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
                @elseif(isset($pegawais) && method_exists($pegawais, 'total'))
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <span class="text-xs text-gray-500 font-medium">Menampilkan {{ $pegawais->total() }} Data Pegawai</span>
                    </div>
                @endif

            </div>
        </form>

    </div>

    <!-- Script triggers for Loading Overlay -->
    <script>
        function triggerPegawaiFilter(el) {
            showLoadingOverlay('Memproses Filter Pegawai...', 'Menyaring master data Pendidik & Tenaga Kependidikan berdasarkan kriteria...');
            if (el && el.form) {
                el.form.submit();
            } else {
                const form = document.getElementById('pegawaiFilterForm');
                if (form) form.submit();
            }
        }

        function handlePegawaiSubmit(e) {
            showLoadingOverlay('Mencari Data Pegawai...', 'Sistem sedang melakukan pencarian kata kunci...');
        }
    </script>

    <!-- Hidden Single Delete Form -->
    <form id="singleDeleteForm" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- ===== IMPORT DATA MODAL (POPUP) ===== -->
    <div id="importModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 scale-95" id="importModalCard">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-950 to-indigo-900 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-emerald-400 border border-white/15">
                        <i class="fas fa-file-import text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white">Import Data Pegawai</h3>
                        <p class="text-[11px] text-blue-200 opacity-80">Upload File Excel (.xlsx, .xls) atau CSV (.csv)</p>
                    </div>
                </div>
                <button type="button" onclick="closeImportModal()" class="text-blue-200 hover:text-white text-lg w-7 h-7 rounded-lg hover:bg-white/10 flex items-center justify-center transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                
                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-900 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-blue-600"></i> Petunjuk Import Data:
                    </p>
                    <ul class="list-disc list-inside text-[11px] space-y-0.5 text-blue-800">
                        <li>Gunakan template resmi untuk menyesuaikan kolom data.</li>
                        <li>Kolom <strong>NIP_NIK</strong> &amp; <strong>Nama_Lengkap</strong> wajib diisi.</li>
                        <li>Jika NPSN diisi, sistem akan mencocokkan sekolah secara otomatis.</li>
                    </ul>
                </div>

                <!-- Template Download Banner inside Modal -->
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-200 text-xs">
                    <span class="text-gray-600 font-medium">Belum punya format template?</span>
                    <a href="{{ route('pegawai.template') }}" class="text-xs font-bold text-blue-800 hover:text-blue-950 flex items-center gap-1">
                        <i class="fas fa-download text-[10px]"></i> Unduh Template
                    </a>
                </div>

                <!-- File Upload Box -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih File Import (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" accept=".csv,.xlsx,.xls,.txt" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-100 file:text-blue-800 hover:file:bg-blue-200 cursor-pointer">
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2 rounded-xl shadow-md transition flex items-center gap-2">
                        <i class="fas fa-cloud-arrow-up text-xs"></i>
                        <span>Upload &amp; Proses Import</span>
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    
    <!-- Modal Preview Berkas -->
    <div id="filePreviewModal" class="hidden fixed inset-0 flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm animate-fadeIn" style="z-index: 99999 !important;">
        <div class="bg-white rounded-2xl w-full max-w-3xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-sm font-bold text-gray-800" id="filePreviewTitle">Preview Berkas</h3>
                <button onclick="closeFileModal()" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <!-- Body -->
            <div class="p-6 overflow-y-auto flex-1 bg-gray-50/30">
                <div id="filePreviewContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Content generated by JS -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openImportModal() {
                const modal = document.getElementById('importModal');
                const card = document.getElementById('importModalCard');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }, 10);
            }

            function closeImportModal() {
                const modal = document.getElementById('importModal');
                const card = document.getElementById('importModalCard');
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 150);
            }

            function confirmDeletePegawai(id, name) {
                if (confirm(`Apakah Anda yakin ingin menghapus data pegawai "${name}"?`)) {
                    const form = document.getElementById('singleDeleteForm');
                    form.action = `/pegawai/${id}`;
                    form.submit();
                }
            }

            // Checkbox selection handler for Bulk Delete
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.pegawai-checkbox');
                const bulkActionBar = document.getElementById('bulkActionBar');
                const selectedCountBadge = document.getElementById('selectedCountBadge');

                function updateBulkBar() {
                    const checked = document.querySelectorAll('.pegawai-checkbox:checked');
                    const count = checked.length;
                    if (count > 0) {
                        bulkActionBar.classList.remove('hidden');
                        selectedCountBadge.textContent = count;
                    } else {
                        bulkActionBar.classList.add('hidden');
                    }
                    if (selectAll) {
                        selectAll.checked = (checkboxes.length > 0 && checked.length === checkboxes.length);
                    }
                }

                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = this.checked);
                        updateBulkBar();
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', updateBulkBar);
                });

                window.unselectAllCheckboxes = function() {
                    if (selectAll) selectAll.checked = false;
                    checkboxes.forEach(cb => cb.checked = false);
                    updateBulkBar();
                };
            });

            function triggerPegawaiFilter(elem) {
                const form = document.getElementById('pegawaiFilterForm');
                if (form) {
                    if (typeof showLoadingOverlay === 'function') {
                        showLoadingOverlay('Memproses Filter Pegawai...', 'Sistem sedang menyaring data pegawai...');
                    }
                    form.submit();
                }
            }

            function handlePegawaiSubmit(e) {
                if (typeof showLoadingOverlay === 'function') {
                    showLoadingOverlay('Memproses Filter Pegawai...', 'Sistem sedang menyaring data pegawai...');
                }
            }

            // Preview Berkas
            // Modal Logics
            window.openFileModal = function(title, files) {
                const modal = document.getElementById('filePreviewModal');
                if (!modal) return;

                // Move modal to body root to avoid parent z-index stacking issues
                document.body.appendChild(modal);

                document.getElementById('filePreviewTitle').innerText = title;
                const container = document.getElementById('filePreviewContainer');
                container.innerHTML = '';
                
                if (files && files.length > 0) {
                    files.forEach(file => {
                        const url = '{{ asset("storage") }}/' + file;
                        container.innerHTML += `
                            <div class="group relative rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all">
                                <a href="${url}" target="_blank" class="block">
                                    <img src="${url}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-[10px] font-bold bg-blue-600/80 px-3 py-1.5 rounded-full backdrop-blur-sm shadow-lg"><i class="fas fa-external-link-alt mr-1"></i> Buka Penuh</span>
                                    </div>
                                </a>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-xs text-gray-400 py-8 italic">Tidak ada berkas</div>';
                }
                
                modal.classList.remove('hidden');
            };

            window.closeFileModal = function() {
                const modal = document.getElementById('filePreviewModal');
                if (modal) modal.classList.add('hidden');
            };
        </script>
    @endpush
@endsection
