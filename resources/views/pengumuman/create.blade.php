@extends('layouts.app')

@php
    $isEdit = isset($isEdit) && $isEdit;
    $title = $isEdit ? 'Edit Pengumuman Publik - SIMPEG-SP' : 'Buat Pengumuman Publik Baru - SIMPEG-SP';
    $formUrl = $isEdit ? route('pengumuman.update', $id ?? 1) : route('pengumuman.store');
@endphp

@section('title', $title)

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
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('pengumuman.index') }}" class="hover:underline">Kelola Pengumuman</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>{{ $isEdit ? 'Edit Pengumuman' : 'Buat Baru' }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">
                    {{ $isEdit ? 'Edit Pengumuman & Informasi Publik' : 'Form Buat Pengumuman Publik Baru' }}
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    {{ $isEdit ? 'Perbarui topik, sasaran penerima, serta dokumen edaran resmi Dinas Pendidikan.' : 'Lengkapi informasi edaran resmi, pilih kelompok sasaran penerima, dan upload dokumen pendukung.' }}
                </p>
            </div>
            
            <!-- Kembali Button -->
            <a href="{{ route('pengumuman.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Daftar Pengumuman</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20">
        
        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- MAIN FORM CARD -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
                
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i> Detail Informasi Pengumuman
                </h3>

                <div class="space-y-5">
                    
                    <!-- Judul Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Pengumuman / Edaran Resmi <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ $isEdit ? 'Jadwal Pemutakhiran Data Mandiri Pegawai Semester 1 Tahun 2026' : '' }}" placeholder="Contoh: Edaran Pemutakhiran Berkas SK & Serdik Tahun 2026" required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <!-- Target Audience -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Target Sasaran Penerima (Audience) <span class="text-red-500">*</span></label>
                            <select name="target_audience" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none cursor-pointer">
                                <option value="SEMUA">Semua Pegawai &amp; Operator Sekolah</option>
                                <option value="OPERATOR">Operator Sekolah Saja</option>
                                <option value="GURU_SERDIK">Guru Bersertifikasi (Serdik)</option>
                                <option value="PPPK">Pegawai PPPK Saja</option>
                                <option value="PUBLIK">Publik &amp; Umum</option>
                            </select>
                        </div>

                        <!-- Status Terbit -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Status Terbit / Publikasi <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none cursor-pointer font-bold text-blue-900">
                                <option value="PUBLISHED">Langsung Dipublikasikan (Aktif)</option>
                                <option value="DRAFT">Simpan Sebagai Draft</option>
                            </select>
                        </div>

                    </div>

                    <!-- Isi Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Isi / Detail Pengumuman Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="7" placeholder="Tuliskan petunjuk edaran, tenggat waktu, serta rincian persyaratan secara lengkap..." required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg p-3.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-normal leading-relaxed">{{ $isEdit ? 'Diberitahukan kepada seluruh ASN & Non-ASN Dinas Pendidikan Kabupaten Jember untuk memperbarui dokumen SK dan Ijazah sebelum tanggal 15 Agustus 2026.' : '' }}</textarea>
                    </div>

                    <!-- Lampiran Berkas PDF -->
                    <div class="border-2 border-dashed border-gray-200 hover:border-blue-500 rounded-2xl p-5 text-center bg-gray-50/60 transition group cursor-pointer"
                         onclick="document.getElementById('attachment_input').click()">
                        <input type="file" name="attachment" id="attachment_input" accept=".pdf" class="hidden">
                        <div class="space-y-1.5">
                            <div class="w-10 h-10 rounded-2xl bg-rose-100 group-hover:bg-rose-600 text-rose-600 group-hover:text-white mx-auto flex items-center justify-center transition shadow-xs">
                                <i class="fas fa-file-pdf text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-800">Upload Surat Edaran / Lampiran PDF (Opsional)</p>
                            <p class="text-[10px] text-gray-400">Format: PDF (Maksimal 5 MB)</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-gray-700 font-bold text-[10px] shadow-xs group-hover:border-blue-300 group-hover:text-blue-800 transition mt-1">
                                <i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas Surat Edaran
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('pengumuman.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-blue-800 hover:bg-blue-900 rounded-lg shadow-md shadow-blue-900/30 transition flex items-center gap-2">
                        <i class="fas fa-save"></i> {{ $isEdit ? 'Perbarui Pengumuman' : 'Simpan & Publis Pengumuman' }}
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
