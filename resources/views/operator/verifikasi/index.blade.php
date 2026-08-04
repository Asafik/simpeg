@extends('layouts.app')

@section('title', 'Verifikasi & Unggah Berkas - ' . ($sekolah->nama_sekolah ?? 'Operator Sekolah'))

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Hope UI Design - Operator Palette) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGradOpVer1)"></path>
            <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGradOpVer2)"></path>
            <defs>
                <linearGradient id="hopeWaveGradOpVer1" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.5" />
                    <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.3" />
                </linearGradient>
                <linearGradient id="hopeWaveGradOpVer2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#030712" stop-opacity="0.8" />
                    <stop offset="100%" stop-color="#0f172a" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>
        
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-blue-800/60 border border-blue-400/30 text-blue-200 text-xs px-3 py-1 rounded-full mb-2 backdrop-blur-md">
                    <i class="fas fa-school text-xs"></i>
                    <span>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan' }} (NPSN: {{ $sekolah->npsn ?? '-' }})</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Unggah & Pantau Verifikasi Berkas</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Unggah dokumen resmi (SK, Serdik, Ijazah) pegawai dan pantau status persetujuan dari Administrator Dinas.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-amber-300 bg-white/15 backdrop-blur-md border border-white/20 px-3.5 py-2.5 rounded-lg shadow-sm">
                    <i class="fas fa-clock mr-1 text-amber-400"></i> {{ $countMenunggu }} Menunggu Verifikasi
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">

        <!-- Flash Messages Alert -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-circle-info text-blue-600 text-sm"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- Status Tabs & Filter -->
        <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-wrap items-center justify-between gap-3 text-xs font-bold">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('operator.verifikasi.index') }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $statusFilter === '' ? 'bg-blue-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Semua Pegawai ({{ $totalPegawai }})
                </a>
                <a href="{{ route('operator.verifikasi.index', ['status' => 'Menunggu']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $statusFilter === 'Menunggu' ? 'bg-amber-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Menunggu Verifikasi ({{ $countMenunggu }})
                </a>
                <a href="{{ route('operator.verifikasi.index', ['status' => 'Disetujui']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $statusFilter === 'Disetujui' ? 'bg-emerald-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Disetujui ({{ $countDisetujui }})
                </a>
                <a href="{{ route('operator.verifikasi.index', ['status' => 'Ditolak']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $statusFilter === 'Ditolak' ? 'bg-rose-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Ditolak / Perlu Perbaikan ({{ $countDitolak }})
                </a>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($pegawais as $pegawai)
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                @php
                                    $words = explode(' ', $pegawai->nama_lengkap ?? 'P T');
                                    $initials = strtoupper(substr($words[0] ?? 'P', 0, 1) . substr($words[1] ?? 'T', 0, 1));
                                @endphp
                                <div class="w-10 h-10 rounded-full bg-blue-800 text-white font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-xs">{{ $pegawai->nama_lengkap }}</h3>
                                    <p class="text-[10px] text-gray-400">NIP/NIK: {{ $pegawai->nip_nik ?: '-' }} • {{ $pegawai->status_kepegawaian }}</p>
                                </div>
                            </div>

                            @if($pegawai->status_verifikasi === 'Disetujui')
                                <span class="badge-custom bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-circle-check mr-1"></i>Disetujui
                                </span>
                            @elseif($pegawai->status_verifikasi === 'Ditolak')
                                <span class="badge-custom bg-rose-100 text-rose-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-circle-xmark mr-1"></i>Perlu Perbaikan
                                </span>
                            @else
                                <span class="badge-custom bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                                </span>
                            @endif
                        </div>

                        <!-- Kelengkapan Dokumen Box -->
                        <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-2 border border-gray-100">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Status Kelengkapan Dokumen:</p>
                            
                            <div class="space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-gray-700">
                                        <i class="fas fa-file-pdf {{ $pegawai->file_sk ? 'text-red-500' : 'text-gray-300' }}"></i>
                                        SK Kepegawaian
                                    </span>
                                    @if($pegawai->file_sk)
                                        <a href="{{ asset('files/' . $pegawai->file_sk) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    @else
                                        <span class="text-rose-500 text-[10px] font-semibold">Belum Diunggah</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-gray-700">
                                        <i class="fas fa-file-pdf {{ $pegawai->file_serdik ? 'text-emerald-600' : 'text-gray-300' }}"></i>
                                        Sertifikat Pendidik (Serdik)
                                    </span>
                                    @if($pegawai->file_serdik)
                                        <a href="{{ asset('files/' . $pegawai->file_serdik) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    @else
                                        <span class="text-gray-400 text-[10px]">Belum Diunggah</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-gray-700">
                                        <i class="fas fa-file-pdf {{ $pegawai->file_ijazah ? 'text-blue-600' : 'text-gray-300' }}"></i>
                                        Ijazah Terakhir
                                    </span>
                                    @if($pegawai->file_ijazah)
                                        <a href="{{ asset('files/' . $pegawai->file_ijazah) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    @else
                                        <span class="text-gray-400 text-[10px]">Belum Diunggah</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Penolakan Dari Dinas Jika Ada -->
                        @if($pegawai->catatan_verifikasi)
                            <div class="bg-rose-50 border border-rose-200 rounded-lg p-3 text-xs text-rose-900 space-y-1">
                                <p class="font-bold text-[11px] text-rose-700 flex items-center gap-1.5">
                                    <i class="fas fa-triangle-exclamation text-rose-600"></i> Catatan Perbaikan Dinas:
                                </p>
                                <p class="text-xs leading-relaxed">{{ $pegawai->catatan_verifikasi }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Action Button -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                        <span class="text-[11px] text-gray-400">
                            Terakhir diperbarui: {{ $pegawai->updated_at ? $pegawai->updated_at->diffForHumans() : '-' }}
                        </span>
                        <button type="button" onclick="openUploadModal({{ $pegawai->id }}, '{{ addslashes($pegawai->nama_lengkap) }}')" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fas fa-upload"></i> Unggah / Perbarui Berkas
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl p-12 text-center text-gray-400 border border-gray-100">
                    <i class="fas fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                    <p class="font-bold text-gray-600 text-xs">Belum ada data pegawai untuk status ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $pegawais->links() }}
        </div>
    </div>

    <!-- MODAL UNGGAH BERKAS OPERATOR -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 scale-95" id="uploadModalCard">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-950 to-indigo-900 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-blue-300 border border-white/15">
                        <i class="fas fa-file-arrow-up text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Unggah Dokumen Berkas</h3>
                        <p class="text-[10px] text-blue-200" id="uploadPegawaiName">Nama Pegawai</p>
                    </div>
                </div>
                <button type="button" onclick="closeUploadModal()" class="text-gray-300 hover:text-white p-1 transition"><i class="fas fa-xmark text-lg"></i></button>
            </div>

            <!-- Modal Body Form -->
            <form id="uploadForm" method="POST" action="" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-900 flex items-start gap-2.5">
                    <i class="fas fa-circle-info text-blue-600 text-sm mt-0.5 flex-shrink-0"></i>
                    <p class="text-[11px] leading-relaxed">
                        Pilih berkas PDF atau gambar (Maks. 2MB) untuk diunggah. Pengunggahan berkas akan otomatis mengubah status verifikasi menjadi <strong>Menunggu Verifikasi</strong> oleh Admin Dinas.
                    </p>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">SK Kepegawaian (PDF / Image)</label>
                        <input type="file" name="file_sk" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-xl border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Sertifikat Pendidik / Serdik (PDF / Image)</label>
                        <input type="file" name="file_serdik" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-xl border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Ijazah Terakhir (PDF / Image)</label>
                        <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-xl border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 transition">Batal</button>
                    <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-5 py-2 rounded-lg shadow-md transition flex items-center gap-1.5">
                        <i class="fas fa-upload"></i> Unggah & Ajukan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openUploadModal(id, name) {
        document.getElementById('uploadPegawaiName').innerText = name;
        document.getElementById('uploadForm').action = '/operator/verifikasi/' + id + '/upload';
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }
</script>
@endpush
