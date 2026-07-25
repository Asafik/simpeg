@extends('layouts.app')

@section('title', 'Kelola Sekolah - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Satuan Pendidikan (Sekolah)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Daftar master sekolah dan pengelolaan akun Operator Sekolah per Satuan Pendidikan.
                </p>
            </div>
            <button class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-plus text-xs"></i>
                <span>Tambah Sekolah</span>
            </button>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">
        
        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Cari NPSN atau Nama Sekolah..." class="bg-gray-50 border border-gray-200 text-xs rounded-lg pl-8 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                </div>
                <span class="text-xs text-gray-500 font-medium">Total 48 Satuan Pendidikan</span>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">NPSN</th>
                            <th class="px-6 py-3.5">Nama Sekolah</th>
                            <th class="px-6 py-3.5">Alamat / Wilayah</th>
                            <th class="px-6 py-3.5">Total Pegawai</th>
                            <th class="px-6 py-3.5">Status Akun Operator</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800 text-xs">20101234</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-xs">SMA Negeri 1 Jakarta</p>
                                <p class="text-[10px] text-gray-400">Sekolah Menengah Atas Negeri</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">Jl. Budi Utomo No. 7, Jakarta Pusat</td>
                            <td class="px-6 py-4"><span class="badge-custom bg-blue-100 text-blue-800 font-bold">42 Pegawai</span></td>
                            <td class="px-6 py-4"><span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Aktif (ops_sman1)</span></td>
                            <td class="px-6 py-4 text-right">
                                <button class="px-3 py-1.5 bg-gray-100 hover:bg-amber-500 hover:text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-key mr-1"></i> Reset Password
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800 text-xs">20105678</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-xs">SMP Negeri 3 Bandung</p>
                                <p class="text-[10px] text-gray-400">Sekolah Menengah Pertama Negeri</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">Jl. Sunda No. 24, Bandung</td>
                            <td class="px-6 py-4"><span class="badge-custom bg-blue-100 text-blue-800 font-bold">35 Pegawai</span></td>
                            <td class="px-6 py-4"><span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Aktif (ops_smpn3)</span></td>
                            <td class="px-6 py-4 text-right">
                                <button class="px-3 py-1.5 bg-gray-100 hover:bg-amber-500 hover:text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-key mr-1"></i> Reset Password
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800 text-xs">20109911</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-xs">SMK Negeri 2 Surabaya</p>
                                <p class="text-[10px] text-gray-400">Sekolah Menengah Kejuruan Negeri</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">Jl. Tentara Pembelian No. 12, Surabaya</td>
                            <td class="px-6 py-4"><span class="badge-custom bg-blue-100 text-blue-800 font-bold">58 Pegawai</span></td>
                            <td class="px-6 py-4"><span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Aktif (ops_smkn2)</span></td>
                            <td class="px-6 py-4 text-right">
                                <button class="px-3 py-1.5 bg-gray-100 hover:bg-amber-500 hover:text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-key mr-1"></i> Reset Password
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
