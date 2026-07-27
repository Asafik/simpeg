@extends('layouts.app')

@section('title', 'Detail Pegawai - ' . ($pegawai->nama_lengkap ?? 'SIMPEG-SP'))

@section('content')
    <!-- ===== HERO BLUE BANNER (Hope UI Deep Blue Design) ===== -->
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
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('pegawai.index') }}" class="hover:underline">Data Pegawai</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>Detail Profil</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">{{ $pegawai->nama_lengkap ?? 'Detail Pegawai' }}</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Rincian data kepegawaian resmi dan berkas terverifikasi Dinas Pendidikan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('pegawai.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-print"></i> Cetak Profil
                </button>
                @if(isset($pegawai->id))
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm transition flex items-center gap-1.5">
                        <i class="fas fa-pen"></i> Edit Profil
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 w-full -mt-8 relative z-20">
        
        <!-- PROFILE SUMMARY CARD -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                @php
                    $words = explode(' ', $pegawai->nama_lengkap ?? 'P T');
                    $initials = strtoupper(substr($words[0] ?? 'P', 0, 1) . substr($words[1] ?? 'T', 0, 1));
                    $badgeClasses = match($pegawai->status_kepegawaian ?? '') {
                        'PNS' => 'bg-blue-100 text-blue-800',
                        'PPPK' => 'bg-emerald-100 text-emerald-800',
                        'PPPK PW' => 'bg-amber-100 text-amber-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <div class="w-16 h-16 rounded-2xl bg-blue-800 text-white text-2xl font-extrabold flex items-center justify-center shadow-lg shadow-blue-900/30">
                    {{ $initials }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-lg font-bold text-gray-900">{{ $pegawai->nama_lengkap }}</h2>
                        <span class="badge-custom px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeClasses }}">
                            {{ $pegawai->status_kepegawaian ?? '-' }}
                        </span>
                        @if($pegawai->is_serdik)
                            <span class="badge-custom bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-check-circle mr-1"></i>Serdik
                            </span>
                        @else
                            <span class="badge-custom bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-times-circle mr-1"></i>Non-Serdik
                            </span>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-gray-500 mt-1">
                        NIP: <span class="font-mono text-gray-800">{{ $pegawai->nip_nik ?: '-' }}</span>
                        @if($pegawai->nik)
                            • NIK: <span class="font-mono text-gray-800">{{ $pegawai->nik }}</span>
                        @endif
                        • {{ $pegawai->sekolah->nama_sekolah ?? '-' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Jabatan: <span class="font-medium text-gray-700">{{ $pegawai->jabatan_fungsional ?: '-' }}</span>
                        @if($pegawai->pangkat_golongan && $pegawai->pangkat_golongan !== '-')
                            <span class="bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded text-[10px] font-bold ml-1">Gol: {{ $pegawai->pangkat_golongan }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="text-right border-l border-gray-100 pl-6 hidden sm:block">
                <p class="text-xs text-gray-400">Satuan Pendidikan</p>
                <p class="text-xs font-bold text-gray-800 mt-0.5">{{ $pegawai->sekolah->nama_sekolah ?? '-' }}</p>
                <p class="text-[10px] text-gray-400">NPSN: {{ $pegawai->sekolah->npsn ?? '-' }}</p>
            </div>
        </div>

        <!-- 1. RINCIAN KEPEGAWAIAN RESMI (DINAMIS SESUAI DATABASE) -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-id-card"></i> Data Status Kepegawaian & Jabatan Fungsional
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs">
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Status Kepegawaian</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->status_kepegawaian ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Pangkat / Golongan</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->pangkat_golongan ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jabatan Fungsional</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->jabatan_fungsional ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">No. SK Jabfung</p>
                    <p class="font-mono font-semibold text-gray-800 mt-0.5 truncate" title="{{ $pegawai->no_sk_jabfung }}">{{ $pegawai->no_sk_jabfung ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">TMT Jabfung</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->tmt_jabfung ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Status Serdik</p>
                    <p class="font-bold {{ $pegawai->is_serdik ? 'text-emerald-600' : 'text-red-600' }} mt-0.5">
                        {{ $pegawai->is_serdik ? 'SERDIK (Bersertifikasi)' : 'NON-SERDIK' }}
                    </p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Nomor Serdik</p>
                    <p class="font-mono text-gray-800 mt-0.5 truncate" title="{{ $pegawai->no_serdik }}">{{ $pegawai->no_serdik ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Tanggal Serdik</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->tgl_serdik ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 2. TUGAS, PTK & PENGAJARAN -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-chalkboard-user"></i> Data PTK & Penugasan Mengajar
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs">
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jenis PTK</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->jenis_ptk ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jenis Guru / Tugas</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->jenis_guru ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jumlah JP Mengajar</p>
                    <p class="font-bold text-blue-600 mt-0.5">{{ $pegawai->jumlah_jp ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">NUPTK</p>
                    <p class="font-mono font-semibold text-gray-800 mt-0.5">{{ $pegawai->nuptk ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 3. PENDIDIKAN & BIODATA PRIBADI -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-graduation-cap"></i> Pendidikan & Informasi Pribadi
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs">
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Tingkat Pendidikan</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->tingkat_pendidikan ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jurusan / Program Studi</p>
                    <p class="font-bold text-gray-800 mt-0.5 truncate" title="{{ $pegawai->jurusan_prodi }}">{{ $pegawai->jurusan_prodi ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Tempat Lahir</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->tempat_lahir ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Tanggal Lahir</p>
                    <p class="font-bold text-gray-800 mt-0.5">
                        {{ $pegawai->tanggal_lahir ? Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Usia Pegawai</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->usia ?? '-' }} Tahun</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Jenis Kelamin</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->jenis_kelamin ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Agama</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->agama ?: '-' }}</p>
                </div>
                <div class="p-3 bg-gray-50/80 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-medium uppercase">Kecamatan Sekolah</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $pegawai->sekolah->kecamatan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 4. PREVIEW BERKAS TERLAMPIR (SK, SERDIK, IJAZAH) -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-folder-open"></i> Berkas PDF Lampiran Terunggah
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <!-- Card Berkas 1: SK -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $pegawai->file_sk ? 'bg-red-100 text-red-600' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">SK Kepegawaian</p>
                            <p class="text-[10px] {{ $pegawai->file_sk ? 'text-emerald-600 font-semibold' : 'text-gray-400' }}">
                                {{ $pegawai->file_sk ? 'Terunggah' : 'Belum diunggah' }}
                            </p>
                        </div>
                    </div>
                    @if($pegawai->file_sk)
                        <a href="{{ asset('storage/' . $pegawai->file_sk) }}" target="_blank" class="w-full py-2 bg-blue-800 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center justify-center gap-1">
                            <i class="fas fa-eye"></i> View SK PDF
                        </a>
                    @else
                        <button disabled class="w-full py-2 bg-gray-200 text-gray-400 rounded-lg text-xs font-semibold cursor-not-allowed">
                            Belum Ada File
                        </button>
                    @endif
                </div>

                <!-- Card Berkas 2: Serdik -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $pegawai->file_serdik ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Sertifikat Pendidik</p>
                            <p class="text-[10px] {{ $pegawai->file_serdik ? 'text-emerald-600 font-semibold' : 'text-gray-400' }}">
                                {{ $pegawai->file_serdik ? 'Terunggah' : 'Belum diunggah' }}
                            </p>
                        </div>
                    </div>
                    @if($pegawai->file_serdik)
                        <a href="{{ asset('storage/' . $pegawai->file_serdik) }}" target="_blank" class="w-full py-2 bg-emerald-700 text-white rounded-lg text-xs font-semibold hover:bg-emerald-800 transition flex items-center justify-center gap-1">
                            <i class="fas fa-eye"></i> View Serdik PDF
                        </a>
                    @else
                        <button disabled class="w-full py-2 bg-gray-200 text-gray-400 rounded-lg text-xs font-semibold cursor-not-allowed">
                            Belum Ada File
                        </button>
                    @endif
                </div>

                <!-- Card Berkas 3: Ijazah -->
                <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between space-y-3 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $pegawai->file_ijazah ? 'bg-blue-100 text-blue-600' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Ijazah Terakhir</p>
                            <p class="text-[10px] {{ $pegawai->file_ijazah ? 'text-emerald-600 font-semibold' : 'text-gray-400' }}">
                                {{ $pegawai->file_ijazah ? 'Terunggah' : 'Belum diunggah' }}
                            </p>
                        </div>
                    </div>
                    @if($pegawai->file_ijazah)
                        <a href="{{ asset('storage/' . $pegawai->file_ijazah) }}" target="_blank" class="w-full py-2 bg-blue-800 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center justify-center gap-1">
                            <i class="fas fa-eye"></i> View Ijazah PDF
                        </a>
                    @else
                        <button disabled class="w-full py-2 bg-gray-200 text-gray-400 rounded-lg text-xs font-semibold cursor-not-allowed">
                            Belum Ada File
                        </button>
                    @endif
                </div>

            </div>
        </div>

    </div>
@endsection
