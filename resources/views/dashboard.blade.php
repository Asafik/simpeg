@extends('layouts.app')

@section('title', 'SIMPEG-SP - Dashboard Admin Dinas')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE WELCOME BANNER (Exact Hope UI 2-Wave Design - Deep Blue) ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white px-6 md:px-10 pt-8 md:pt-10 pb-20 md:pb-24 shadow-lg shadow-blue-950/20 overflow-hidden">
        <!-- Exact Hope UI 2 Diagonal Wave Shapes Overlay -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
            <!-- Wave Shape 1 (Diagonal curve pointing to top-right) -->
            <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGrad1)"></path>
            
            <!-- Wave Shape 2 (Diagonal dark curve pointing down-right) -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Hello Devs! / Admin Dinas</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Selamat datang di Dashboard SIMPEG-SP. Pantau pergerakan data pegawai, status verifikasi berkas, dan laporan seluruh satuan pendidikan secara real-time.
                </p>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT BODY (With padding & overlapping stat cards) ===== -->
    <div class="px-4 md:px-8 pb-8 flex-1">
        <!-- ===== OVERLAPPING SUMMARY CARDS ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 -mt-12 md:-mt-14 mb-6 relative z-20">
            <!-- Card 1: Total Pegawai -->
            <div class="stat-card bg-white rounded-lg p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-arrow-up-right text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Pegawai</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900 mt-0.5">1.284</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: PNS -->
            <div class="stat-card bg-white rounded-lg p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-500 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-arrow-down-left text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">PNS</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900 mt-0.5">547</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: PPPK -->
            <div class="stat-card bg-white rounded-lg p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-arrow-down-left text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">PPPK</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900 mt-0.5">386</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 4: PPPK PW -->
            <div class="stat-card bg-white rounded-lg p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-teal-500 flex items-center justify-center text-teal-500 font-bold bg-teal-50/50 flex-shrink-0">
                        <i class="fas fa-arrow-up-right text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">PPPK PW</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900 mt-0.5">94</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 5: Non-ASN -->
            <div class="stat-card bg-white rounded-lg p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-purple-500 flex items-center justify-center text-purple-500 font-bold bg-purple-50/50 flex-shrink-0">
                        <i class="fas fa-arrow-up-right text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Non-ASN</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900 mt-0.5">257</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>
        </div>

        <!-- ===== RECENT MOVEMENT & CALENDAR ROW ===== -->
        <div class="grid lg:grid-cols-3 gap-6 mb-6">
            <!-- Recent Movement Chart (2 Cols) -->
            <div class="lg:col-span-2 bg-white rounded-lg p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <h3 class="text-base font-semibold text-gray-700">Recent Movement</h3>
                    <div class="flex items-center gap-2">
                        <!-- Dropdown Selector -->
                        <div class="relative">
                            <select id="movementMonthSelect" class="appearance-none bg-gray-50 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg px-3 py-1.5 pr-7 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                                <option value="Jan" selected>Jan</option>
                                <option value="Feb">Feb</option>
                                <option value="Mar">Mar</option>
                                <option value="Apr">Apr</option>
                                <option value="May">May</option>
                                <option value="Jun">Jun</option>
                                <option value="Jul">Jul</option>
                                <option value="Aug">Aug</option>
                                <option value="Sep">Sep</option>
                                <option value="Oct">Oct</option>
                                <option value="Nov">Nov</option>
                                <option value="Dec">Dec</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                        </div>
                        <!-- Search Box -->
                        <div class="relative">
                            <input type="text" placeholder="Search.." class="bg-gray-50 border border-gray-200 text-gray-600 text-xs rounded-lg px-3 py-1.5 w-28 md:w-36 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                        </div>
                    </div>
                </div>
                <div class="chart-container" style="height: 240px;">
                    <canvas id="recentMovementChart"></canvas>
                </div>
            </div>

            <!-- Calendar Widget (1 Col) -->
            <div class="bg-white rounded-lg p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <!-- Calendar Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-900/10 text-blue-800 flex items-center justify-center font-bold">
                                <i class="far fa-calendar-alt text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">Kalender Agenda</h3>
                                <p class="text-[11px] text-gray-400" id="calendarMonthYear">Juli 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-gray-400">
                            <button id="prevMonth" class="w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center transition text-xs">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="nextMonth" class="w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center transition text-xs">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Day Names -->
                    <div class="grid grid-cols-7 text-center text-[11px] font-semibold text-gray-400 mb-2">
                        <span>Min</span>
                        <span>Sen</span>
                        <span>Sel</span>
                        <span>Rab</span>
                        <span>Kam</span>
                        <span>Jum</span>
                        <span>Sab</span>
                    </div>

                    <!-- Days Grid -->
                    <div class="grid grid-cols-7 text-center text-xs gap-y-1 text-gray-600 font-medium" id="calendarDaysGrid">
                    </div>
                </div>

                <!-- Upcoming Agenda / Event Notes -->
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 mb-2">Agenda Terdekat</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-blue-900/10 border border-blue-900/20">
                            <div class="w-2 h-2 rounded-full bg-blue-800 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800 truncate">Verifikasi Berkas PPPK</p>
                                <p class="text-[10px] text-gray-500">Hari ini, 25 Juli • 12 Berkas</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-amber-50/60 border border-amber-100/50">
                            <div class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800 truncate">Rapat Koordinasi Dinas</p>
                                <p class="text-[10px] text-gray-500">28 Juli 2026 • 09:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== CHARTS ROW ===== -->
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <!-- Chart 1: Status Kepegawaian -->
            <div class="bg-white rounded-lg p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">
                        <i class="fas fa-chart-bar text-blue-800 mr-2"></i>
                        Distribusi Status Kepegawaian
                    </h3>
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        Detail
                    </a>
                </div>
                <div class="chart-container" style="height: 240px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Sebaran Usia -->
            <div class="bg-white rounded-lg p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">
                        <i class="fas fa-users text-purple-600 mr-2"></i>
                        Sebaran Kelompok Usia
                    </h3>
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        Detail
                    </a>
                </div>
                <div class="chart-container" style="height: 240px;">
                    <canvas id="usiaChart"></canvas>
                </div>
            </div>
        </div>

        <!-- ===== TABLE SECTION ===== -->
        <div class="bg-white rounded-lg p-6 border border-gray-100 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
                <h3 class="font-semibold text-gray-900">
                    <i class="fas fa-list-ul text-gray-700 mr-2"></i>
                    Data Pegawai Terbaru
                </h3>
                <div class="flex items-center gap-2">
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </a>
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        <i class="fas fa-download mr-1"></i> Export
                    </a>
                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">NIP/NIK</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Sekolah</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Jabatan</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Serdik</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Pendidikan</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Usia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3.5 font-medium text-gray-800">197503212005011002</td>
                            <td class="px-4 py-3.5 text-gray-700">Dr. Ahmad Fauzi, M.Pd.</td>
                            <td class="px-4 py-3.5 text-gray-600">SMA Negeri 1 Jakarta</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-blue-50 text-blue-700">PNS</span></td>
                            <td class="px-4 py-3.5 text-gray-600">Guru Ahli Muda</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-50 text-emerald-700">Serdik</span></td>
                            <td class="px-4 py-3.5 text-gray-600">S2</td>
                            <td class="px-4 py-3.5 text-gray-600">51 thn</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3.5 font-medium text-gray-800">198705152010012034</td>
                            <td class="px-4 py-3.5 text-gray-700">Siti Rahmawati, S.Pd.</td>
                            <td class="px-4 py-3.5 text-gray-600">SMP Negeri 3 Bandung</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-50 text-emerald-700">PPPK</span></td>
                            <td class="px-4 py-3.5 text-gray-600">Guru Ahli Pertama</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-50 text-emerald-700">Serdik</span></td>
                            <td class="px-4 py-3.5 text-gray-600">S1/D4</td>
                            <td class="px-4 py-3.5 text-gray-600">39 thn</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3.5 font-medium text-gray-800">199203102016072045</td>
                            <td class="px-4 py-3.5 text-gray-700">Budi Santoso, S.Kom.</td>
                            <td class="px-4 py-3.5 text-gray-600">SMK Negeri 2 Surabaya</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-pink-50 text-pink-700">Non-ASN</span></td>
                            <td class="px-4 py-3.5 text-gray-600">Tenaga Laboran</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-red-50 text-red-700">Non-Serdik</span></td>
                            <td class="px-4 py-3.5 text-gray-600">S1/D4</td>
                            <td class="px-4 py-3.5 text-gray-600">34 thn</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3.5 font-medium text-gray-800">198212102002121003</td>
                            <td class="px-4 py-3.5 text-gray-700">Dra. Maria Ulfa, M.M.</td>
                            <td class="px-4 py-3.5 text-gray-600">SMA Negeri 5 Yogyakarta</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-blue-50 text-blue-700">PNS</span></td>
                            <td class="px-4 py-3.5 text-gray-600">Kepala Sekolah</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-emerald-50 text-emerald-700">Serdik</span></td>
                            <td class="px-4 py-3.5 text-gray-600">S2</td>
                            <td class="px-4 py-3.5 text-gray-600">44 thn</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3.5 font-medium text-gray-800">199508212021062011</td>
                            <td class="px-4 py-3.5 text-gray-700">Rina Febriani, S.Pd.</td>
                            <td class="px-4 py-3.5 text-gray-600">SD Negeri 1 Medan</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-orange-50 text-orange-700">PPPK PW</span></td>
                            <td class="px-4 py-3.5 text-gray-600">Guru Kelas</td>
                            <td class="px-4 py-3.5"><span class="badge-custom bg-red-50 text-red-700">Non-Serdik</span></td>
                            <td class="px-4 py-3.5 text-gray-600">S1/D4</td>
                            <td class="px-4 py-3.5 text-gray-600">31 thn</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="flex flex-wrap items-center justify-between gap-3 mt-5 pt-4 border-t border-gray-100">
                <span class="text-sm text-gray-500">Menampilkan 5 dari 1.284 data</span>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 rounded-lg hover:bg-gray-50 transition disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button class="px-3.5 py-1.5 text-sm font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition">1</button>
                    <button class="px-3.5 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">2</button>
                    <button class="px-3.5 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">3</button>
                    <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <footer class="mt-8 text-center text-sm text-gray-400 border-t border-gray-200/70 pt-6">
            &copy; 2026 <span class="font-medium text-gray-500">SIMPEG-SP</span> — Dinas Pendidikan. All rights reserved.
        </footer>
    </div>
@endsection
