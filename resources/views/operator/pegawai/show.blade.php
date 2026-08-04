@extends('layouts.app')

@section('title', 'Detail Pegawai - ' . ($pegawai->nama_lengkap ?? 'SIMPEG-SP'))

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('operator.pegawai.index') }}" class="hover:underline">Data Pegawai</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>Detail Profil Pegawai</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">{{ $pegawai->nama_lengkap ?? 'Detail Pegawai' }}</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Rincian data kepegawaian di <strong>{{ $pegawai->sekolah->nama_sekolah ?? 'Satuan Pendidikan' }}</strong>.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('operator.pegawai.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fas fa-print"></i> Cetak
                </button>
                @if(isset($pegawai->id))
                    <a href="{{ route('operator.pegawai.edit', $pegawai->id) }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm transition flex items-center gap-1.5">
                        <i class="fas fa-pen"></i> Edit Profil
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
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
                        NIP/NIK: <span class="font-mono text-gray-800">{{ $pegawai->nip_nik ?: '-' }}</span>
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

            <div class="flex items-center gap-2">
                <a href="{{ route('operator.pegawai.edit', $pegawai->id) }}" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            </div>
        </div>

        <!-- DETAIL GRID CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Kepegawaian & Tugas -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-id-card text-blue-800"></i>
                    Informasi Kepegawaian & Tugas
                </h3>
                <dl class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <dt class="text-gray-400 font-medium">Status Kepegawaian</dt>
                        <dd class="font-bold text-gray-800 mt-0.5">{{ $pegawai->status_kepegawaian }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Pangkat / Golongan</dt>
                        <dd class="font-bold text-gray-800 mt-0.5">{{ $pegawai->pangkat_golongan ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Jabatan Fungsional</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->jabatan_fungsional ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Jenis PTK</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->jenis_ptk }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Jenis Guru</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->jenis_guru ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">NUPTK</dt>
                        <dd class="font-mono font-semibold text-gray-800 mt-0.5">{{ $pegawai->nuptk ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Card Biodata & Pendidikan -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-user-graduate text-blue-800"></i>
                    Biodata Diri & Pendidikan
                </h3>
                <dl class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <dt class="text-gray-400 font-medium">Tingkat Pendidikan</dt>
                        <dd class="font-bold text-gray-800 mt-0.5">{{ $pegawai->tingkat_pendidikan }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Jurusan / Prodi</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->jurusan_prodi ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Tempat, Tgl Lahir</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">
                            {{ $pegawai->tempat_lahir ?: '-' }}, {{ optional($pegawai->tanggal_lahir)->format('d M Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Usia</dt>
                        <dd class="font-bold text-gray-800 mt-0.5">{{ $pegawai->usia }} Tahun</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Jenis Kelamin</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->jenis_kelamin ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 font-medium">Agama</dt>
                        <dd class="font-semibold text-gray-800 mt-0.5">{{ $pegawai->agama ?: '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- CARD DOKUMEN BERKAS -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fas fa-file-pdf text-rose-600"></i>
                Berkas Dokumen Terlampir
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <!-- File SK -->
                <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-pdf text-rose-500 text-xl"></i>
                        <div>
                            <p class="font-bold text-gray-800">SK Kepegawaian</p>
                            <p class="text-[10px] text-gray-400">{{ $pegawai->file_sk ? 'Ter-upload' : 'Belum diunggah' }}</p>
                        </div>
                    </div>
                    @if($pegawai->file_sk)
                        <a href="{{ asset('files/' . $pegawai->file_sk) }}" target="_blank" class="bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-3 py-1.5 rounded-lg border border-rose-200 transition">Lihat</a>
                    @endif
                </div>

                <!-- File Serdik -->
                <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-pdf text-emerald-600 text-xl"></i>
                        <div>
                            <p class="font-bold text-gray-800">Sertifikat Pendidik</p>
                            <p class="text-[10px] text-gray-400">{{ $pegawai->file_serdik ? 'Ter-upload' : 'Belum diunggah' }}</p>
                        </div>
                    </div>
                    @if($pegawai->file_serdik)
                        <a href="{{ asset('files/' . $pegawai->file_serdik) }}" target="_blank" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-lg border border-emerald-200 transition">Lihat</a>
                    @endif
                </div>

                <!-- File Ijazah -->
                <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-pdf text-blue-600 text-xl"></i>
                        <div>
                            <p class="font-bold text-gray-800">Ijazah Terakhir</p>
                            <p class="text-[10px] text-gray-400">{{ $pegawai->file_ijazah ? 'Ter-upload' : 'Belum diunggah' }}</p>
                        </div>
                    </div>
                    @if($pegawai->file_ijazah)
                        <a href="{{ asset('files/' . $pegawai->file_ijazah) }}" target="_blank" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold px-3 py-1.5 rounded-lg border border-blue-200 transition">Lihat</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
