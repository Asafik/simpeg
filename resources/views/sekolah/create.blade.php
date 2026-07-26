@extends('layouts.app')

@section('title', ($sekolah->exists ? 'Edit Satuan Pendidikan' : 'Tambah Satuan Pendidikan Baru') . ' - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

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
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 text-blue-200 text-xs mb-2">
                    <a href="{{ route('sekolah.index') }}" class="hover:underline opacity-80">Kelola Sekolah</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="font-semibold text-white">{{ $sekolah->exists ? 'Edit Data' : 'Tambah Baru' }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                    {{ $sekolah->exists ? 'Edit Data Satuan Pendidikan' : 'Tambah Satuan Pendidikan Baru' }}
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90 mt-1">
                    {{ $sekolah->exists ? 'Perbarui informasi profil, kepala sekolah, dan kecamatan untuk ' . $sekolah->nama_sekolah : 'Lengkapi formulir untuk menambahkan data sekolah baru ke master SIMPEG-SP.' }}
                </p>
            </div>
            <a href="{{ route('sekolah.index') }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition backdrop-blur-md">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">
        
        <!-- Form Card Container (Full Width Mentok Kiri-Kanan) -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 p-6 md:p-8 -mt-12 md:-mt-14 relative z-30 w-full">
            
            <form action="{{ $sekolah->exists ? route('sekolah.update', $sekolah->id) : route('sekolah.store') }}" 
                  method="POST" 
                  id="sekolahCrudForm">
                
                @csrf
                @if($sekolah->exists)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    
                    <!-- Section Header 1: Identitas Sekolah -->
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-school"></i> 1. Identitas Satuan Pendidikan
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NPSN -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                NPSN (8 Digit) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" required maxlength="20" placeholder="Contoh: 20524929"
                                   class="w-full bg-gray-50 border border-gray-200 text-xs rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-mono @error('npsn') border-red-500 @enderror">
                            @error('npsn')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Sekolah -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Nama Satuan Pendidikan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required placeholder="Contoh: SDN Ajung 01"
                                   class="w-full bg-gray-50 border border-gray-200 text-xs rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium @error('nama_sekolah') border-red-500 @enderror">
                            @error('nama_sekolah')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan (Dropdown) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <select name="kecamatan" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium @error('kecamatan') border-red-500 @enderror">
                                <option value="">Pilih Kecamatan...</option>
                                @if(isset($listKecamatan))
                                    @foreach($listKecamatan as $kec)
                                        <option value="{{ $kec }}" {{ old('kecamatan', $sekolah->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('kecamatan')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Sekolah -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Email Resmi Sekolah
                            </label>
                            <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $sekolah->email_sekolah) }}" placeholder="Contoh: sdn.ajung01@gmail.com"
                                   class="w-full bg-gray-50 border border-gray-200 text-xs rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium @error('email_sekolah') border-red-500 @enderror">
                            @error('email_sekolah')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section Header 2: Data Kepala Sekolah -->
                    <div class="border-b border-gray-100 pb-3 pt-4">
                        <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-user-tie"></i> 2. Kepemimpinan Sekolah (Kepala Sekolah)
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Nama Kepala Sekolah -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Nama Lengkap Kepala Sekolah
                            </label>
                            <input type="text" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah', $sekolah->nama_kepala_sekolah) }}" placeholder="Contoh: Dra. Eli Fajaratna, M.Pd."
                                   class="w-full bg-gray-50 border border-gray-200 text-xs rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium @error('nama_kepala_sekolah') border-red-500 @enderror">
                            @error('nama_kepala_sekolah')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Kepsek -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Status Kepala Sekolah <span class="text-red-500">*</span>
                            </label>
                            <select name="status_kepala_sekolah" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium @error('status_kepala_sekolah') border-red-500 @enderror">
                                <option value="Definitif" {{ old('status_kepala_sekolah', $sekolah->status_kepala_sekolah ?? 'Definitif') == 'Definitif' ? 'selected' : '' }}>Definitif</option>
                                <option value="Plt" {{ old('status_kepala_sekolah', $sekolah->status_kepala_sekolah) == 'Plt' ? 'selected' : '' }}>Plt. Kepala Sekolah</option>
                            </select>
                            @error('status_kepala_sekolah')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIP Kepsek -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                NIP Kepala Sekolah (18 Digit)
                            </label>
                            <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah) }}" placeholder="Contoh: 197503212005011002"
                                   class="w-full bg-gray-50 border border-gray-200 text-xs rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-mono @error('nip_kepala_sekolah') border-red-500 @enderror">
                            @error('nip_kepala_sekolah')
                                <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ $sekolah->exists ? route('sekolah.show', $sekolah->id) : route('sekolah.index') }}" 
                           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                            <i class="fas fa-save text-xs"></i>
                            <span>{{ $sekolah->exists ? 'Simpan Perubahan' : 'Simpan Sekolah Baru' }}</span>
                        </button>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection
