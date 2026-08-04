@extends('layouts.app')

@section('title', 'Edit Profil Sekolah - ' . ($sekolah->nama_sekolah ?? 'Operator Sekolah'))

@section('content')

    <!-- ===== HERO BLUE BANNER ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('operator.sekolah.index') }}" class="hover:underline">Profil Sekolah</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>Edit Informasi Sekolah</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">Edit Informasi Satuan Pendidikan</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Perbarui data identitas sekolah, Kepala Sekolah, serta alamat untuk <strong>{{ $sekolah->nama_sekolah }}</strong>.
                </p>
            </div>
            <a href="{{ route('operator.sekolah.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Profil</span>
            </a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 w-full -mt-8 relative z-20">

        <!-- Error Validation Summary -->
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-sm space-y-1">
                <p class="font-bold flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-rose-600"></i>
                    Terdapat kesalahan input formulir:
                </p>
                <ul class="list-disc list-inside text-rose-700 space-y-0.5 pl-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('operator.sekolah.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Card 1: Identitas Satuan Pendidikan -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-school text-blue-800"></i>
                        1. Identitas Satuan Pendidikan
                    </h3>
                    <span class="text-[10px] font-bold text-blue-800 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                        Wajib Diisi
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <!-- NPSN -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">NPSN <span class="text-rose-500">*</span></label>
                        <input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Nama Sekolah -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-gray-700 mb-1">Nama Satuan Pendidikan <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-bold focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', $sekolah->kecamatan) }}" required placeholder="Nama Kecamatan" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Email Sekolah -->
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-gray-700 mb-1">Email Resmi Sekolah</label>
                        <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $sekolah->email_sekolah) }}" placeholder="sekolah@dinas.sch.id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>
            </div>

            <!-- Card 2: Data Kepala Sekolah -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-user-tie text-blue-800"></i>
                        2. Data Kepala Sekolah
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <!-- Nama Kepala Sekolah -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Kepala Sekolah & Gelar</label>
                        <input type="text" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah', $sekolah->nama_kepala_sekolah) }}" placeholder="Nama Kepala Sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- NIP Kepala Sekolah -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah) }}" placeholder="1970..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Status Kepala Sekolah -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Status Jabatan Kepsek</label>
                        <select name="status_kepala_sekolah" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="Definitif" {{ old('status_kepala_sekolah', $sekolah->status_kepala_sekolah) == 'Definitif' ? 'selected' : '' }}>Definitif</option>
                            <option value="Plt" {{ old('status_kepala_sekolah', $sekolah->status_kepala_sekolah) == 'Plt' ? 'selected' : '' }}>Plt (Pelaksana Tugas)</option>
                            <option value="Plh" {{ old('status_kepala_sekolah', $sekolah->status_kepala_sekolah) == 'Plh' ? 'selected' : '' }}>Plh (Pelaksana Harian)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card 3: Alamat Lengkap -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-location-dot text-rose-500"></i>
                        3. Alamat Lengkap Sekolah
                    </h3>
                </div>

                <div class="text-xs">
                    <label class="block font-semibold text-gray-700 mb-1">Alamat Jalan, Desa/Kelurahan</label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap sekolah..." class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">{{ old('alamat', $sekolah->alamat) }}</textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('operator.sekolah.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-6 py-2.5 rounded-lg shadow-md transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Perbarui Profil Sekolah
                </button>
            </div>
        </form>
    </div>
@endsection
