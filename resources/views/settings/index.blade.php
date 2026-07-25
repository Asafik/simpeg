@extends('layouts.app')

@section('title', 'Setting & Konfigurasi - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Setting System & Pengaturan</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola profil pengguna, konfigurasi nama aplikasi/logo/favicon/tema warna, serta pantau log aktivitas sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        <!-- SUBMENU TAB NAVIGATION BUTTONS -->
        <div class="bg-white rounded-xl p-2 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-wrap items-center gap-1.5 text-xs font-bold">
            <button type="button" id="tabBtnProfile" onclick="switchSettingTab('profile')" class="tab-setting-btn px-5 py-2.5 rounded-lg bg-blue-800 text-white shadow-sm transition flex items-center gap-2">
                <i class="fas fa-user text-xs"></i>
                <span>1. Profil Pengguna</span>
            </button>

            <button type="button" id="tabBtnSystem" onclick="switchSettingTab('system')" class="tab-setting-btn px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition flex items-center gap-2">
                <i class="fas fa-sliders text-xs"></i>
                <span>2. Pengaturan Sistem (Logo & Tema)</span>
            </button>

            <button type="button" id="tabBtnActivity" onclick="switchSettingTab('activity')" class="tab-setting-btn px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-xs"></i>
                <span>3. Log Aktivitas</span>
            </button>
        </div>

        <!-- ================= TAB 1: PROFIL PENGGUNA ================= -->
        <div id="tabContentProfile" class="tab-setting-content space-y-6">
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-user-circle"></i> Informasi Profil & Pengaturan Akun
                    </h3>
                    <button class="bg-blue-800 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm hover:bg-blue-900 transition flex items-center gap-1.5">
                        <i class="fas fa-save"></i> Simpan Profil
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl bg-blue-800 text-white text-3xl font-extrabold flex items-center justify-center shadow-lg shadow-blue-900/30">
                        AD
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-base">Administrator Dinas Pendidikan</h4>
                        <p class="text-xs text-gray-400">admin@dinas.go.id • NIP: 198501152010011002</p>
                        <span class="inline-block mt-2 px-2.5 py-1 bg-blue-100 text-blue-800 font-bold text-[10px] rounded-full">ADMIN DINAS</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="Administrator Dinas Pendidikan" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Username Login</label>
                        <input type="text" value="admin" readonly class="w-full bg-gray-100 border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 font-medium cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" value="admin@dinas.go.id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" value="081234567890" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="border-t border-gray-100 pt-5 space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700">Ubah Kata Sandi (Password)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Password Lama</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Password Baru</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 2: PENGATURAN SISTEM (LOGO, FAVICON, TEMA) ================= -->
        <div id="tabContentSystem" class="tab-setting-content hidden space-y-6">
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-palette"></i> Pengaturan Aplikasi, Identity, Logo & Tema Warna
                    </h3>
                    <button class="bg-blue-800 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm hover:bg-blue-900 transition flex items-center gap-1.5">
                        <i class="fas fa-save"></i> Simpan Pengaturan Sistem
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Aplikasi System</label>
                        <input type="text" value="SIMPEG-SP" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Deskripsi / Instansi Subtitle</label>
                        <input type="text" value="Sistem Informasi Manajemen Pegawai Satuan Pendidikan" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                </div>

                <!-- UPLOAD LOGO & FAVICON -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    
                    <!-- Upload Logo -->
                    <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-gray-800">Logo Aplikasi (SVG / PNG)</h4>
                            <span class="text-[10px] text-gray-400">Rekomendasi 512x512px</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-3 rounded-lg border border-gray-200">
                            <img src="{{ asset('logo/logo.svg') }}" alt="Logo App" class="w-12 h-12 object-contain">
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-800">logo.svg</p>
                                <p class="text-[10px] text-gray-400">public/logo/logo.svg</p>
                            </div>
                            <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                                Ganti Logo
                                <input type="file" class="hidden" accept=".svg,.png">
                            </label>
                        </div>
                    </div>

                    <!-- Upload Favicon -->
                    <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-gray-800">Favicon Browser Icon (.ico / .svg)</h4>
                            <span class="text-[10px] text-gray-400">Rekomendasi 32x32px</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-3 rounded-lg border border-gray-200">
                            <img src="{{ asset('logo/logo.svg') }}" alt="Favicon" class="w-8 h-8 object-contain">
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-800">favicon.ico</p>
                                <p class="text-[10px] text-gray-400">public/favicon.ico</p>
                            </div>
                            <label class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition">
                                Ganti Favicon
                                <input type="file" class="hidden" accept=".ico,.svg,.png">
                            </label>
                        </div>
                    </div>

                </div>

                <!-- PILIHAN TEMA WARNA SYSTEM -->
                <div class="border-t border-gray-100 pt-5 space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700">Pilihan Tema Warna Utama System (Theme Palette)</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        
                        <!-- Theme 1: Hope Deep Blue (Default) -->
                        <label class="border-2 border-blue-800 rounded-xl p-4 cursor-pointer bg-blue-50/30 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950"></div>
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Hope Deep Blue (Default)</p>
                                    <p class="text-[10px] text-gray-400">Biru Navy Resmi Dinas</p>
                                </div>
                            </div>
                            <input type="radio" name="system_theme" value="deep_blue" checked class="text-blue-800 focus:ring-blue-800 w-4 h-4">
                        </label>

                        <!-- Theme 2: Emerald Education -->
                        <label class="border border-gray-200 hover:border-emerald-600 rounded-xl p-4 cursor-pointer bg-gray-50/50 flex items-center justify-between transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-900 to-teal-800"></div>
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Emerald Education</p>
                                    <p class="text-[10px] text-gray-400">Hijau Zamrud Edukasi</p>
                                </div>
                            </div>
                            <input type="radio" name="system_theme" value="emerald" class="text-emerald-600 focus:ring-emerald-600 w-4 h-4">
                        </label>

                        <!-- Theme 3: Royal Purple -->
                        <label class="border border-gray-200 hover:border-purple-600 rounded-xl p-4 cursor-pointer bg-gray-50/50 flex items-center justify-between transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-950 to-indigo-900"></div>
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Royal Purple</p>
                                    <p class="text-[10px] text-gray-400">Ungu Modern Premium</p>
                                </div>
                            </div>
                            <input type="radio" name="system_theme" value="purple" class="text-purple-600 focus:ring-purple-600 w-4 h-4">
                        </label>

                    </div>
                </div>

            </div>
        </div>

        <!-- ================= TAB 3: LOG AKTIVITAS (ACTIVITY LOG) ================= -->
        <div id="tabContentActivity" class="tab-setting-content hidden space-y-6">
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                            <i class="fas fa-list-numeric"></i> Log Aktivitas Pengguna System (Audit Trail)
                        </h3>
                        <p class="text-[10px] text-gray-400 mt-0.5">Catatan riwayat login, perubahan data pegawai, serta aktivitas pengguna secara real-time.</p>
                    </div>
                    <button class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                        <i class="fas fa-rotate-right"></i> Refresh Log
                    </button>
                </div>

                <div class="table-scroll overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                            <tr>
                                <th class="px-6 py-3.5">Waktu / Tanggal</th>
                                <th class="px-6 py-3.5">Pengguna (User)</th>
                                <th class="px-6 py-3.5">Role</th>
                                <th class="px-6 py-3.5">Aktivitas / Modul</th>
                                <th class="px-6 py-3.5">IP Address</th>
                                <th class="px-6 py-3.5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 19:48:22</td>
                                <td class="px-6 py-3.5 font-bold text-gray-900">admin</td>
                                <td class="px-6 py-3.5"><span class="badge-custom bg-blue-100 text-blue-800">Admin Dinas</span></td>
                                <td class="px-6 py-3.5 text-gray-700">Login ke dalam sistem SIMPEG-SP</td>
                                <td class="px-6 py-3.5 font-mono text-gray-500">127.0.0.1</td>
                                <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 19:35:10</td>
                                <td class="px-6 py-3.5 font-bold text-gray-900">operator_sd1</td>
                                <td class="px-6 py-3.5"><span class="badge-custom bg-emerald-100 text-emerald-800">Operator Sekolah</span></td>
                                <td class="px-6 py-3.5 text-gray-700">Mengunggah SK Kepegawaian (NIP: 198705152010012034)</td>
                                <td class="px-6 py-3.5 font-mono text-gray-500">192.168.1.104</td>
                                <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-3.5 font-semibold text-gray-700">25 Jul 2026 • 18:20:45</td>
                                <td class="px-6 py-3.5 font-bold text-gray-900">admin</td>
                                <td class="px-6 py-3.5"><span class="badge-custom bg-blue-100 text-blue-800">Admin Dinas</span></td>
                                <td class="px-6 py-3.5 text-gray-700">Menyetujui Verifikasi Berkas (Dr. Ahmad Fauzi, M.Pd.)</td>
                                <td class="px-6 py-3.5 font-mono text-gray-500">127.0.0.1</td>
                                <td class="px-6 py-3.5 text-right"><span class="badge-custom bg-emerald-100 text-emerald-800">Sukses</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Tab Switching Script -->
    <script>
        function switchSettingTab(tabName) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-setting-content');
            contents.forEach(el => el.classList.add('hidden'));

            // Deactivate all tab buttons
            const buttons = document.querySelectorAll('.tab-setting-btn');
            buttons.forEach(btn => {
                btn.className = 'tab-setting-btn px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition flex items-center gap-2';
            });

            // Activate target tab
            if (tabName === 'profile') {
                document.getElementById('tabContentProfile').classList.remove('hidden');
                document.getElementById('tabBtnProfile').className = 'tab-setting-btn px-5 py-2.5 rounded-lg bg-blue-800 text-white shadow-sm transition flex items-center gap-2';
            } else if (tabName === 'system') {
                document.getElementById('tabContentSystem').classList.remove('hidden');
                document.getElementById('tabBtnSystem').className = 'tab-setting-btn px-5 py-2.5 rounded-lg bg-blue-800 text-white shadow-sm transition flex items-center gap-2';
            } else if (tabName === 'activity') {
                document.getElementById('tabContentActivity').classList.remove('hidden');
                document.getElementById('tabBtnActivity').className = 'tab-setting-btn px-5 py-2.5 rounded-lg bg-blue-800 text-white shadow-sm transition flex items-center gap-2';
            }
        }

        // Auto switch tab from URL query param if present (?tab=system or ?tab=activity)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam) {
                switchSettingTab(tabParam);
            }
        });
    </script>
@endsection
