@extends('layouts.app')

@section('title', 'Kelola Data Pegawai - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER (Exact Hope UI 2-Wave Design - Deep Blue) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <!-- Exact Hope UI 2 Diagonal Wave Shapes Overlay -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <!-- Wave Shape 1 -->
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGrad1)"></path>
            <!-- Wave Shape 2 -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Data Pegawai (PTK)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola master data pendidik & tenaga kependidikan berbasis 7 kriteria utama Dinas Pendidikan.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('/pegawai/create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Tambah Pegawai</span>
                </a>
                <a href="#" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-3.5 py-2.5 rounded-lg shadow-sm flex items-center gap-1.5 transition">
                    <i class="fas fa-file-excel text-xs text-emerald-400"></i>
                    <span>Export Excel</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 -mt-8 relative z-20">

        <!-- 7 KRITERIA MULTI-FILTER BAR -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Multi-Filter Kombinasi (7 Kriteria PRD)
                </h3>
                <button class="text-xs text-gray-400 hover:text-red-500 font-semibold transition">
                    <i class="fas fa-rotate-right mr-1"></i> Reset Filter
                </button>
            </div>

            <!-- Filter Grid 7 Dropdowns + Search -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-3">
                
                <!-- Search Keyword -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari NIP / Nama / Sekolah</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" placeholder="Ketik kata kunci..." class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>

                <!-- 1. Status Kepegawaian -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">1. Status Kepegawaian</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Status (PNS, PPPK, dll)</option>
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                        <option value="PPPK PW">PPPK PW (Paruh Waktu)</option>
                        <option value="Non-ASN">Non-ASN</option>
                    </select>
                </div>

                <!-- 2. Jabatan Fungsional -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">2. Jabatan Fungsional</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Jabatan</option>
                        <option value="Guru Ahli Pertama">Guru Ahli Pertama</option>
                        <option value="Guru Ahli Muda">Guru Ahli Muda</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Penilik">Penilik</option>
                    </select>
                </div>

                <!-- 3. Sertifikasi Pendidik (Serdik) -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">3. Sertifikasi (Serdik)</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Status Serdik</option>
                        <option value="1">Sudah Serdik</option>
                        <option value="0">Belum Serdik</option>
                    </select>
                </div>

                <!-- 4. Jenis PTK -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">4. Jenis PTK</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua PTK</option>
                        <option value="Pendidik">Pendidik (Guru)</option>
                        <option value="Tenaga Kependidikan">Tenaga Kependidikan (TU/Laboran)</option>
                    </select>
                </div>

                <!-- 5. Jenis Guru -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">5. Jenis Guru</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Jenis Guru</option>
                        <option value="Guru Kelas">Guru Kelas</option>
                        <option value="Guru Mapel">Guru Mata Pelajaran</option>
                        <option value="Guru BK">Guru BK</option>
                    </select>
                </div>

                <!-- 6. Tingkat Pendidikan -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">6. Tingkat Pendidikan</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Tingkat (SMA/S1/S2)</option>
                        <option value="SMA/K">SMA/K</option>
                        <option value="D3">D3</option>
                        <option value="S1/D4">S1 / D4</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>

                <!-- 7. Kelompok Usia -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">7. Kelompok Usia</label>
                    <select class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                        <option value="">Semua Kelompok Usia</option>
                        <option value="<30">&lt; 30 Tahun</option>
                        <option value="31-40">31 - 40 Tahun</option>
                        <option value="41-50">41 - 50 Tahun</option>
                        <option value=">55">&gt; 55 Tahun (Pensiun)</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- PEGAWAI DATA TABLE -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
            
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs font-bold text-gray-700">Menampilkan 1.284 Data Pegawai</span>
                <div class="text-xs text-gray-400">
                    <span class="font-medium text-gray-600">Urutkan:</span> Terbaru Dibuat
                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5">NIP / NIK</th>
                            <th class="px-4 py-3.5">Nama & Profil</th>
                            <th class="px-4 py-3.5">Satuan Pendidikan</th>
                            <th class="px-4 py-3.5">Status</th>
                            <th class="px-4 py-3.5">Jabatan & Jenis</th>
                            <th class="px-4 py-3.5">Serdik</th>
                            <th class="px-4 py-3.5">Pendidikan</th>
                            <th class="px-4 py-3.5">Usia</th>
                            <th class="px-4 py-3.5">Berkas (PDF)</th>
                            <th class="px-4 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <!-- Row 1 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-4 py-3.5 font-bold text-gray-800 text-xs">197503212005011002</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-800 text-white font-bold text-xs flex items-center justify-center">AF</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-xs">Dr. Ahmad Fauzi, M.Pd.</p>
                                        <p class="text-[10px] text-gray-400">Laki-laki • Pendidik</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">SMA Negeri 1 Jakarta</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-blue-100 text-blue-800">PNS</span></td>
                            <td class="px-4 py-3.5">
                                <p class="text-xs text-gray-800 font-medium">Guru Ahli Muda</p>
                                <p class="text-[10px] text-gray-400">Guru Mapel Matematika</p>
                            </td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Serdik</span></td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">S2</td>
                            <td class="px-4 py-3.5 text-xs text-gray-700">51 thn</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="SK Kepegawaian"><i class="fas fa-file-pdf"></i></span>
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="Sertifikat Pendidik"><i class="fas fa-file-pdf"></i></span>
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="Ijazah Terakhir"><i class="fas fa-file-pdf"></i></span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ url('/pegawai/1') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-800 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/pegawai/create') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-4 py-3.5 font-bold text-gray-800 text-xs">198705152010012034</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">SR</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-xs">Siti Rahmawati, S.Pd.</p>
                                        <p class="text-[10px] text-gray-400">Perempuan • Pendidik</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">SMP Negeri 3 Bandung</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-100 text-emerald-800">PPPK</span></td>
                            <td class="px-4 py-3.5">
                                <p class="text-xs text-gray-800 font-medium">Guru Ahli Pertama</p>
                                <p class="text-[10px] text-gray-400">Guru Kelas</p>
                            </td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i>Serdik</span></td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">S1/D4</td>
                            <td class="px-4 py-3.5 text-xs text-gray-700">39 thn</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="SK Kepegawaian"><i class="fas fa-file-pdf"></i></span>
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="Sertifikat Pendidik"><i class="fas fa-file-pdf"></i></span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ url('/pegawai/1') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-800 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/pegawai/create') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-4 py-3.5 font-bold text-gray-800 text-xs">199203102016072045</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-pink-600 text-white font-bold text-xs flex items-center justify-center">BS</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-xs">Budi Santoso, S.Kom.</p>
                                        <p class="text-[10px] text-gray-400">Laki-laki • Tenaga Kependidikan</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">SMK Negeri 2 Surabaya</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-pink-100 text-pink-800">Non-ASN</span></td>
                            <td class="px-4 py-3.5">
                                <p class="text-xs text-gray-800 font-medium">Tenaga Laboran</p>
                                <p class="text-[10px] text-gray-400">Laboratorium IT</p>
                            </td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Non-Serdik</span></td>
                            <td class="px-4 py-3.5 text-xs text-gray-700 font-medium">S1/D4</td>
                            <td class="px-4 py-3.5 text-xs text-gray-700">34 thn</td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <span class="text-red-500 hover:text-red-700 cursor-pointer" title="Ijazah Terakhir"><i class="fas fa-file-pdf"></i></span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ url('/pegawai/1') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-800 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/pegawai/create') }}" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500">Halaman 1 dari 128</span>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-400" disabled><i class="fas fa-chevron-left"></i></button>
                    <button class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg">1</button>
                    <button class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">2</button>
                    <button class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">3</button>
                    <button class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

        </div>

    </div>
@endsection
