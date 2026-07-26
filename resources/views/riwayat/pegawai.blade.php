@extends('layouts.app')

@section('title', 'Riwayat Perubahan - ' . $pegawai->nama_lengkap . ' - SIMPEG-SP')

@section('content')
    @include('layouts.sidebar')

    {{-- Hero Banner --}}
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-20 md:pb-24 shadow-lg overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="rgba(29,78,216,0.4)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="rgba(3,7,18,0.7)"></path>
        </svg>
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl space-y-1">
                <div class="flex items-center gap-2 text-blue-200 text-xs mb-1">
                    <a href="{{ route('pegawai.index') }}" class="hover:underline opacity-80">Data Pegawai</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('pegawai.show', $pegawai->id) }}" class="hover:underline opacity-80">{{ $pegawai->nama_lengkap }}</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="font-semibold text-white">Riwayat Perubahan</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                    <i class="fas fa-clock-rotate-left text-blue-300 text-2xl"></i>
                    <span>Riwayat Perubahan Data</span>
                </h2>
                <p class="text-blue-100 text-xs opacity-90 mt-1">
                    <i class="fas fa-user-tie mr-1"></i>{{ $pegawai->nama_lengkap }}
                    @if($pegawai->nip_nik) &nbsp;|&nbsp; <span class="font-mono">{{ $pegawai->nip_nik }}</span> @endif
                    &nbsp;|&nbsp; {{ $pegawai->sekolah?->nama_sekolah ?? '-' }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali ke Detail
                </a>
            </div>
        </div>
    </div>

    <div class="px-6 md:px-8 pb-8 flex-1 -mt-12 relative z-20 space-y-6">

        {{-- Summary Card --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="stat-card bg-white rounded-xl p-4 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-blue-50 border-2 border-blue-800 flex items-center justify-center text-blue-800 flex-shrink-0">
                    <i class="fas fa-history text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Perubahan</p>
                    <p class="text-xl font-extrabold text-gray-900">{{ $logs->total() }} <span class="text-sm text-gray-400 font-normal">kali</span></p>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-emerald-50 border-2 border-emerald-500 flex items-center justify-center text-emerald-600 flex-shrink-0">
                    <i class="fas fa-calendar-plus text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Data Dibuat</p>
                    <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $pegawai->created_at?->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            <div class="stat-card bg-white rounded-xl p-4 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-amber-50 border-2 border-amber-500 flex items-center justify-center text-amber-600 flex-shrink-0">
                    <i class="fas fa-pen-to-square text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Terakhir Diubah</p>
                    <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $pegawai->updated_at?->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>

        {{-- Log Timeline --}}
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-timeline text-blue-800"></i> Timeline Riwayat Perubahan
                </h3>
                <span class="text-xs text-gray-400">Diurutkan dari terbaru</span>
            </div>

            @if($logs->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($logs as $idx => $log)
                        <div class="px-6 py-5 hover:bg-gray-50/50 transition">
                            {{-- Log Header --}}
                            <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                        {{ $logs->total() - ($logs->currentPage() - 1) * $logs->perPage() - $idx }}
                                    </span>
                                    <span class="badge-custom text-[10px] font-bold {{ $log->action_badge_class }}">
                                        {{ $log->action_label }}
                                    </span>
                                    <div>
                                        <span class="text-xs text-gray-600 font-semibold">
                                            oleh <span class="text-blue-800">{{ $log->user_name ?? 'System' }}</span>
                                            @if($log->user_role) <span class="text-gray-400 font-normal">({{ $log->user_role }})</span> @endif
                                        </span>
                                        @if($log->label)
                                            <p class="text-[11px] text-gray-500 font-mono mt-0.5"><i class="fas fa-file-excel text-emerald-600 mr-1"></i>{{ $log->label }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-gray-700">{{ $log->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-gray-400 font-mono">{{ $log->created_at->format('H:i:s') }} WIB</p>
                                    <p class="text-[10px] text-gray-300 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Changes Table --}}
                            @if($log->changes && count($log->changes) > 0)
                                <div class="table-scroll overflow-x-auto rounded-lg border border-gray-100">
                                    @if(in_array($log->action, ['created', 'imported']))
                                        {{-- CREATED / IMPORTED: Single column layout --}}
                                        <table class="w-full text-xs text-left">
                                            <thead class="bg-emerald-50/80 text-[10px] uppercase tracking-wider text-emerald-600 font-semibold">
                                                <tr>
                                                    <th class="px-4 py-2.5 w-1/3">Field / Kolom</th>
                                                    <th class="px-4 py-2.5">Data yang Masuk</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50">
                                                @foreach($log->changes as $field => $change)
                                                    <tr class="hover:bg-emerald-50/20">
                                                        <td class="px-4 py-2.5 font-semibold text-gray-700">
                                                            {{ \App\Models\ActivityLog::pegawaiFieldLabel($field) }}
                                                        </td>
                                                        <td class="px-4 py-2.5 text-gray-800 font-medium">
                                                            {{ $change['data'] ?? '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        {{-- UPDATED: Two column layout (Lama vs Baru) --}}
                                        <table class="w-full text-xs text-left">
                                            <thead class="bg-gray-50/80 text-[10px] uppercase tracking-wider text-gray-400 font-semibold">
                                                <tr>
                                                    <th class="px-4 py-2.5 w-1/4">Field / Kolom</th>
                                                    <th class="px-4 py-2.5 w-[37.5%]">
                                                        <span class="flex items-center gap-1"><i class="fas fa-circle-left text-red-400"></i> Data Lama</span>
                                                    </th>
                                                    <th class="px-4 py-2.5 w-[37.5%]">
                                                        <span class="flex items-center gap-1"><i class="fas fa-circle-right text-emerald-500"></i> Data Baru</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50">
                                                @foreach($log->changes as $field => $change)
                                                    <tr class="hover:bg-blue-50/20">
                                                        <td class="px-4 py-2.5 font-semibold text-gray-700">
                                                            {{ \App\Models\ActivityLog::pegawaiFieldLabel($field) }}
                                                        </td>
                                                        <td class="px-4 py-2.5 text-red-600 line-through opacity-70">
                                                            {{ $change['old'] === true ? 'Ya' : ($change['old'] === false ? 'Tidak' : ($change['old'] ?? '-')) }}
                                                        </td>
                                                        <td class="px-4 py-2.5 text-emerald-700 font-semibold">
                                                            {{ $change['new'] === true ? 'Ya' : ($change['new'] === false ? 'Tidak' : ($change['new'] ?? '-')) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic pl-9">{{ $log->label ?? 'Tidak ada detail perubahan spesifik yang tercatat.' }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 bg-gray-50/50">
                        <span class="text-xs text-gray-500 font-medium">
                            Halaman <span class="font-bold text-gray-800">{{ $logs->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $logs->lastPage() }}</span>
                        </span>
                        <div class="flex items-center gap-1">
                            @if ($logs->onFirstPage())
                                <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-left"></i></a>
                            @endif
                            @foreach ($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                                @if ($page == $logs->currentPage())
                                    <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 bg-white rounded-lg transition border border-gray-200">{{ $page }}</a>
                                @endif
                            @endforeach
                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-right"></i></a>
                            @else
                                <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="px-6 py-16 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <i class="fas fa-clock-rotate-left text-2xl text-gray-300"></i>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">Belum Ada Riwayat Perubahan</p>
                    <p class="text-xs text-gray-400 mt-1">Riwayat akan otomatis tercatat saat data pegawai ini diedit atau diperbarui.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
