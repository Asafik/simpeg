@extends('layouts.app')

@section('title', 'Verifikasi Data & Berkas - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Verifikasi & Validasi Berkas</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Peninjauan berkas SK Kepegawaian, Sertifikat Pendidik, dan Ijazah pegawai terdaftar.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-amber-300 bg-white/15 backdrop-blur-md border border-white/20 px-3.5 py-2.5 rounded-lg shadow-sm">
                    <i class="fas fa-clock mr-1 text-amber-400"></i> {{ $countMenunggu }} Berkas Menunggu Verifikasi
                </span>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
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

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- Status Tabs Card -->
        <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-wrap items-center gap-2 text-xs font-bold">
            <a href="{{ route('verifikasi.index', ['status' => 'Menunggu']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $status === 'Menunggu' ? 'bg-blue-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Menunggu Verifikasi ({{ $countMenunggu }})
            </a>
            <a href="{{ route('verifikasi.index', ['status' => 'Disetujui']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $status === 'Disetujui' ? 'bg-emerald-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Disetujui ({{ $countDisetujui }})
            </a>
            <a href="{{ route('verifikasi.index', ['status' => 'Ditolak']) }}" class="px-4 py-2 rounded-lg shadow-sm transition {{ $status === 'Ditolak' ? 'bg-rose-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Ditolak ({{ $countDitolak }})
            </a>
        </div>

        <!-- Verification Cards Grid -->
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
                                    <p class="text-[10px] text-gray-400">NIP/NIK: {{ $pegawai->nip_nik ?: '-' }} • {{ $pegawai->sekolah->nama_sekolah ?? '-' }}</p>
                                </div>
                            </div>
                            @if($pegawai->status_verifikasi === 'Disetujui')
                                <span class="badge-custom bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-circle-check mr-1"></i>Disetujui
                                </span>
                            @elseif($pegawai->status_verifikasi === 'Ditolak')
                                <span class="badge-custom bg-rose-100 text-rose-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-circle-xmark mr-1"></i>Ditolak
                                </span>
                            @else
                                <span class="badge-custom bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                                </span>
                            @endif
                        </div>

                        <!-- Dokumen Berkas Box -->
                        <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-2 border border-gray-100">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Dokumen Berkas Terlampir:</p>
                            
                            <div class="space-y-1.5">
                                @if($pegawai->file_sk)
                                    <div class="flex items-center justify-between text-gray-700 text-xs">
                                        <span class="flex items-center gap-1.5"><i class="fas fa-file-pdf text-red-500"></i> SK Kepegawaian</span>
                                        <a href="{{ asset('storage/' . $pegawai->file_sk) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    </div>
                                @endif

                                @if($pegawai->file_serdik)
                                    <div class="flex items-center justify-between text-gray-700 text-xs">
                                        <span class="flex items-center gap-1.5"><i class="fas fa-file-pdf text-emerald-600"></i> Sertifikat Pendidik (Serdik)</span>
                                        <a href="{{ asset('storage/' . $pegawai->file_serdik) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    </div>
                                @endif

                                @if($pegawai->file_ijazah)
                                    <div class="flex items-center justify-between text-gray-700 text-xs">
                                        <span class="flex items-center gap-1.5"><i class="fas fa-file-pdf text-blue-600"></i> Ijazah Terakhir</span>
                                        <a href="{{ asset('storage/' . $pegawai->file_ijazah) }}" target="_blank" class="text-blue-800 font-bold hover:underline">Lihat PDF</a>
                                    </div>
                                @endif

                                @if(!$pegawai->file_sk && !$pegawai->file_serdik && !$pegawai->file_ijazah)
                                    <p class="text-gray-400 italic text-[11px]">Belum ada berkas PDF diunggah.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Catatan Verifikasi Jika Ada -->
                        @if($pegawai->catatan_verifikasi)
                            <div class="bg-rose-50 border border-rose-100 rounded-lg p-2.5 text-xs text-rose-800">
                                <p class="font-bold text-[10px] uppercase text-rose-600">Catatan Dinas:</p>
                                <p class="mt-0.5">{{ $pegawai->catatan_verifikasi }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Bar (ONLY ADMIN DINAS CAN EXECUTE) -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                        @if(Auth::check() && method_exists(Auth::user(), 'isAdminDinas') && Auth::user()->isAdminDinas())
                            <!-- Admin Dinas Action Buttons -->
                            <button type="button" onclick="openRejectModal({{ $pegawai->id }}, '{{ addslashes($pegawai->nama_lengkap) }}')" class="px-3.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold rounded-lg transition cursor-pointer">
                                <i class="fas fa-times mr-1"></i> Tolak Berkas
                            </button>

                            <form action="{{ route('verifikasi.verify', $pegawai->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Disetujui">
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui berkas pegawai ini?')" class="px-4 py-1.5 bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-bold rounded-lg transition shadow-sm cursor-pointer">
                                    <i class="fas fa-check mr-1"></i> Setujui Berkas
                                </button>
                            </form>
                        @else
                            <!-- Operator Sekolah Status Indicator -->
                            <div class="w-full flex items-center justify-between text-xs text-gray-500">
                                <span class="italic text-[11px]">
                                    <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                                    Status Verifikasi oleh Admin Dinas
                                </span>
                                <span class="font-bold text-gray-700">
                                    {{ $pegawai->status_verifikasi ?? 'Menunggu' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl p-12 text-center text-gray-400 border border-gray-100">
                    <i class="fas fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                    <p class="font-bold text-gray-600 text-xs">Tidak ada data pegawai dengan status berkas "{{ $status }}".</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $pegawais->links() }}
        </div>
    </div>

    <!-- MODAL PENOLAKAN BERKAS (Khusus Admin Dinas) -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fas fa-circle-xmark text-rose-600"></i>
                    Tolak Berkas Pegawai
                </h3>
                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-xmark"></i></button>
            </div>

            <form id="rejectForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="status" value="Ditolak">
                
                <p class="text-xs text-gray-600">Berikan alasan / catatan penolakan untuk pegawai <strong id="rejectPegawaiName" class="text-gray-900"></strong>:</p>

                <textarea name="catatan" required rows="3" placeholder="Contoh: File SK yang diunggah buram atau bukan SK resmi..." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs focus:outline-none focus:ring-2 focus:ring-rose-500/20"></textarea>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700">Batal</button>
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-md transition">
                        Konfirmasi Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openRejectModal(id, name) {
        document.getElementById('rejectPegawaiName').innerText = name;
        document.getElementById('rejectForm').action = '/verifikasi/' + id;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endpush
