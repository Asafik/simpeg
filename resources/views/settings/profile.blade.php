@extends('layouts.app')

@section('title', 'Profil Pengguna - SIMPEG-SP')

@section('content')
    <!-- Include Sidebar Per-Page -->
    @include('layouts.sidebar')

    <!-- ===== HERO BLUE BANNER ===== -->
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Profil Pengguna & Keamanan Akun</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola informasi data diri, email, kontak, serta ganti kata sandi akun Anda.
                </p>
            </div>
            <button class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-save text-xs"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-user-circle"></i> Data Diri & Identitas Akun
                </h3>
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
@endsection
