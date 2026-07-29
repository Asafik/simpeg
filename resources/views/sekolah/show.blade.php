@extends('layouts.app')

@section('title', 'Detail ' . $sekolah->nama_sekolah . ' - SIMPEG-SP')

@section('content')
    <!-- Reusable Loading Overlay Component -->
    @include('components.loading-overlay', [
        'id' => 'sekolahDetailOverlay',
        'title' => 'Memuat Detail Sekolah...',
        'subtitle' => 'Mohon tunggu sebentar, sistem sedang memproses data.'
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
            <div class="max-w-2xl space-y-1">
                <div class="flex items-center gap-2 text-blue-200 text-xs mb-1">
                    <a href="{{ route('sekolah.index') }}" class="hover:underline opacity-80">Kelola Sekolah</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="font-semibold text-white">Detail Satuan Pendidikan</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                    <span>{{ $sekolah->nama_sekolah }}</span>
                </h2>
                <div class="flex flex-wrap items-center gap-2 text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-800/80 border border-blue-600 font-mono font-bold text-white">
                        NPSN: {{ $sekolah->npsn }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 font-semibold text-blue-100">
                        <i class="fas fa-location-dot mr-1"></i>Kecamatan {{ $sekolah->kecamatan }}
                    </span>
                    @if(($sekolah->status_kepala_sekolah ?? 'Definitif') === 'Plt')
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400 text-amber-300 font-bold">
                            Plt. Kepala Sekolah
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400 text-emerald-300 font-bold">
                            Kepsek Definitif
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('sekolah.edit', $sekolah->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition">
                    <i class="fas fa-pen text-xs"></i>
                    <span>Edit Sekolah</span>
                </a>
                <form action="{{ route('sekolah.destroy', $sekolah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sekolah {{ $sekolah->nama_sekolah }}? Data yang dihapus tidak dapat dikembalikan.')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600/90 hover:bg-red-700 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition">
                        <i class="fas fa-trash text-xs"></i>
                        <span>Hapus</span>
                    </button>
                </form>
                <a href="{{ route('sekolah.index') }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition backdrop-blur-md">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">
        
        <!-- 4 Summary Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 -mt-12 md:-mt-14 mb-6 relative z-20">
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                    <i class="fas fa-users text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Pegawai Terdaftar</p>
                    <p class="text-xl font-extrabold text-gray-900 mt-0.5">{{ $sekolah->pegawais->count() }} PTK</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                    <i class="fas fa-user-tie text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Status Kepsek</p>
                    <p class="text-sm font-extrabold text-gray-900 mt-0.5">{{ $sekolah->status_kepala_sekolah ?? 'Definitif' }}</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full border-2 border-indigo-500 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50/50 flex-shrink-0">
                    <i class="fas fa-location-dot text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Wilayah Kecamatan</p>
                    <p class="text-sm font-extrabold text-gray-900 mt-0.5">{{ $sekolah->kecamatan }}</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full border-2 border-amber-500 flex items-center justify-center text-amber-600 font-bold bg-amber-50/50 flex-shrink-0">
                    <i class="fas fa-clock-rotate-left text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Update Terakhir</p>
                    <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $sekolah->updated_at ? $sekolah->updated_at->diffForHumans() : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Cards Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Info Card -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-md p-6 space-y-4 h-fit">
                <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-circle-info"></i> Informasional Satuan Pendidikan
                    </h3>
                    <a href="{{ route('sekolah.edit', $sekolah->id) }}" class="text-xs text-blue-800 hover:underline font-bold">
                        Edit Profil
                    </a>
                </div>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <p class="text-gray-400 font-medium">Nama Satuan Pendidikan</p>
                        <p class="text-gray-900 font-bold text-sm mt-0.5">{{ $sekolah->nama_sekolah }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">NPSN (Nomor Pokok Sekolah Nasional)</p>
                        <p class="text-blue-800 font-mono font-bold text-sm mt-0.5">{{ $sekolah->npsn }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">Tingkatan / Jenjang</p>
                        <div class="mt-1">
                            @php
                                $tingkatanBadge = match($sekolah->tingkatan) {
                                    'TK' => 'bg-pink-100 text-pink-800',
                                    'SD' => 'bg-sky-100 text-sky-800',
                                    'SMP' => 'bg-violet-100 text-violet-800',
                                    'SMA' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                                $tingkatanLabel = match($sekolah->tingkatan) {
                                    'TK' => 'TK (Taman Kanak-Kanak)',
                                    'SD' => 'SD (Sekolah Dasar)',
                                    'SMP' => 'SMP (Sekolah Menengah Pertama)',
                                    'SMA' => 'SMA (Sekolah Menengah Atas)',
                                    default => $sekolah->tingkatan ?? '-',
                                };
                            @endphp
                            <span class="badge-custom {{ $tingkatanBadge }} font-bold text-[10px]">{{ $tingkatanLabel }}</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">Kecamatan</p>
                        <p class="text-gray-800 font-bold mt-0.5">
                            <i class="fas fa-location-dot text-blue-800 mr-1"></i>{{ $sekolah->kecamatan }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">Email Resmi Sekolah</p>
                        <p class="text-gray-800 font-semibold mt-0.5">
                            <i class="fas fa-envelope text-gray-400 mr-1"></i>{{ $sekolah->email_sekolah ?? 'Belum diisi' }}
                        </p>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <p class="text-gray-400 font-medium">Nama Kepala Sekolah</p>
                        <p class="text-gray-900 font-bold mt-0.5">{{ $sekolah->nama_kepala_sekolah ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">NIP Kepala Sekolah</p>
                        <p class="text-gray-700 font-mono font-semibold mt-0.5">{{ $sekolah->nip_kepala_sekolah ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400 font-medium">Status Kepemimpinan</p>
                        <div class="mt-1">
                            @if(($sekolah->status_kepala_sekolah ?? 'Definitif') === 'Plt')
                                <span class="badge-custom bg-amber-100 text-amber-800 font-bold text-[10px]">Plt. Kepala Sekolah</span>
                            @else
                                <span class="badge-custom bg-emerald-100 text-emerald-800 font-bold text-[10px]">Kepsek Definitif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Card: Daftar Pegawai (PTK) Terdaftar -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200/80 shadow-md overflow-hidden space-y-4">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-users text-blue-800"></i> Daftar Pendidik &amp; Tenaga Kependidikan ({{ $sekolah->pegawais->count() }})
                    </h3>
                    <a href="{{ url('/pegawai/create') }}" class="text-xs text-blue-800 hover:underline font-bold flex items-center gap-1">
                        <i class="fas fa-plus text-[10px]"></i> Tambah Pegawai
                    </a>
                </div>

                <div class="table-scroll overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                            <tr>
                                <th class="px-4 py-3.5">NIP / NIK</th>
                                <th class="px-4 py-3.5">Nama Pegawai &amp; Profil</th>
                                <th class="px-4 py-3.5">Status</th>
                                <th class="px-4 py-3.5">Jabatan &amp; Jenis</th>
                                <th class="px-4 py-3.5">Serdik</th>
                                <th class="px-4 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if($sekolah->pegawais && $sekolah->pegawais->count() > 0)
                                @foreach($sekolah->pegawais as $pegawai)
                                    <tr class="hover:bg-blue-50/30 transition">
                                        <td class="px-4 py-3.5 font-bold text-blue-800 text-xs font-mono">
                                            {{ $pegawai->nip_nik ?: ($pegawai->nik ?: '-') }}
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <p class="font-bold text-gray-900 text-xs">{{ $pegawai->nama_lengkap }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $pegawai->jenis_ptk ?? 'Pendidik' }} @if($pegawai->pangkat_golongan && $pegawai->pangkat_golongan !== '-') • Gol: {{ $pegawai->pangkat_golongan }} @endif</p>
                                        </td>
                                        <td class="px-4 py-3.5 text-xs">
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
                                        <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">
                                            <p class="text-xs text-gray-800 font-medium">{{ $pegawai->jabatan_fungsional ?: '-' }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $pegawai->jenis_guru ?: '-' }}</p>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($pegawai->is_serdik)
                                                <span class="badge-custom px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Serdik
                                                </span>
                                            @else
                                                <span class="badge-custom px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Non-Serdik
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-blue-800 hover:text-white text-xs font-semibold rounded-lg transition text-gray-700 inline-flex items-center gap-1">
                                                <i class="fas fa-eye text-xs"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-xs text-gray-400 font-medium">
                                        Belum ada data Pegawai (PTK) yang terdaftar di {{ $sekolah->nama_sekolah }}.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection
