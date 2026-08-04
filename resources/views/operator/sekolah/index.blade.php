@extends('layouts.app')

@section('title', 'Profil Sekolah - ' . ($sekolah->nama_sekolah ?? 'Operator Sekolah'))

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Hope UI Design - Operator Palette) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGradOpSek1)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGradOpSek2)"></path>
            <defs>
                <linearGradient id="hopeWaveGradOpSek1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.5" />
                    <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.3" />
                </linearGradient>
                <linearGradient id="hopeWaveGradOpSek2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#030712" stop-opacity="0.8" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>
        
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-blue-800/60 border border-blue-400/30 text-blue-200 text-xs px-3 py-1 rounded-full mb-2 backdrop-blur-md">
                    <i class="fas fa-school text-xs"></i>
                    <span>NPSN: {{ $sekolah->npsn ?? '-' }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">{{ $sekolah->nama_sekolah ?? 'Profil Satuan Pendidikan' }}</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Master data profil sekolah, rincian Kepala Sekolah, serta statistik kepegawaian internal.
                </p>
            </div>
            @if($sekolah)
                <a href="{{ route('operator.sekolah.edit') }}" class="bg-white text-blue-950 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition transform hover:-translate-y-0.5">
                    <i class="fas fa-edit text-xs text-blue-800"></i>
                    <span>Edit Profil Sekolah</span>
                </a>
            @endif
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

        @if($sekolah)
            <!-- SUMMARY STAT CARDS FOR THIS SCHOOL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Pegawai -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-800 font-bold">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 uppercase font-semibold">Total Pegawai</p>
                            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ number_format($stats['totalPegawai']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pegawai PNS -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 font-bold">
                            <i class="fas fa-user-shield text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 uppercase font-semibold">Pegawai PNS</p>
                            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ number_format($stats['pns']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pegawai PPPK -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 flex items-center justify-center text-purple-600 font-bold">
                            <i class="fas fa-user-check text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 uppercase font-semibold">Pegawai PPPK</p>
                            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ number_format($stats['pppk']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Non-ASN -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 font-bold">
                            <i class="fas fa-user-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 uppercase font-semibold">Non-ASN / Honorer</p>
                            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ number_format($stats['nonAsn']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAILED INFORMATION CARDS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left 2 Cols: Profile Detail & Kepala Sekolah -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Identitas Sekolah Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                <i class="fas fa-school text-blue-800"></i>
                                Identitas Satuan Pendidikan
                            </h3>
                            <a href="{{ route('operator.sekolah.edit') }}" class="text-xs font-semibold text-blue-800 hover:underline">
                                <i class="fas fa-pen text-[10px] mr-1"></i>Edit Informasi
                            </a>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Nama Satuan Pendidikan</dt>
                                <dd class="font-bold text-gray-900 text-sm mt-0.5">{{ $sekolah->nama_sekolah }}</dd>
                            </div>

                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Nomor Pokok Sekolah Nasional (NPSN)</dt>
                                <dd class="font-mono font-bold text-gray-900 text-sm mt-0.5">{{ $sekolah->npsn }}</dd>
                            </div>

                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Kecamatan / Wilayah</dt>
                                <dd class="font-semibold text-gray-800 mt-0.5">
                                    <i class="fas fa-map-marker-alt text-rose-500 mr-1"></i>
                                    {{ $sekolah->kecamatan ?? '-' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Email Resmi Sekolah</dt>
                                <dd class="font-medium text-gray-800 mt-0.5">{{ $sekolah->email_sekolah ?: '-' }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Alamat Lengkap</dt>
                                <dd class="font-medium text-gray-700 mt-0.5 leading-relaxed">{{ $sekolah->alamat ?: '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Kepala Sekolah Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                <i class="fas fa-user-tie text-blue-800"></i>
                                Data Kepala Sekolah
                            </h3>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $sekolah->status_kepala_sekolah === 'Definitif' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $sekolah->status_kepala_sekolah ?? 'Definitif' }}
                            </span>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">Nama Kepala Sekolah</dt>
                                <dd class="font-bold text-gray-900 mt-0.5">{{ $sekolah->nama_kepala_sekolah ?: '-' }}</dd>
                            </div>

                            <div>
                                <dt class="text-gray-400 uppercase font-bold text-[10px]">NIP Kepala Sekolah</dt>
                                <dd class="font-mono font-semibold text-gray-800 mt-0.5">{{ $sekolah->nip_kepala_sekolah ?: '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Right Column: Akun Operator & Quick Tools -->
                <div class="space-y-6">
                    <!-- Akun Operator Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-4">
                        <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
                            <i class="fas fa-user-gear text-blue-800"></i>
                            Akun Operator Sekolah
                        </h3>
                        <div class="space-y-3 text-xs">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Username Login</p>
                                <p class="font-mono font-bold text-blue-900 text-sm mt-0.5">{{ $user->username ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Nama Pengguna</p>
                                <p class="font-semibold text-gray-800 mt-0.5">{{ $user->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Email Akun</p>
                                <p class="font-medium text-gray-600 mt-0.5">{{ $user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-3">
                        <h3 class="font-bold text-gray-900 text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-bolt text-amber-500"></i>
                            Akses Cepat
                        </h3>
                        <a href="{{ route('operator.pegawai.index') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 hover:bg-blue-50 text-gray-700 hover:text-blue-900 transition text-xs font-semibold">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-users text-blue-800"></i>
                                Kelola Data Pegawai
                            </span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
                        </a>

                        <a href="{{ route('operator.sekolah.edit') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 hover:bg-emerald-50 text-gray-700 hover:text-emerald-900 transition text-xs font-semibold">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-edit text-emerald-600"></i>
                                Perbarui Profil Sekolah
                            </span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl p-8 border border-gray-100 text-center text-gray-400">
                <i class="fas fa-building-circle-exclamation text-4xl text-amber-500 mb-3 block"></i>
                <p class="font-bold text-gray-700 text-sm">Akun Anda belum terhubung ke Satuan Pendidikan manapun.</p>
                <p class="text-xs text-gray-400 mt-1">Silakan hubungi Administrator Dinas untuk menautkan akun Operator Anda.</p>
            </div>
        @endif
    </div>
@endsection
