@extends('layouts.app')

@section('title', 'Log Aktivitas Pengguna - SIMPEG-SP')

@section('content')
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Log Aktivitas Pengguna System</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    @if(Auth::user() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas())
                        Audit Trail mencatat seluruh riwayat aktivitas, manipulasi data pegawai, import, serta verifikasi dari semua pengguna sekolah secara real-time.
                    @else
                        Audit Trail mencatat riwayat manipulasi data pegawai, unggah berkas, serta aktivitas di lingkungan sekolah Anda.
                    @endif
                </p>
            </div>
            <a href="{{ route('settings.logs') }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition backdrop-blur-md">
                <i class="fas fa-rotate-right text-xs"></i>
                <span>Refresh Audit Log</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-3 relative z-30">
            <form action="{{ route('settings.logs') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3 flex-1 min-w-[280px]">
                    <div class="relative flex-1 min-w-[220px]">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username, aktivitas, IP address..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-8 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                    </div>
                    <select name="action" class="bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Jenis Akses / Tindakan</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login System</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout System</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Tambah Data</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Edit Data</option>
                        <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Hapus Data</option>
                        <option value="imported" {{ request('action') == 'imported' ? 'selected' : '' }}>Import Excel</option>
                        <option value="VERIFIKASI_STATUS_UPDATE" {{ request('action') == 'VERIFIKASI_STATUS_UPDATE' ? 'selected' : '' }}>Verifikasi Dinas</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-sm transition cursor-pointer">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('search') || request('action'))
                        <a href="{{ route('settings.logs') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan <span class="font-bold text-gray-800">{{ $logs->total() }}</span> Catatan Audit Aktivitas
                </span>
                <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full font-bold">
                    <i class="fas fa-shield-halved mr-1"></i> Log Terenkripsi &amp; Real-time
                </span>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full min-w-[1000px] text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">Waktu &amp; Tanggal</th>
                            <th class="px-6 py-3.5">Pengguna (User)</th>
                            <th class="px-6 py-3.5">Role System</th>
                            <th class="px-6 py-3.5">Aktivitas / Keterangan Modul</th>
                            <th class="px-6 py-3.5">IP Address</th>
                            <th class="px-6 py-3.5 text-right">Aksi Audit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @if(isset($logs) && count($logs) > 0)
                            @foreach($logs as $log)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <!-- Waktu -->
                                    <td class="px-6 py-3.5 font-medium text-gray-600 whitespace-nowrap">
                                        <i class="far fa-clock text-gray-400 mr-1.5"></i>
                                        {{ $log->created_at ? $log->created_at->format('d M Y • H:i:s') : '-' }}
                                    </td>
                                    <!-- Pengguna -->
                                    <td class="px-6 py-3.5 font-bold text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-blue-900 text-white font-bold text-[10px] flex items-center justify-center flex-shrink-0">
                                                {{ strtoupper(substr($log->user_name ?? ($log->user->name ?? 'U'), 0, 2)) }}
                                            </div>
                                            <span>{{ $log->user_name ?? ($log->user->name ?? 'System') }}</span>
                                        </div>
                                    </td>
                                    <!-- Role -->
                                    <td class="px-6 py-3.5">
                                        @php
                                            $roleText = $log->user_role ?? ($log->user->role ?? 'ADMIN_DINAS');
                                        @endphp
                                        @if(str_contains(strtoupper($roleText), 'ADMIN'))
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                <i class="fas fa-user-shield text-[9px] mr-1"></i> Admin Dinas
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <i class="fas fa-school text-[9px] mr-1"></i> Operator Sekolah
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Aktivitas -->
                                    <td class="px-6 py-3.5 text-gray-800 font-medium">
                                        {{ $log->label ?: ($log->description ?: $log->action) }}
                                    </td>
                                    <!-- IP Address -->
                                    <td class="px-6 py-3.5 font-mono text-gray-500">
                                        {{ $log->ip_address ?: '127.0.0.1' }}
                                    </td>
                                    <!-- Status Badge -->
                                    <td class="px-6 py-3.5 text-right">
                                        @php $act = $log->action; @endphp
                                        @if($act === 'login')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-right-to-bracket text-[9px] mr-1"></i> Login
                                            </span>
                                        @elseif($act === 'logout')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                                <i class="fas fa-right-from-bracket text-[9px] mr-1"></i> Logout
                                            </span>
                                        @elseif($act === 'created')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fas fa-plus text-[9px] mr-1"></i> Tambah
                                            </span>
                                        @elseif($act === 'updated')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-pen text-[9px] mr-1"></i> Edit
                                            </span>
                                        @elseif($act === 'deleted')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fas fa-trash-can text-[9px] mr-1"></i> Hapus
                                            </span>
                                        @elseif($act === 'imported')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                <i class="fas fa-file-import text-[9px] mr-1"></i> Import
                                            </span>
                                        @elseif($act === 'VERIFIKASI_STATUS_UPDATE')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <i class="fas fa-clipboard-check text-[9px] mr-1"></i> Verifikasi
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                                {{ ucfirst($act) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-clock-rotate-left text-3xl text-gray-300"></i>
                                        <p class="font-bold text-gray-600">Belum ada catatan log aktivitas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            @if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-3.5 bg-gray-50/50 text-center lg:text-left">
                    <span class="text-xs text-gray-500 font-medium text-center lg:text-left">
                        Halaman <span class="font-bold text-gray-800">{{ $logs->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $logs->lastPage() }}</span> (Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} Data Audit Log)
                    </span>
                    <div class="flex items-center justify-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($logs->onFirstPage())
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
