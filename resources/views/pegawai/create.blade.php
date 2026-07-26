@extends('layouts.app')

@section('title', 'Tambah Data Pegawai - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">Form Input Data Pegawai (PTK)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Lengkapi identitas diri, 7 kriteria kepegawaian, serta unggah berkas pendukung dalam format PDF.
                </p>
            </div>
            
            <!-- Kembali Button (Placed on Right Side) -->
            <a href="{{ url('/pegawai') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Data Pegawai</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20">
        <form action="{{ url('/pegawai') }}" method="GET" class="space-y-6">
            
            <!-- SECTION 1: IDENTITAS DIRI & SEKOLAH -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-user font-normal"></i> Identitas Diri & Satuan Pendidikan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Satuan Pendidikan / Sekolah (Custom Select Dropdown) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Satuan Pendidikan / Sekolah <span class="text-red-500">*</span></label>
                        <div class="custom-select-wrapper relative">
                            <button type="button" class="custom-select-trigger w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-xs text-left flex items-center justify-between transition focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                                <span class="custom-select-label font-medium text-gray-700">-- Pilih Satuan Pendidikan --</span>
                                <i class="fas fa-angle-down text-gray-400 text-xs transition-transform duration-200"></i>
                            </button>
                            
                            <div class="custom-select-options hidden absolute left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden text-xs py-1.5">
                                <div class="px-2 pb-1.5 border-b border-gray-100">
                                    <input type="text" placeholder="Cari sekolah..." class="custom-select-search w-full bg-gray-50 border border-gray-200 rounded-md px-2.5 py-1.5 text-xs focus:outline-none">
                                </div>
                                <div class="max-h-48 overflow-y-auto">
                                    <div class="custom-option px-3 py-2 hover:bg-blue-50/70 hover:text-blue-800 cursor-pointer font-medium transition" data-value="1">SMA Negeri 1 Jakarta</div>
                                    <div class="custom-option px-3 py-2 hover:bg-blue-50/70 hover:text-blue-800 cursor-pointer font-medium transition" data-value="2">SMP Negeri 3 Bandung</div>
                                    <div class="custom-option px-3 py-2 hover:bg-blue-50/70 hover:text-blue-800 cursor-pointer font-medium transition" data-value="3">SMK Negeri 2 Surabaya</div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="sekolah_id" class="custom-select-input" value="">
                        </div>
                    </div>

                    <!-- NIP / NIK -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">NIP / NIK <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Masukkan 18 digit NIP / NIK" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Nama Lengkap + Gelar -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Contoh: Dr. Ahmad Fauzi, M.Pd." required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Tanggal Lahir (Kriteria 7: Auto Calculation) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Lahir (Usia otomatis dihitung) <span class="text-red-500">*</span></label>
                        <input type="date" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- SECTION 2: 7 KRITERIA UTAMA KEPEGAWAIAN -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-list-check"></i> Klasifikasi 7 Kriteria Utama (PRD Standard)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- 1. Status Kepegawaian -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">1. Status Kepegawaian <span class="text-red-500">*</span></label>
                        <select required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="PNS">PNS</option>
                            <option value="PPPK">PPPK</option>
                            <option value="PPPK PW">PPPK PW (Paruh Waktu)</option>
                            <option value="Non-ASN">Non-ASN</option>
                        </select>
                    </div>

                    <!-- 2. Jabatan Fungsional -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">2. Jabatan Fungsional <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Contoh: Guru Ahli Muda" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- 3. Sertifikasi Pendidik (Serdik) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">3. Status Sertifikasi (Serdik) <span class="text-red-500">*</span></label>
                        <select required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="1">Sudah Serdik (Bersertifikasi)</option>
                            <option value="0">Belum Serdik</option>
                        </select>
                    </div>

                    <!-- 4. Jenis PTK -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">4. Jenis PTK <span class="text-red-500">*</span></label>
                        <select required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="Pendidik">Pendidik (Guru)</option>
                            <option value="Tenaga Kependidikan">Tenaga Kependidikan (TU/Laboran)</option>
                        </select>
                    </div>

                    <!-- 5. Jenis Guru -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">5. Jenis Guru <span class="text-red-500">*</span></label>
                        <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="Guru Kelas">Guru Kelas</option>
                            <option value="Guru Mapel">Guru Mata Pelajaran</option>
                            <option value="Guru BK">Guru BK</option>
                        </select>
                    </div>

                    <!-- 6. Tingkat Pendidikan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">6. Tingkat Pendidikan <span class="text-red-500">*</span></label>
                        <select required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="SMA/K">SMA/K</option>
                            <option value="D3">D3</option>
                            <option value="S1/D4" selected>S1 / D4</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: UPLOAD BERKAS PENDUKUNG (PDF Max 2 MB) -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Upload Berkas Pendukung (Format PDF, Max 2 MB)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- File SK -->
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-blue-800 transition cursor-pointer bg-gray-50/50">
                        <i class="fas fa-cloud-arrow-up text-2xl text-blue-800 mb-2"></i>
                        <p class="text-xs font-bold text-gray-800">SK Kepegawaian</p>
                        <p class="text-[10px] text-gray-400 mt-1">Upload PDF (Max 2MB)</p>
                        <input type="file" class="hidden" accept=".pdf">
                    </div>

                    <!-- File Serdik -->
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-blue-800 transition cursor-pointer bg-gray-50/50">
                        <i class="fas fa-certificate text-2xl text-emerald-600 mb-2"></i>
                        <p class="text-xs font-bold text-gray-800">Sertifikat Pendidik</p>
                        <p class="text-[10px] text-gray-400 mt-1">Upload PDF (Max 2MB)</p>
                        <input type="file" class="hidden" accept=".pdf">
                    </div>

                    <!-- File Ijazah -->
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-blue-800 transition cursor-pointer bg-gray-50/50">
                        <i class="fas fa-graduation-cap text-2xl text-purple-600 mb-2"></i>
                        <p class="text-xs font-bold text-gray-800">Ijazah Terakhir</p>
                        <p class="text-[10px] text-gray-400 mt-1">Upload PDF (Max 2MB)</p>
                        <input type="file" class="hidden" accept=".pdf">
                    </div>

                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ url('/pegawai') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-blue-800 hover:bg-blue-900 rounded-lg shadow-md shadow-blue-900/30 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data Pegawai
                </button>
            </div>

        </form>
    </div>
@endsection
