<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPEG-SP - Dashboard Admin Dinas</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Plus Jakarta Sans & Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Tailwind Custom Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* ===== CUSTOM STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: #f8fafc;
        }

        /* Sidebar scroll */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Card hover effect */
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        /* Badge styles */
        .badge-custom {
            padding: 3px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.active {
                display: block;
            }
        }

        /* Chart container */
        .chart-container {
            position: relative;
            height: 240px;
            width: 100%;
        }

        /* Custom scrollbar for table */
        .table-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .table-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .table-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Notification dot pulse */
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR OVERLAY (Mobile) ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="fixed top-0 left-0 h-full w-[270px] bg-white text-gray-800 border-r border-gray-200/80 shadow-sm z-50 
                   transform -translate-x-full md:translate-x-0 transition-transform duration-300 
                   sidebar-scroll overflow-y-auto flex flex-col"
           id="sidebar">
        
        <!-- Brand -->
        <div class="px-6 py-6 border-b border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-sm shadow-blue-500/20">
                    SP
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-gray-900">SIMPEG-SP</h1>
                    <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium">Dinas Pendidikan</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mb-4">Main Menu</p>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/20 mb-1 transition">
                <i class="fas fa-chart-pie w-5 text-center"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition mb-1">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="font-medium text-sm">Data Pegawai</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition mb-1">
                <i class="fas fa-school w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Sekolah</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition mb-1">
                <i class="fas fa-check-circle w-5 text-center"></i>
                <span class="font-medium text-sm">Verifikasi Data</span>
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">12</span>
            </a>

            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold px-3 mt-8 mb-4">Laporan</p>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition mb-1">
                <i class="fas fa-file-excel w-5 text-center text-green-500"></i>
                <span class="font-medium text-sm">Export Excel</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition mb-1">
                <i class="fas fa-file-pdf w-5 text-center text-red-500"></i>
                <span class="font-medium text-sm">Export PDF</span>
            </a>
        </nav>

        <!-- User Footer -->
        <div class="px-4 py-5 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-semibold text-sm">
                    AD
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm text-gray-800">Admin Dinas</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
                <a href="#" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="md:ml-[270px] min-h-screen bg-gray-50 flex flex-col">
        
        <!-- ===== TOPBAR (Mentok Atas & Full Width) ===== -->
        <header class="bg-white border-b border-gray-200/80 px-4 md:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <!-- Mobile Toggle -->
                <button class="md:hidden text-gray-700 text-xl w-9 h-9 rounded-xl hover:bg-gray-100 flex items-center justify-center transition" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Back Arrow Icon (as seen in Hope UI design) -->
                <button class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition shadow-sm shadow-blue-500/20 text-xs">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <!-- Search Box -->
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Search..." class="bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-xl pl-9 pr-4 py-2 w-40 sm:w-60 md:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                </div>
            </div>

            <!-- Right Controls & User Profile -->
            <div class="flex items-center gap-3">
                <!-- Action Badge (Go Pro) -->
                <a href="#" class="hidden sm:flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3.5 py-2 rounded-xl shadow-sm shadow-blue-500/30 transition">
                    <i class="fas fa-paper-plane text-[10px]"></i>
                    <span>Go Pro</span>
                </a>
                
                <!-- Country Flag Icon (Indonesia 🇮🇩) -->
                <div class="w-7 h-7 rounded-full overflow-hidden border border-gray-200 flex items-center justify-center shadow-xs cursor-pointer" title="Indonesia">
                    <span class="text-base leading-none">🇮🇩</span>
                </div>

                <!-- Notification Bell -->
                <button class="relative w-9 h-9 rounded-xl bg-gray-50 border border-gray-200/80 hover:bg-gray-100 transition flex items-center justify-center text-gray-600">
                    <i class="far fa-bell text-sm"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Envelope / Messages -->
                <button class="w-9 h-9 rounded-xl bg-gray-50 border border-gray-200/80 hover:bg-gray-100 transition flex items-center justify-center text-gray-600">
                    <i class="far fa-envelope text-sm"></i>
                </button>

                <!-- User Profile Badge -->
                <div class="flex items-center gap-2.5 pl-2 border-l border-gray-200">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                        AD
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-xs font-bold text-gray-800 leading-tight">Admin Dinas</p>
                        <p class="text-[10px] text-gray-400">Marketing Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- ===== HERO BLUE WELCOME BANNER (Exact Hope UI 2-Wave Design) ===== -->
        <div class="relative bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-800 text-white px-6 md:px-10 pt-8 md:pt-10 pb-20 md:pb-24 shadow-lg shadow-blue-600/10 overflow-hidden">
            <!-- Exact Hope UI 2 Diagonal Wave Shapes Overlay -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 300">
                <!-- Wave Shape 1 (Diagonal curve pointing to top-right - Left Arrow) -->
                <path d="M 200,300 C 360,160 520,30 750,0 L 1000,0 L 1000,300 Z" fill="url(#hopeWaveGrad1)"></path>
                
                <!-- Wave Shape 2 (Diagonal dark curve pointing down-right - Right Arrow) -->
                <path d="M 450,300 C 600,150 780,70 1000,15 L 1000,300 Z" fill="url(#hopeWaveGrad2)"></path>
                
                <defs>
                    <linearGradient id="hopeWaveGrad1" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#1e40af" stop-opacity="0.55" />
                        <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.35" />
                    </linearGradient>
                    <linearGradient id="hopeWaveGrad2" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#0b1736" stop-opacity="0.75" />
                        <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.45" />
                    </linearGradient>
                </defs>
            </svg>
            
            <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
                <div class="max-w-2xl">
                    <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Hello Devs! / Admin Dinas 👋</h2>
                    <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                        Selamat datang di Dashboard SIMPEG-SP. Pantau pergerakan data pegawai, status verifikasi berkas, dan laporan seluruh satuan pendidikan secara real-time.
                    </p>
                </div>
                <div>
                    <button class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 px-4 py-2.5 rounded-xl text-xs font-semibold text-white flex items-center gap-2 transition">
                        <i class="fas fa-bullhorn text-xs"></i>
                        <span>Announcements</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== MAIN CONTENT BODY (With padding & overlapping stat cards) ===== -->
        <div class="px-4 md:px-8 pb-8 flex-1">
            <!-- ===== OVERLAPPING SUMMARY CARDS ===== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 -mt-12 md:-mt-14 mb-6 relative z-20">
            <!-- Card 1: Total Pegawai -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-600 flex items-center justify-center text-blue-600 font-bold bg-blue-50/50 flex-shrink-0">
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
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
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
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-600 flex items-center justify-center text-blue-600 font-bold bg-blue-50/50 flex-shrink-0">
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
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
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
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
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
            <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <h3 class="text-base font-semibold text-gray-700">Recent Movement</h3>
                    <div class="flex items-center gap-2">
                        <!-- Dropdown Selector -->
                        <div class="relative">
                            <select id="movementMonthSelect" class="appearance-none bg-gray-50 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg px-3 py-1.5 pr-7 focus:outline-none focus:ring-2 focus:ring-blue-500/20 cursor-pointer">
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
                            <input type="text" placeholder="Search.." class="bg-gray-50 border border-gray-200 text-gray-600 text-xs rounded-lg px-3 py-1.5 w-28 md:w-36 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        </div>
                    </div>
                </div>
                <div class="chart-container" style="height: 240px;">
                    <canvas id="recentMovementChart"></canvas>
                </div>
            </div>

            <!-- Calendar Widget (1 Col) -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <!-- Calendar Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
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
                        <div class="flex items-center gap-2.5 p-2 rounded-xl bg-blue-50/60 border border-blue-100/50">
                            <div class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800 truncate">Verifikasi Berkas PPPK</p>
                                <p class="text-[10px] text-gray-500">Hari ini, 25 Juli • 12 Berkas</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 p-2 rounded-xl bg-amber-50/60 border border-amber-100/50">
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
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-semibold text-gray-900">
                        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                        Distribusi Status Kepegawaian
                    </h3>
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        Detail
                    </a>
                </div>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Sebaran Usia -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-semibold text-gray-900">
                        <i class="fas fa-users text-purple-600 mr-2"></i>
                        Sebaran Kelompok Usia
                    </h3>
                    <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-1.5 rounded-full hover:bg-gray-50 transition">
                        Detail
                    </a>
                </div>
                <div class="chart-container">
                    <canvas id="usiaChart"></canvas>
                </div>
            </div>
        </div>

        <!-- ===== TABLE SECTION ===== -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
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
                    <button class="px-3.5 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">1</button>
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
    </main>

    <!-- ===== CHART.JS SCRIPTS ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // === CHART 1: Status Kepegawaian (Doughnut) ===
            const ctx1 = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: ['PNS', 'PPPK', 'PPPK PW', 'Non-ASN'],
                    datasets: [{
                        data: [547, 386, 94, 257],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ec4899'],
                        borderWidth: 0,
                        borderRadius: 6,
                        spacing: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                padding: 14,
                                font: { size: 11, weight: '500' },
                                color: '#1e293b'
                            }
                        }
                    }
                }
            });

            // === CHART 2: Sebaran Usia (Bar) ===
            const ctx2 = document.getElementById('usiaChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['< 30 thn', '31-40 thn', '41-50 thn', '> 55 thn'],
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: [186, 428, 512, 158],
                        backgroundColor: ['#a78bfa', '#7c3aed', '#5b21b6', '#4c1d95'],
                        borderRadius: 6,
                        barPercentage: 0.65,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: { font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });

            // === CHART 3: Recent Movement (Spline Area) ===
            const ctxMovement = document.getElementById('recentMovementChart').getContext('2d');
            const gradientFill = ctxMovement.createLinearGradient(0, 0, 0, 220);
            gradientFill.addColorStop(0, 'rgba(59, 130, 246, 0.22)');
            gradientFill.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

            new Chart(ctxMovement, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Movement',
                        data: [2100, 1550, 1600, 1900, 1580, 1920, 2580, 2450, 2800, 3450, 2900, 3350],
                        borderColor: '#3b82f6',
                        borderWidth: 2.5,
                        backgroundColor: gradientFill,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Movement: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 1000,
                            max: 4000,
                            ticks: {
                                stepSize: 1000,
                                font: { size: 11, family: 'Inter' },
                                color: '#94a3b8'
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, family: 'Inter' },
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });

            // === CALENDAR WIDGET LOGIC ===
            const calendarMonthYear = document.getElementById('calendarMonthYear');
            const calendarDaysGrid = document.getElementById('calendarDaysGrid');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');

            let currentDate = new Date(2026, 6, 25); // July 25, 2026

            const fullMonthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            function renderCalendar() {
                if (!calendarMonthYear || !calendarDaysGrid) return;
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                calendarMonthYear.textContent = `${fullMonthNames[month]} ${year}`;
                calendarDaysGrid.innerHTML = '';

                const firstDayIndex = new Date(year, month, 1).getDay();
                const lastDate = new Date(year, month + 1, 0).getDate();
                const prevLastDate = new Date(year, month, 0).getDate();

                // Previous month padding days
                for (let x = firstDayIndex; x > 0; x--) {
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'py-1 text-gray-300 text-[11px]';
                    dayDiv.textContent = prevLastDate - x + 1;
                    calendarDaysGrid.appendChild(dayDiv);
                }

                // Current month days
                for (let i = 1; i <= lastDate; i++) {
                    const dayDiv = document.createElement('div');
                    const isToday = (i === 25 && month === 6 && year === 2026);
                    const hasEvent = (i === 25 || i === 28);

                    if (isToday) {
                        dayDiv.className = 'py-1 font-bold text-white bg-blue-600 rounded-lg shadow-sm shadow-blue-500/30 cursor-pointer flex flex-col items-center justify-center relative';
                    } else if (hasEvent) {
                        dayDiv.className = 'py-1 font-semibold text-blue-600 bg-blue-50/80 rounded-lg cursor-pointer flex flex-col items-center justify-center hover:bg-blue-100 transition';
                    } else {
                        dayDiv.className = 'py-1 hover:bg-gray-100 rounded-lg cursor-pointer transition';
                    }

                    dayDiv.textContent = i;
                    calendarDaysGrid.appendChild(dayDiv);
                }
            }

            renderCalendar();

            if (prevMonthBtn && nextMonthBtn) {
                prevMonthBtn.addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    renderCalendar();
                });

                nextMonthBtn.addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    renderCalendar();
                });
            }

        });

        // ===== MOBILE SIDEBAR TOGGLE =====
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }

        mobileToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Close sidebar on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('md:translate-x-0');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.remove('md:translate-x-0');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>

</body>
</html>