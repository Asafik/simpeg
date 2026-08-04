@extends('layouts.app')

@section('title', 'SIMPEG-SP - Dashboard Operator Sekolah')

@section('content')

    <!-- ===== HERO BLUE WELCOME BANNER (Hope UI Design - Operator Palette) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-20 md:pb-24 shadow-lg shadow-blue-950/20 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGradOp1)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGradOp2)"></path>
            <defs>
                <linearGradient id="hopeWaveGradOp1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#2563eb" stop-opacity="0.45" />
                    <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.25" />
                </linearGradient>
                <linearGradient id="hopeWaveGradOp2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#0284c7" stop-opacity="0.35" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.6" />
                </linearGradient>
            </defs>
        </svg>
        
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-blue-800/60 border border-blue-400/30 text-blue-200 text-xs px-3 py-1 rounded-full mb-3 backdrop-blur-md">
                    <i class="fas fa-school text-xs"></i>
                    <span>Operator Sekolah: <strong>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan' }}</strong></span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">
                    Halo, {{ Auth::user()->name ?? 'Operator Sekolah' }}! 👋
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Selamat datang di Dashboard Operator SIMPEG-SP. Kelola data Aparatur Sipil Negara dan Tenaga Kepegawaian di <strong>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan Anda' }}</strong> dengan aman dan mudah.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('operator.pegawai.create') }}" class="bg-white text-blue-950 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-md flex items-center gap-2 transition transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus text-xs text-blue-800"></i>
                    <span>Tambah Pegawai Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT BODY ===== -->
    <div class="px-4 md:px-8 pb-8 flex-1">
        <!-- ===== OVERLAPPING SUMMARY CARDS ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 -mt-12 md:-mt-14 mb-6 relative z-20">
            <!-- Card 1: Total Pegawai Sekolah -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-blue-200 flex items-center justify-center text-blue-800 font-bold bg-blue-50 flex-shrink-0">
                        <i class="fas fa-users text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Pegawai</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalPegawai) }}</p>
                    </div>
                </div>
                <a href="{{ route('operator.pegawai.index') }}" class="p-1 hover:text-blue-700 transition">
                    <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                </a>
            </div>

            <!-- Card 2: Pegawai PNS -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-emerald-200 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50 flex-shrink-0">
                        <i class="fas fa-user-shield text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Pegawai PNS</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalPns) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 3: Pegawai PPPK -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-purple-200 flex items-center justify-center text-purple-600 font-bold bg-purple-50 flex-shrink-0">
                        <i class="fas fa-user-check text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">PPPK & PW</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalPppk + $totalPppkPw) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 4: Pegawai Non-ASN -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-amber-200 flex items-center justify-center text-amber-600 font-bold bg-amber-50 flex-shrink-0">
                        <i class="fas fa-user-clock text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Non-ASN / Honorer</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalNonAsn) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 5: Status Kepala Sekolah -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-indigo-200 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50 flex-shrink-0">
                        <i class="fas fa-user-tie text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Status Kepsek</p>
                        <p class="text-sm font-extrabold text-gray-900 mt-0.5">{{ $sekolah->status_kepala_sekolah ?? 'Definitif' }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>
        </div>

        <!-- ===== DASHBOARD CONTENT ROW ===== -->
        <div class="grid lg:grid-cols-3 gap-6 mb-6">
            <!-- Left 2 Columns: Table Pegawai Terbaru Sekolah -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                                <i class="fas fa-users-gear text-blue-800"></i>
                                Data Pegawai {{ $sekolah->nama_sekolah ?? 'Sekolah' }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">Daftar pegawai yang terdaftar di sekolah tempat Anda bertugas.</p>
                        </div>
                        <a href="{{ route('operator.pegawai.index') }}" class="text-xs font-bold text-blue-800 hover:text-blue-950 flex items-center gap-1">
                            Lihat Semua Data <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="table-scroll overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                                <tr>
                                    <th class="px-6 py-3.5">Nama & NIP/NIK</th>
                                    <th class="px-6 py-3.5">Status Kepegawaian</th>
                                    <th class="px-6 py-3.5">Jabatan / Golongan</th>
                                    <th class="px-6 py-3.5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                @forelse($recentPegawais as $pegawai)
                                    <tr class="hover:bg-blue-50/30 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900">{{ $pegawai->nama_lengkap }}</p>
                                            <span class="text-[10px] text-gray-400 font-mono">NIP/NIK: {{ $pegawai->nip_nik ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($pegawai->status_kepegawaian === 'PNS')
                                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-semibold rounded-full border border-emerald-200">
                                                    PNS
                                                </span>
                                            @elseif(str_contains($pegawai->status_kepegawaian, 'PPPK'))
                                                <span class="px-2.5 py-1 bg-purple-50 text-purple-700 font-semibold rounded-full border border-purple-200">
                                                    {{ $pegawai->status_kepegawaian }}
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-semibold rounded-full border border-amber-200">
                                                    Non-ASN
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 font-medium">
                                            <p>{{ $pegawai->jabatan_fungsional ?? '-' }}</p>
                                            <span class="text-[10px] text-gray-400">Gol. {{ $pegawai->pangkat_golongan ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('operator.pegawai.show', $pegawai->id) }}" class="p-1.5 text-gray-500 hover:text-blue-800 hover:bg-blue-50 rounded-md transition" title="Detail Pegawai">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>
                                                <a href="{{ route('operator.pegawai.edit', $pegawai->id) }}" class="p-1.5 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-md transition" title="Edit Data">
                                                    <i class="fas fa-edit text-xs"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                            Belum ada data pegawai terdaftar di sekolah ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center text-xs">
                    <span class="text-gray-500">Menampilkan {{ count($recentPegawais) }} data pegawai terbaru</span>
                    <a href="{{ route('operator.pegawai.index') }}" class="font-semibold text-blue-800 hover:underline">Kelola Seluruh Pegawai &rarr;</a>
                </div>
            </div>

            <!-- Right Column: Card Profil Satuan Pendidikan & Akses Cepat -->
            <div class="space-y-6">
                <!-- Card Profil Sekolah -->
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                            <i class="fas fa-school text-blue-800"></i>
                            Informasi Sekolah
                        </h3>
                        <span class="text-[10px] font-bold text-blue-800 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                            {{ $sekolah->npsn ?? 'NPSN' }}
                        </span>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400">Nama Satuan Pendidikan</p>
                            <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $sekolah->nama_sekolah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400">Kepala Sekolah</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $sekolah->nama_kepala_sekolah ?? '-' }}</p>
                            <p class="text-[10px] text-gray-400 font-mono">NIP. {{ $sekolah->nip_kepala_sekolah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400">Kecamatan / Wilayah</p>
                            <p class="font-medium text-gray-700 mt-0.5">
                                <i class="fas fa-map-marker-alt text-rose-500 mr-1"></i>
                                {{ $sekolah->kecamatan ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400">Alamat Lengkap</p>
                            <p class="text-gray-600 mt-0.5 leading-relaxed">{{ $sekolah->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Akses Cepat / Quick Tools -->
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-amber-500"></i>
                        Akses Pintas Operator
                    </h3>
                    <div class="space-y-2.5">
                        <a href="{{ route('operator.pegawai.create') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 hover:bg-blue-50 hover:border-blue-200 text-gray-700 hover:text-blue-900 transition group text-xs font-semibold">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-user-plus text-blue-700"></i>
                                Tambah Data Pegawai
                            </span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-700"></i>
                        </a>

                        <a href="{{ route('pegawai.template') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 hover:bg-emerald-50 hover:border-emerald-200 text-gray-700 hover:text-emerald-900 transition group text-xs font-semibold">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-file-excel text-emerald-600"></i>
                                Download Template Excel
                            </span>
                            <i class="fas fa-download text-[10px] text-gray-300 group-hover:text-emerald-600"></i>
                        </a>

                        <a href="{{ route('pegawai.export.excel') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 hover:bg-indigo-50 hover:border-indigo-200 text-gray-700 hover:text-indigo-900 transition group text-xs font-semibold">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-file-export text-indigo-600"></i>
                                Export Data Pegawai (.xlsx)
                            </span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-indigo-600"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <footer class="mt-8 text-center text-xs text-gray-400 border-t border-gray-200/70 pt-6">
            &copy; 2026 <span class="font-bold text-gray-600">SIMPEG-SP</span> — Dashboard Operator Sekolah. All rights reserved.
        </footer>
    </div>
@endsection
