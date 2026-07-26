@extends('layouts.app')

@section('title', 'Kelola Sekolah - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Hope UI Design - Deep Blue) ===== -->
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
                    Master data sekolah, Kepala Sekolah, serta pengelolaan akun Operator Sekolah per Satuan Pendidikan.
                </p>
            </div>
            <button onclick="openCreateModal()" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-md flex items-center gap-2 transition transform hover:-translate-y-0.5">
                <i class="fas fa-plus text-xs"></i>
                <span>Tambah Sekolah</span>
            </button>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">

        <!-- Flash Messages -->
        @if(session('success'))
            <div id="flash-success" class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs md:text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-emerald-700">{!! session('success') !!}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div id="flash-error" class="bg-rose-50 border border-rose-200 text-rose-800 text-xs md:text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="font-bold">Terjadi Kesalahan Validation:</p>
                        <ul class="list-disc list-inside text-rose-700 mt-1 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        
        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden">
            
            <!-- Filters Toolbar -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <form action="{{ route('sekolah.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-3 flex-1 min-w-[280px]">
                        <!-- Search Box -->
                        <div class="relative flex-1 min-w-[200px] max-w-md">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari NPSN, Nama Sekolah, Kepsek..." class="w-full bg-white border border-gray-200 text-xs rounded-lg pl-8 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                            @if($search)
                                <a href="{{ route('sekolah.index', ['kecamatan' => $kecamatanFilter]) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Kecamatan Filter -->
                        <div class="w-48">
                            <select name="kecamatan" onchange="this.form.submit()" class="w-full bg-white border border-gray-200 text-xs rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700 text-gray-700 font-medium">
                                <option value="">-- Semua Kecamatan --</option>
                                @foreach($listKecamatan as $kec)
                                    <option value="{{ $kec }}" {{ $kecamatanFilter === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-900 hover:bg-blue-950 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>

                        @if($search || $kecamatanFilter)
                            <a href="{{ route('sekolah.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-medium py-2 px-1 flex items-center gap-1">
                                <i class="fas fa-undo"></i> Reset Filter
                            </a>
                        @endif
                    </div>

                    <div class="text-xs text-gray-500 font-medium">
                        Total <span class="font-bold text-gray-800">{{ number_format($sekolahs->total()) }}</span> Satuan Pendidikan
                    </div>
                </form>
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
                            <th class="px-6 py-3.5">Total Pegawai</th>
                            <th class="px-6 py-3.5">Status Akun Operator</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sekolahs as $sekolah)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-6 py-4 font-bold text-gray-800 text-xs tracking-wide">
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-800 rounded font-mono text-[11px] border border-gray-200">
                                        {{ $sekolah->npsn }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-xs">{{ $sekolah->nama_sekolah }}</p>
                                    @if($sekolah->email_sekolah)
                                        <p class="text-[11px] text-gray-400 flex items-center gap-1 mt-0.5">
                                            <i class="fas fa-envelope text-[10px]"></i> {{ $sekolah->email_sekolah }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($sekolah->nama_kepala_sekolah)
                                        <p class="font-semibold text-gray-800 text-xs">{{ $sekolah->nama_kepala_sekolah }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($sekolah->nip_kepala_sekolah)
                                                <span class="text-[10px] text-gray-400 font-mono">NIP. {{ $sekolah->nip_kepala_sekolah }}</span>
                                            @endif
                                            @if($sekolah->status_kepala_sekolah === 'Definitif')
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-emerald-100 text-emerald-800 rounded">Definitif</span>
                                            @elseif($sekolah->status_kepala_sekolah === 'Plt')
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-amber-100 text-amber-800 rounded">Plt</span>
                                            @else
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-blue-100 text-blue-800 rounded">{{ $sekolah->status_kepala_sekolah ?? 'Definitif' }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-gray-700">
                                    <i class="fas fa-map-marker-alt text-rose-500 mr-1 text-[11px]"></i>
                                    {{ $sekolah->kecamatan }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                        <i class="fas fa-users text-[10px] mr-1.5"></i>
                                        {{ $sekolah->pegawais_count }} Pegawai
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $operator = $sekolah->users->first();
                                    @endphp
                                    @if($operator)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <i class="fas fa-check-circle text-emerald-600 mr-1.5"></i>
                                            Aktif (<span class="font-mono text-[11px]">{{ $operator->username }}</span>)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-1">
                                    <!-- Edit Button -->
                                    <button onclick="openEditModal({{ json_encode($sekolah) }})" title="Edit Sekolah" class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>

                                    <!-- Reset Password Operator -->
                                    <button onclick="openResetModal({{ json_encode($sekolah) }}, '{{ $operator ? $operator->username : ('ops_' . $sekolah->npsn) }}')" title="Reset Password Operator" class="p-1.5 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                        <i class="fas fa-key text-sm"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button onclick="openDeleteModal({{ json_encode($sekolah) }})" title="Hapus Sekolah" class="p-1.5 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <p class="font-medium text-sm text-gray-600">Tidak ada data sekolah ditemukan</p>
                                    <p class="text-xs text-gray-400 mt-1">Coba gunakan kata kunci pencarian atau filter yang lain.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-4">
                <div class="text-xs text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-800">{{ $sekolahs->firstItem() ?? 0 }}</span> sampai <span class="font-semibold text-gray-800">{{ $sekolahs->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-gray-800">{{ $sekolahs->total() }}</span> sekolah
                </div>
                <div>
                    {{ $sekolahs->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL TAMBAH SEKOLAH ===== -->
    <div id="createModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
            <div class="bg-gradient-to-r from-blue-950 to-indigo-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-plus-circle text-blue-300"></i>
                    <h3 class="font-bold text-base">Tambah Satuan Pendidikan</h3>
                </div>
                <button onclick="closeCreateModal()" class="text-blue-200 hover:text-white transition p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('sekolah.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NPSN <span class="text-rose-500">*</span></label>
                        <input type="text" name="npsn" required placeholder="Contoh: 20523594" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="kecamatan" required placeholder="Contoh: Jenggawah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Sekolah <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_sekolah" required placeholder="Contoh: SDN Kertonegoro 01" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="nama_kepala_sekolah" placeholder="Nama & Gelar Kepsek" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Kepsek</label>
                        <select name="status_kepala_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                            <option value="Definitif">Definitif</option>
                            <option value="Plt">Plt</option>
                            <option value="Plh">Plh</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" placeholder="NIP 18 Digit" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Sekolah</label>
                        <input type="email" name="email_sekolah" placeholder="email@dinas.sch.id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Sekolah</label>
                    <textarea name="alamat" rows="2" placeholder="Alamat lengkap..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700"></textarea>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-900 hover:bg-blue-950 text-white text-xs font-bold transition shadow-md">
                        Simpan Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT SEKOLAH ===== -->
    <div id="editModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
            <div class="bg-gradient-to-r from-blue-950 to-indigo-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-edit text-blue-300"></i>
                    <h3 class="font-bold text-base">Edit Satuan Pendidikan</h3>
                </div>
                <button onclick="closeEditModal()" class="text-blue-200 hover:text-white transition p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NPSN <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_npsn" name="npsn" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_kecamatan" name="kecamatan" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Sekolah <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_nama_sekolah" name="nama_sekolah" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Kepala Sekolah</label>
                        <input type="text" id="edit_nama_kepala_sekolah" name="nama_kepala_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Kepsek</label>
                        <select id="edit_status_kepala_sekolah" name="status_kepala_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                            <option value="Definitif">Definitif</option>
                            <option value="Plt">Plt</option>
                            <option value="Plh">Plh</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NIP Kepala Sekolah</label>
                        <input type="text" id="edit_nip_kepala_sekolah" name="nip_kepala_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Sekolah</label>
                        <input type="email" id="edit_email_sekolah" name="email_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Sekolah</label>
                    <textarea id="edit_alamat" name="alamat" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-blue-800/20 focus:border-blue-700"></textarea>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-900 hover:bg-blue-950 text-white text-xs font-bold transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL HAPUS SEKOLAH ===== -->
    <div id="deleteModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Konfirmasi Hapus Sekolah</h3>
                <p class="text-xs text-gray-500 mb-4">
                    Apakah Anda yakin ingin menghapus sekolah <strong id="delete_nama_sekolah" class="text-gray-800"></strong> (NPSN: <span id="delete_npsn"></span>)? Action ini juga akan menghapus akun operator terkait.
                </p>
                <form id="deleteForm" method="POST" class="flex items-center justify-center gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-md">
                        Ya, Hapus Sekolah
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== MODAL RESET PASSWORD ===== -->
    <div id="resetModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-key"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Reset Password Operator</h3>
                <p class="text-xs text-gray-500 mb-4">
                    Reset password akun operator untuk <strong id="reset_nama_sekolah" class="text-gray-800"></strong> (Username: <span id="reset_username" class="font-mono text-amber-700"></span>) menjadi password bawaan: <span class="font-mono font-bold bg-amber-50 px-2 py-0.5 rounded text-amber-800 border border-amber-200">password</span>.
                </p>
                <form id="resetForm" method="POST" class="flex items-center justify-center gap-3">
                    @csrf
                    <button type="button" onclick="closeResetModal()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-md">
                        Ya, Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }
        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(sekolah) {
            document.getElementById('editForm').action = "/sekolah/" + sekolah.id;
            document.getElementById('edit_npsn').value = sekolah.npsn || '';
            document.getElementById('edit_nama_sekolah').value = sekolah.nama_sekolah || '';
            document.getElementById('edit_kecamatan').value = sekolah.kecamatan || '';
            document.getElementById('edit_nama_kepala_sekolah').value = sekolah.nama_kepala_sekolah || '';
            document.getElementById('edit_nip_kepala_sekolah').value = sekolah.nip_kepala_sekolah || '';
            document.getElementById('edit_status_kepala_sekolah').value = sekolah.status_kepala_sekolah || 'Definitif';
            document.getElementById('edit_email_sekolah').value = sekolah.email_sekolah || '';
            document.getElementById('edit_alamat').value = sekolah.alamat || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(sekolah) {
            document.getElementById('deleteForm').action = "/sekolah/" + sekolah.id;
            document.getElementById('delete_nama_sekolah').textContent = sekolah.nama_sekolah;
            document.getElementById('delete_npsn').textContent = sekolah.npsn;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function openResetModal(sekolah, username) {
            document.getElementById('resetForm').action = "/sekolah/" + sekolah.id + "/reset-password";
            document.getElementById('reset_nama_sekolah').textContent = sekolah.nama_sekolah;
            document.getElementById('reset_username').textContent = username;
            document.getElementById('resetModal').classList.remove('hidden');
        }
        function closeResetModal() {
            document.getElementById('resetModal').classList.add('hidden');
        }
    </script>
    @endpush
@endsection
