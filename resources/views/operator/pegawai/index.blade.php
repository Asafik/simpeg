@extends('layouts.app')

@section('title', 'Data Pegawai - ' . ($sekolah->nama_sekolah ?? 'Operator Sekolah'))

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Hope UI Design - Operator Palette) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGradOpIndex1)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGradOpIndex2)"></path>
            <defs>
                <linearGradient id="hopeWaveGradOpIndex1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.5" />
                    <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.3" />
                </linearGradient>
                <linearGradient id="hopeWaveGradOpIndex2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#030712" stop-opacity="0.8" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>
        
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-blue-800/60 border border-blue-400/30 text-blue-200 text-xs px-3 py-1 rounded-full mb-2 backdrop-blur-md">
                    <i class="fas fa-school text-xs"></i>
                    <span>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan' }} (NPSN: {{ $sekolah->npsn ?? '-' }})</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Data Pegawai Sekolah</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola data Aparatur Sipil Negara & Tenaga Kependidikan internal di <strong>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan Anda' }}</strong>.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('operator.pegawai.create') }}" class="bg-white text-blue-950 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                    <i class="fas fa-plus text-xs text-blue-800"></i>
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

    <!-- Main Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">

        <!-- Flash Messages Alert -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- 7 KRITERIA MULTI-FILTER BAR -->
        <form method="GET" action="{{ route('operator.pegawai.index') }}" class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Multi-Filter Kombinasi Data Pegawai
                </h3>
                <div class="flex items-center gap-2">
                    <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm transition flex items-center gap-1.5">
                        <i class="fas fa-search text-[10px]"></i> Apply Filter
                    </button>
                    <a href="{{ route('operator.pegawai.index') }}" class="text-xs text-gray-400 hover:text-red-500 font-semibold transition px-2 py-1">
                        <i class="fas fa-rotate-right mr-1"></i> Reset
                    </a>
                </div>
            </div>

            <!-- Filter Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-3">
                <!-- Search Keyword -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari NIP / NIK / Nama</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau NIP..." class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>

                <!-- 1. Status Kepegawaian -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">1. Status Kepegawaian</label>
                    <select name="status_kepegawaian" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="PPPK PW" {{ request('status_kepegawaian') == 'PPPK PW' ? 'selected' : '' }}>PPPK PW (Paruh Waktu)</option>
                        <option value="Non-ASN" {{ request('status_kepegawaian') == 'Non-ASN' ? 'selected' : '' }}>Non-ASN</option>
                    </select>
                </div>

                <!-- 2. Jabatan Fungsional -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">2. Jabatan Fungsional</label>
                    <select name="jabatan_fungsional" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Jabatan</option>
                        @foreach($jabatanList as $jbt)
                            <option value="{{ $jbt }}" {{ request('jabatan_fungsional') == $jbt ? 'selected' : '' }}>{{ $jbt }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Sertifikasi Pendidik (Serdik) -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">3. Sertifikasi (Serdik)</label>
                    <select name="is_serdik" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Status Serdik</option>
                        <option value="1" {{ request('is_serdik') === '1' ? 'selected' : '' }}>Sudah Serdik</option>
                        <option value="0" {{ request('is_serdik') === '0' ? 'selected' : '' }}>Belum Serdik</option>
                    </select>
                </div>

                <!-- 4. Jenis PTK -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">4. Jenis PTK</label>
                    <select name="jenis_ptk" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua PTK</option>
                        <option value="Pendidik" {{ request('jenis_ptk') == 'Pendidik' ? 'selected' : '' }}>Pendidik (Guru)</option>
                        <option value="Tenaga Kependidikan" {{ request('jenis_ptk') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan (TU/Laboran)</option>
                    </select>
                </div>

                <!-- 5. Jenis Guru -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">5. Jenis Guru</label>
                    <select name="jenis_guru" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Jenis Guru</option>
                        <option value="Guru Kelas" {{ request('jenis_guru') == 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
                        <option value="Guru Mata Pelajaran" {{ request('jenis_guru') == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                        <option value="Guru BK" {{ request('jenis_guru') == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                    </select>
                </div>

                <!-- 6. Tingkat Pendidikan -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">6. Tingkat Pendidikan</label>
                    <select name="tingkat_pendidikan" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
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
                    <select name="kelompok_usia" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Kelompok Usia</option>
                        <option value="<30" {{ request('kelompok_usia') == '<30' ? 'selected' : '' }}>&lt; 30 Tahun</option>
                        <option value="30-40" {{ request('kelompok_usia') == '30-40' ? 'selected' : '' }}>30 - 40 Tahun</option>
                        <option value="41-50" {{ request('kelompok_usia') == '41-50' ? 'selected' : '' }}>41 - 50 Tahun</option>
                        <option value=">50" {{ request('kelompok_usia') == '>50' ? 'selected' : '' }}>&gt; 50 Tahun</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- BULK DELETE FLOATING ACTION BAR -->
        <form id="bulkDeleteForm" method="POST" action="{{ route('operator.pegawai.bulk-destroy') }}">
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
                    <span class="text-xs font-bold text-gray-700">
                        @if(isset($pegawais) && method_exists($pegawais, 'total'))
                            Menampilkan {{ $pegawais->firstItem() ?? 0 }} - {{ $pegawais->lastItem() ?? 0 }} dari {{ $pegawais->total() }} Data Pegawai ({{ $sekolah->nama_sekolah ?? 'Sekolah' }})
                        @else
                            Menampilkan Data Pegawai
                        @endif
                    </span>
                    <div class="text-xs text-gray-400">
                        <span class="font-medium text-gray-600">Urutkan:</span> Terbaru Dibuat
                    </div>
                </div>

                <!-- Table Wrapper -->
                <div class="table-scroll overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                            <tr>
                                <th class="px-4 py-3.5 w-10 text-center">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-800 focus:ring-blue-800 cursor-pointer">
                                </th>
                                <th class="px-4 py-3.5">NIP / NIK</th>
                                <th class="px-4 py-3.5">Nama & Profil</th>
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
                                                @php
                                                    $words = explode(' ', $pegawai->nama_lengkap ?? 'P T');
                                                    $initials = strtoupper(substr($words[0] ?? 'P', 0, 1) . substr($words[1] ?? 'T', 0, 1));
                                                @endphp
                                                <div class="w-8 h-8 rounded-full bg-blue-800 text-white font-bold text-xs flex items-center justify-center flex-shrink-0">
                                                    {{ $initials }}
                                                </div>
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
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($pegawai->is_serdik)
                                                <span class="badge-custom px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Serdik
                                                </span>
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
                                                @php
                                                    $skPath = is_array($pegawai->file_sk) ? ($pegawai->file_sk[0] ?? null) : $pegawai->file_sk;
                                                    $serdikPath = is_array($pegawai->file_serdik) ? ($pegawai->file_serdik[0] ?? null) : $pegawai->file_serdik;
                                                    $ijazahPath = is_array($pegawai->file_ijazah) ? ($pegawai->file_ijazah[0] ?? null) : $pegawai->file_ijazah;
                                                @endphp
                                                @if($skPath)
                                                    <a href="{{ asset('files/' . $skPath) }}" target="_blank" class="text-red-500 hover:text-red-700" title="SK Kepegawaian"><i class="fas fa-file-pdf"></i></a>
                                                @endif
                                                @if($serdikPath)
                                                    <a href="{{ asset('files/' . $serdikPath) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800" title="Sertifikat Pendidik"><i class="fas fa-file-pdf"></i></a>
                                                @endif
                                                @if($ijazahPath)
                                                    <a href="{{ asset('files/' . $ijazahPath) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Ijazah Terakhir"><i class="fas fa-file-pdf"></i></a>
                                                @endif
                                                @if(!$skPath && !$serdikPath && !$ijazahPath)
                                                    <span class="text-gray-300 text-[10px] italic">Tidak ada</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('operator.pegawai.show', $pegawai->id) }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-800 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('operator.pegawai.edit', $pegawai->id) }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                                    <i class="fas fa-pen"></i>
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
                                    <td colspan="10" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-users-slash text-3xl mb-2 text-gray-300 block"></i>
                                        <p class="font-semibold text-xs text-gray-500">Belum ada data pegawai terdaftar di {{ $sekolah->nama_sekolah ?? 'sekolah ini' }}.</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Klik <a href="{{ route('operator.pegawai.create') }}" class="text-blue-800 font-bold hover:underline">Tambah Pegawai</a> atau gunakan tombol <button type="button" onclick="openImportModal()" class="text-emerald-600 font-bold hover:underline">Import Data</button> untuk mengunggah file Excel.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Table Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    @if(isset($pegawais) && method_exists($pegawais, 'links'))
                        {{ $pegawais->links() }}
                    @endif
                </div>
            </div>
        </form>
    </div>

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
                        <h3 class="font-bold text-sm">Import Data Pegawai (Excel)</h3>
                        <p class="text-[10px] text-blue-200">{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan' }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeImportModal()" class="text-gray-300 hover:text-white p-1 transition"><i class="fas fa-xmark text-lg"></i></button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="sekolah_id" value="{{ $sekolah->id ?? '' }}">
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-900 flex items-start gap-2.5">
                    <i class="fas fa-circle-info text-blue-600 text-sm mt-0.5 flex-shrink-0"></i>
                    <div class="leading-relaxed">
                        <p class="font-bold">Informasi Import:</p>
                        <p class="text-[11px] text-blue-800">Unggah berkas Excel (.xlsx / .xls). Data otomatis dikelompokkan ke <strong>{{ $sekolah->nama_sekolah ?? 'Sekolah Anda' }}</strong>.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file" name="file_excel" required accept=".xlsx, .xls" class="w-full text-xs text-gray-600 bg-gray-50 rounded-xl border border-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 transition">Batal</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2 rounded-lg shadow-md transition flex items-center gap-1.5">
                        <i class="fas fa-upload"></i> Unggah & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.pegawai-checkbox');
        const bulkActionBar = document.getElementById('bulkActionBar');
        const selectedCountBadge = document.getElementById('selectedCountBadge');

        function updateBulkBar() {
            const checked = document.querySelectorAll('.pegawai-checkbox:checked');
            if (checked.length > 0) {
                bulkActionBar.classList.remove('hidden');
                selectedCountBadge.innerText = checked.length;
            } else {
                bulkActionBar.classList.add('hidden');
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkBar();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                updateBulkBar();
            });
        });
    });

    function unselectAllCheckboxes() {
        document.querySelectorAll('.pegawai-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        document.getElementById('bulkActionBar').classList.add('hidden');
    }

    function confirmDeletePegawai(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus data pegawai "${name}"?`)) {
            const form = document.getElementById('singleDeleteForm');
            form.action = `/operator/pegawai/${id}`;
            form.submit();
        }
    }

    function openImportModal() {
        document.getElementById('importModal').classList.remove('hidden');
    }

    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
    }
</script>
@endpush
