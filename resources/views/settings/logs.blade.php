@extends('layouts.app')

@section('title', 'Log Aktivitas - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER ===== -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Log Aktivitas Pengguna System</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Audit Trail catat riwayat login, manipulasi data pegawai, serta aktivitas pengguna secara real-time.
                </p>
            </div>
            <button class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-rotate-right text-xs"></i>
                <span>Refresh Audit Log</span>
            </button>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Cari username atau aktivitas..." class="bg-gray-50 border border-gray-200 text-xs rounded-lg pl-8 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                </div>
                <span class="text-xs text-gray-500 font-medium">Total 124 Catatan Aktivitas</span>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">Waktu / Tanggal</th>
                            <th class="px-6 py-3.5">Pengguna (User)</th>
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Aktivitas / Modul</th>
                            <th class="px-6 py-3.5">IP Address</th>
                            <th class="px-6 py-3.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 19:48:22</td>
                            <td class="px-6 py-3.5 font-bold text-gray-900">admin</td>
                            <td class="px-6 py-3.5"><span class="badge-custom bg-blue-100 text-blue-800">Admin Dinas</span></td>
                            <td class="px-6 py-3.5 text-gray-700">Login ke dalam sistem SIMPEG-SP</td>
                            <td class="px-6 py-3.5 font-mono text-gray-500">127.0.0.1</td>
                            <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 19:35:10</td>
                            <td class="px-6 py-3.5 font-bold text-gray-900">operator_sd1</td>
                            <td class="px-6 py-3.5"><span class="badge-custom bg-emerald-100 text-emerald-800">Operator Sekolah</span></td>
                            <td class="px-6 py-3.5 text-gray-700">Mengunggah SK Kepegawaian (NIP: 198705152010012034)</td>
                            <td class="px-6 py-3.5 font-mono text-gray-500">192.168.1.104</td>
                            <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 18:20:45</td>
                            <td class="px-6 py-3.5 font-bold text-gray-900">admin</td>
                            <td class="px-6 py-3.5"><span class="badge-custom bg-blue-100 text-blue-800">Admin Dinas</span></td>
                            <td class="px-6 py-3.5 text-gray-700">Menyetujui Verifikasi Berkas (Dr. Ahmad Fauzi, M.Pd.)</td>
                            <td class="px-6 py-3.5 font-mono text-gray-500">127.0.0.1</td>
                            <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
