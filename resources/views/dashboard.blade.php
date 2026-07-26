@extends('layouts.app')

@section('title', 'SIMPEG-SP - Dashboard Admin Dinas')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE WELCOME BANNER (Hope UI Design - Deep Blue) ===== -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">
                    Halo, {{ Auth::user()->name ?? 'Administrator Dinas' }}! 👋
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Selamat datang di SIMPEG-SP. Pantau persebaran <strong>{{ number_format($totalSekolah) }} Satuan Pendidikan</strong>, data Kepala Sekolah, serta status akun Operator Sekolah secara real-time.
                </p>
            </div>
            <a href="{{ route('sekolah.index') }}" class="bg-white text-blue-950 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-md flex items-center gap-2 transition transform hover:-translate-y-0.5">
                <i class="fas fa-school text-xs"></i>
                <span>Kelola Sekolah</span>
            </a>
        </div>
    </div>

    <!-- ===== MAIN CONTENT BODY (With padding & overlapping stat cards) ===== -->
    <div class="px-4 md:px-8 pb-8 flex-1">
        <!-- ===== OVERLAPPING SUMMARY CARDS ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 -mt-12 md:-mt-14 mb-6 relative z-20">
            <!-- Card 1: Total Satuan Pendidikan -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-blue-200 flex items-center justify-center text-blue-800 font-bold bg-blue-50 flex-shrink-0">
                        <i class="fas fa-school text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Satuan Pendidikan</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalSekolah) }}</p>
                    </div>
                </div>
                <a href="{{ route('sekolah.index') }}" class="p-1 hover:text-blue-700 transition">
                    <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                </a>
            </div>

            <!-- Card 2: Kepala Sekolah Definitif -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-emerald-200 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50 flex-shrink-0">
                        <i class="fas fa-user-check text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Kepsek Definitif</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalDefinitif) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 3: Kepsek Plt / Plh -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-amber-200 flex items-center justify-center text-amber-600 font-bold bg-amber-50 flex-shrink-0">
                        <i class="fas fa-user-clock text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Kepsek Plt / Plh</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalPlt + $totalPlh) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 4: Akun Operator Sekolah -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-indigo-200 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50 flex-shrink-0">
                        <i class="fas fa-id-badge text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Akun Operator</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalOperator) }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </div>

            <!-- Card 5: Total Pegawai -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl border border-purple-200 flex items-center justify-center text-purple-600 font-bold bg-purple-50 flex-shrink-0">
                        <i class="fas fa-users text-base"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Pegawai</p>
                        <p class="text-xl md:text-2xl font-black text-gray-900 mt-0.5">{{ number_format($totalPegawai) }}</p>
                    </div>
                </div>
                <a href="{{ route('pegawai.index') }}" class="p-1 hover:text-purple-700 transition">
                    <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                </a>
            </div>
        </div>

        <!-- ===== CHARTS ROW (DISTRIBUSI KECAMATAN & STATUS KEPALA SEKOLAH) ===== -->
        <div class="grid lg:grid-cols-3 gap-6 mb-6">
            <!-- Chart 1: Top Kecamatan Satuan Pendidikan (2 Cols) -->
            <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Persebaran Satuan Pendidikan Terbanyak (Per Kecamatan)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Top 7 Kecamatan dengan jumlah sekolah terbanyak di database real.</p>
                    </div>
                    <a href="{{ route('sekolah.index') }}" class="text-xs font-semibold text-blue-800 hover:text-blue-950 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 transition">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="chart-container relative" style="height: 250px;">
                    <canvas id="kecamatanChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Doughnut Status Kepala Sekolah (1 Col) -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-800 text-sm">Status Kepala Sekolah</h3>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Real Data</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-4">Perbandingan status Kepala Sekolah Definitif vs Plt/Plh.</p>
                </div>
                
                <div class="chart-container relative my-auto" style="height: 190px;">
                    <canvas id="statusKepsekChart"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4 pt-3 border-t border-gray-100 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-gray-600">Definitif ({{ $totalDefinitif }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-gray-600">Plt ({{ $totalPlt }})</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RECENT DATA TABLE SECTION ===== -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                        <i class="fas fa-school text-blue-900"></i>
                        Data Satuan Pendidikan Terbaru
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Menampilkan sekolah yang baru dimasukkan / terdaftar di sistem SIMPEG-SP.</p>
                </div>
                <a href="{{ route('sekolah.index') }}" class="text-xs font-bold text-blue-900 hover:text-blue-950 flex items-center gap-1">
                    Kelola Semua Sekolah <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <!-- Table -->
            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">NPSN</th>
                            <th class="px-6 py-3.5">Nama Sekolah</th>
                            <th class="px-6 py-3.5">Kepala Sekolah</th>
                            <th class="px-6 py-3.5">Kecamatan</th>
                            <th class="px-6 py-3.5">Akun Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse($recentSekolahs as $sekolah)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-6 py-4 font-bold text-gray-800 font-mono">
                                    {{ $sekolah->npsn }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $sekolah->nama_sekolah }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($sekolah->nama_kepala_sekolah)
                                        <p class="font-semibold text-gray-800">{{ $sekolah->nama_kepala_sekolah }}</p>
                                        <span class="text-[10px] text-gray-400 font-mono">NIP. {{ $sekolah->nip_kepala_sekolah ?? '-' }}</span>
                                    @else
                                        <span class="text-gray-400 italic">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    <i class="fas fa-map-marker-alt text-rose-500 mr-1"></i>
                                    {{ $sekolah->kecamatan }}
                                </td>
                                <td class="px-6 py-4">
                                    @php $op = $sekolah->users->first(); @endphp
                                    @if($op)
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-mono font-semibold rounded-full border border-emerald-200">
                                            {{ $op->username }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">ops_{{ $sekolah->npsn }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada data sekolah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <footer class="mt-8 text-center text-xs text-gray-400 border-t border-gray-200/70 pt-6">
            &copy; 2026 <span class="font-bold text-gray-600">SIMPEG-SP</span> — Dinas Pendidikan. All rights reserved.
        </footer>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Chart 1: Bar Chart Top Kecamatan
        const ctxKec = document.getElementById('kecamatanChart')?.getContext('2d');
        if (ctxKec) {
            new Chart(ctxKec, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kecamatanLabels) !!},
                    datasets: [{
                        label: 'Jumlah Sekolah',
                        data: {!! json_encode($kecamatanData) !!},
                        backgroundColor: '#1e3a8a',
                        borderRadius: 8,
                        hoverBackgroundColor: '#1d4ed8'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6' },
                            ticks: { precision: 0, font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Chart 2: Doughnut Chart Status Kepala Sekolah
        const ctxStatus = document.getElementById('statusKepsekChart')?.getContext('2d');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusKepsekLabels) !!},
                    datasets: [{
                        data: {!! json_encode($statusKepsekData) !!},
                        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 11 } } }
                    },
                    cutout: '70%'
                }
            });
        }
    });
</script>
@endpush
