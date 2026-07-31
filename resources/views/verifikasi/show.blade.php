@extends('layouts.app')

@section('title', 'Tinjau Berkas - ' . $pegawai->nama_lengkap . ' - SIMPEG-SP')

@section('content')
    <!-- ===== HERO BLUE BANNER (Hope UI Deep Blue Design) ===== -->
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
                    <a href="{{ route('verifikasi.index') }}" class="hover:underline opacity-80">Verifikasi &amp; Validasi</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="font-semibold text-white">Tinjau Dokumen</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight">Tinjau Dokumen Kepegawaian</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90 mt-1">
                    {{ $pegawai->nama_lengkap }} (NIP. {{ $pegawai->nip_nik ?: '-' }}) — {{ $pegawai->sekolah->nama_sekolah ?? 'Tanpa Sekolah' }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                @php $st = $pegawai->status_verifikasi ?? 'DRAFT'; @endphp
                @if($st === 'DISETUJUI')
                    <span class="px-3.5 py-2 rounded-lg text-xs font-extrabold bg-emerald-500 text-white shadow-sm flex items-center gap-2 border border-emerald-400">
                        <i class="fas fa-circle-check"></i> Status: Disetujui &amp; Valid
                    </span>
                @elseif($st === 'REVISI')
                    <span class="px-3.5 py-2 rounded-lg text-xs font-extrabold bg-rose-500 text-white shadow-sm flex items-center gap-2 border border-rose-400">
                        <i class="fas fa-triangle-exclamation"></i> Status: Perlu Revisi
                    </span>
                @elseif($st === 'MENUNGGU')
                    <span class="px-3.5 py-2 rounded-lg text-xs font-extrabold bg-amber-500 text-white shadow-sm flex items-center gap-2 border border-amber-400">
                        <i class="fas fa-hourglass-half"></i> Status: Menunggu Verifikasi
                    </span>
                @else
                    <span class="px-3.5 py-2 rounded-lg text-xs font-extrabold bg-white/20 text-white shadow-sm flex items-center gap-2 border border-white/20 backdrop-blur-md">
                        <i class="fas fa-file-arrow-up"></i> Status: Draft / Belum Upload
                    </span>
                @endif

                <a href="{{ route('verifikasi.index') }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm flex items-center gap-2 transition backdrop-blur-md">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Kembali ke Daftar Verifikasi</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between relative z-30 -mt-8">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between relative z-30 -mt-8">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- OVERLAPPING PROFILES & VERIFICATION DECISION GRID -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 -mt-10 md:-mt-12 relative z-20">
            
            <!-- LEFT COLUMN (2 COLS): PEGAWAI DETAIL & DOCUMENT FILES -->
            <div class="xl:col-span-2 space-y-6">

                <!-- Pegawai Profile Overview Card -->
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fas fa-id-card text-blue-800"></i> Informasi Identitas Pegawai
                        </h3>
                        <span class="text-xs text-gray-400 font-medium">Satuan Pendidikan: {{ $pegawai->sekolah->nama_sekolah ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <p class="text-gray-400 font-medium">Nama Lengkap</p>
                            <p class="font-bold text-gray-900 text-sm mt-0.5">{{ $pegawai->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">NIP / NIK</p>
                            <p class="font-bold text-gray-900 text-sm font-mono mt-0.5">{{ $pegawai->nip_nik ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Status Kepegawaian</p>
                            <p class="font-bold text-blue-800 mt-0.5">{{ $pegawai->status_kepegawaian }} {{ $pegawai->pangkat_golongan ? '('.$pegawai->pangkat_golongan.')' : '' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Jabatan Fungsional</p>
                            <p class="font-bold text-gray-900 mt-0.5">{{ $pegawai->jabatan_fungsional ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Pendidikan Terakhir</p>
                            <p class="font-bold text-gray-900 mt-0.5">{{ $pegawai->tingkat_pendidikan }} {{ $pegawai->jurusan_prodi ? '- '.$pegawai->jurusan_prodi : '' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Sertifikat Pendidik (Serdik)</p>
                            <p class="font-bold mt-0.5 {{ $pegawai->is_serdik ? 'text-emerald-600' : 'text-gray-500' }}">
                                {{ $pegawai->is_serdik ? 'Sudah Serdik (No: '.($pegawai->no_serdik ?: '-').')' : 'Belum Serdik' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Document Files Cards List -->
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                    <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                        <h3 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fas fa-folder-open text-blue-800"></i> Dokumen Berkas Kepegawaian
                        </h3>
                        <span class="text-xs text-gray-400">Pratinjau &amp; Unduh File Berkas</span>
                    </div>

                    <div class="space-y-4">
                        
                        <!-- File 1: SK Kepegawaian -->
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">1. SK Kepegawaian (SK Jabatan/Pengangkatan)</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        Status File: 
                                        @if(count($pegawai->file_sk) > 0)
                                            <span class="font-bold text-emerald-600">Tersedia (PDF / Gambar)</span>
                                        @else
                                            <span class="font-bold text-gray-400">Belum Diunggah</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if(count($pegawai->file_sk) > 0)
                                    <button type="button" onclick='openFileModal("SK Kepegawaian - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_sk))' class="px-3.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1.5">
                                        <i class="fas fa-images"></i> Lihat {{ count($pegawai->file_sk) }} Berkas
                                    </button>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-200 text-gray-500 rounded-lg text-xs font-semibold cursor-not-allowed">Belum Ada File</span>
                                @endif
                            </div>
                        </div>

                        <!-- File 2: Sertifikat Pendidik -->
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">2. Sertifikat Pendidik (Serdik)</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        Status File: 
                                        @if(count($pegawai->file_serdik) > 0)
                                            <span class="font-bold text-emerald-600">Tersedia (PDF / Gambar)</span>
                                        @else
                                            <span class="font-bold text-gray-400">Belum Diunggah</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if(count($pegawai->file_serdik) > 0)
                                    <button type="button" onclick='openFileModal("Sertifikat Pendidik - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_serdik))' class="px-3.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1.5">
                                        <i class="fas fa-images"></i> Lihat {{ count($pegawai->file_serdik) }} Berkas
                                    </button>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-200 text-gray-500 rounded-lg text-xs font-semibold cursor-not-allowed">Belum Ada File</span>
                                @endif
                            </div>
                        </div>

                        <!-- File 3: Ijazah Pendidikan -->
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">3. Ijazah Pendidikan Terakhir</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        Status File: 
                                        @if(count($pegawai->file_ijazah) > 0)
                                            <span class="font-bold text-emerald-600">Tersedia (PDF / Gambar)</span>
                                        @else
                                            <span class="font-bold text-gray-400">Belum Diunggah</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if(count($pegawai->file_ijazah) > 0)
                                    <button type="button" onclick='openFileModal("Ijazah Terakhir - {{ addslashes($pegawai->nama_lengkap) }}", @json($pegawai->file_ijazah))' class="px-3.5 py-1.5 bg-blue-800 hover:bg-blue-900 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1.5">
                                        <i class="fas fa-images"></i> Lihat {{ count($pegawai->file_ijazah) }} Berkas
                                    </button>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-200 text-gray-500 rounded-lg text-xs font-semibold cursor-not-allowed">Belum Ada File</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1 COL): DECISION FORM & VERIFICATION LOG -->
            <div class="space-y-6">

                <!-- Form Keputusan Verifikasi Dinas -->
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-blue-800"></i> Form Keputusan Verifikasi Dinas
                        </h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Pilih status verifikasi dan berikan catatan perbaikan jika ada.</p>
                    </div>

                    <form action="{{ route('verifikasi.update-status', $pegawai->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Status Selection Radio -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Status Verifikasi:</label>
                            <div class="space-y-2">
                                
                                <!-- Opsi 1: Disetujui & Valid -->
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 hover:border-emerald-500 hover:bg-emerald-50/40 cursor-pointer transition">
                                    <input type="radio" name="status_verifikasi" value="DISETUJUI" 
                                           {{ ($pegawai->status_verifikasi ?? '') === 'DISETUJUI' ? 'checked' : '' }} 
                                           class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                    <div>
                                        <p class="text-xs font-bold text-emerald-800">Disetujui &amp; Valid</p>
                                        <p class="text-[10px] text-gray-500">Seluruh dokumen kepegawaian sah &amp; memenuhi kriteria.</p>
                                    </div>
                                </label>

                                <!-- Opsi 2: Revisi (Perlu Perbaikan) -->
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 hover:border-rose-500 hover:bg-rose-50/40 cursor-pointer transition">
                                    <input type="radio" name="status_verifikasi" value="REVISI" 
                                           {{ ($pegawai->status_verifikasi ?? '') === 'REVISI' ? 'checked' : '' }} 
                                           class="mt-0.5 text-rose-600 focus:ring-rose-500">
                                    <div>
                                        <p class="text-xs font-bold text-rose-800">Revisi (Perlu Perbaikan)</p>
                                        <p class="text-[10px] text-gray-500">Dokumen ditolak/kurang jelas, mengembalikan ke Operator Sekolah.</p>
                                    </div>
                                </label>

                                <!-- Opsi 3: Menunggu Verifikasi -->
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 hover:border-amber-500 hover:bg-amber-50/40 cursor-pointer transition">
                                    <input type="radio" name="status_verifikasi" value="MENUNGGU" 
                                           {{ ($pegawai->status_verifikasi ?? 'MENUNGGU') === 'MENUNGGU' ? 'checked' : '' }} 
                                           class="mt-0.5 text-amber-600 focus:ring-amber-500">
                                    <div>
                                        <p class="text-xs font-bold text-amber-800">Menunggu Verifikasi</p>
                                        <p class="text-[10px] text-gray-500">Dalam proses antrean peninjauan dinas.</p>
                                    </div>
                                </label>

                                <!-- Opsi 4: Draft / Belum Upload -->
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 hover:border-gray-400 hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="status_verifikasi" value="DRAFT" 
                                           {{ ($pegawai->status_verifikasi ?? '') === 'DRAFT' ? 'checked' : '' }} 
                                           class="mt-0.5 text-gray-600 focus:ring-gray-500">
                                    <div>
                                        <p class="text-xs font-bold text-gray-700">Draft / Belum Upload</p>
                                        <p class="text-[10px] text-gray-400">File berkas belum lengkap diunggah.</p>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- Catatan Revisi Textarea -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                Catatan Revisi / Perbaikan <span class="text-rose-600">*</span>
                            </label>
                            <textarea name="catatan_verifikasi" rows="4" 
                                      placeholder="Tuliskan catatan detail perbaikan berkas untuk Operator Sekolah (Wajib diisi jika status Revisi)..."
                                      class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">{{ old('catatan_verifikasi', $pegawai->catatan_verifikasi) }}</textarea>
                        </div>

                        <!-- Submit Decision Button -->
                        <button type="submit" class="w-full py-3 bg-blue-800 hover:bg-blue-900 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-check-double text-sm"></i>
                            <span>Simpan Keputusan Verifikasi</span>
                        </button>
                    </form>
                </div>

                <!-- Last Verification Log Info Card -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200/80 text-xs space-y-2">
                    <p class="font-extrabold text-gray-800 flex items-center gap-1.5">
                        <i class="fas fa-clock-rotate-left text-blue-800"></i> Informasi Riwayat Verifikasi
                    </p>
                    <div class="text-gray-500 space-y-1 text-[11px]">
                        <p>Diverifikasi oleh: <span class="font-bold text-gray-800">{{ $pegawai->verifier->name ?? 'Admin System' }}</span></p>
                        <p>Tanggal update: <span class="font-bold text-gray-800">{{ $pegawai->tgl_verifikasi ? $pegawai->tgl_verifikasi->format('d M Y H:i') : '-' }}</span></p>
                    </div>

                    @if($pegawai->catatan_verifikasi)
                        <div class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-lg text-rose-900">
                            <p class="font-bold text-[11px] text-rose-800 flex items-center gap-1">
                                <i class="fas fa-triangle-exclamation"></i> Catatan Revisi Saat Ini:
                            </p>
                            <p class="text-xs mt-1 italic">"{{ $pegawai->catatan_verifikasi }}"</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

    <!-- Modal Preview Berkas -->
    <div id="filePreviewModal" class="hidden fixed inset-0 flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm animate-fadeIn" style="z-index: 99999 !important;">
        <div class="bg-white rounded-2xl w-full max-w-3xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-sm font-bold text-gray-800" id="filePreviewTitle">Preview Berkas</h3>
                <button onclick="closeFileModal()" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <!-- Body -->
            <div class="p-6 overflow-y-auto flex-1 bg-gray-50/30">
                <div id="filePreviewContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Content generated by JS -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Modal Logics
            window.openFileModal = function(title, files) {
                const modal = document.getElementById('filePreviewModal');
                if (!modal) return;

                // Move modal to body root to avoid parent z-index stacking issues
                document.body.appendChild(modal);

                document.getElementById('filePreviewTitle').innerText = title;
                const container = document.getElementById('filePreviewContainer');
                container.innerHTML = '';
                
                if (files && files.length > 0) {
                    files.forEach(file => {
                        const cleanFile = String(file).replace(/^["']|["']$/g, '').replace(/\\/g, '/');
                        const url = '{{ asset("files") }}/' + cleanFile;
                        const ext = cleanFile.split('.').pop().toLowerCase();
                        
                        if (ext === 'pdf') {
                            container.innerHTML += `
                                <div class="group relative rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all bg-slate-50 flex flex-col items-center justify-center p-4 min-h-[220px]">
                                    <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xl font-bold mb-2 shadow-sm">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <p class="text-xs font-bold text-gray-800 text-center mb-1 truncate max-w-full px-2" title="${cleanFile.split('/').pop()}">${cleanFile.split('/').pop()}</p>
                                    <p class="text-[10px] text-gray-400 font-medium mb-3">Dokumen Berkas PDF</p>
                                    <div class="flex items-center gap-2 w-full mt-auto">
                                        <a href="${url}" target="_blank" class="flex-1 py-2 px-3 bg-blue-800 hover:bg-blue-900 text-white rounded-lg text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                                            <i class="fas fa-external-link-alt text-[10px]"></i> Buka / Pratinjau PDF
                                        </a>
                                    </div>
                                </div>
                            `;
                        } else {
                            container.innerHTML += `
                                <div class="group relative rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all">
                                    <a href="${url}" target="_blank" class="block">
                                        <img src="${url}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-[10px] font-bold bg-blue-600/80 px-3 py-1.5 rounded-full backdrop-blur-sm shadow-lg"><i class="fas fa-external-link-alt mr-1"></i> Buka Penuh</span>
                                        </div>
                                    </a>
                                </div>
                            `;
                        }
                    });
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-xs text-gray-400 py-8 italic">Tidak ada berkas</div>';
                }
                
                modal.classList.remove('hidden');
            };

            window.closeFileModal = function() {
                const modal = document.getElementById('filePreviewModal');
                if (modal) modal.classList.add('hidden');
            };
        </script>
    @endpush
@endsection
