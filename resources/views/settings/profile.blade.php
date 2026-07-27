@extends('layouts.app')

@section('title', 'Profil Saya & Keamanan Akun - SIMPEG-SP')

@section('content')
    @php
        $user = Auth::user();
        $words = explode(' ', $user->name ?? 'User');
        $initials = strtoupper(substr($words[0] ?? 'U', 0, 1) . substr($words[1] ?? 'S', 0, 1));
    @endphp

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Profil Saya &amp; Keamanan Akun</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Kelola informasi profil diri, email resmi, serta ubah kata sandi (password) akun Anda.
                </p>
            </div>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20 space-y-6">
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-md flex items-center justify-between">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-md space-y-1">
                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-triangle-exclamation text-rose-600"></i> Terdapat kesalahan pengisian form:</p>
                <ul class="list-disc list-inside pl-2 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- PROFILE OVERVIEW & EDIT FORM -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-user-circle"></i> Data Diri &amp; Identitas Akun
                </h3>
            </div>

            <div class="flex flex-wrap items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-blue-900 text-white text-2xl font-extrabold flex items-center justify-center shadow-lg shadow-blue-900/30">
                    {{ $initials }}
                </div>
                <div>
                    <h4 class="font-extrabold text-gray-900 text-base">{{ $user->name }}</h4>
                    <p class="text-xs text-gray-400 font-medium">Username: <span class="font-bold text-gray-800 font-mono">{{ $user->username }}</span> • Email: {{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-1.5">
                        @if(method_exists($user, 'isAdminDinas') && $user->isAdminDinas())
                            <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 font-bold text-[10px] rounded-full border border-blue-200">
                                <i class="fas fa-user-shield text-[9px] mr-1"></i> ADMIN DINAS
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold text-[10px] rounded-full border border-emerald-200">
                                <i class="fas fa-school text-[9px] mr-1"></i> OPERATOR SEKOLAH
                            </span>
                            @if(isset($user->sekolah))
                                <span class="text-xs text-gray-600 font-semibold flex items-center gap-1">
                                    <i class="fas fa-school text-gray-400"></i> {{ $user->sekolah->nama_sekolah }} (NPSN: {{ $user->sekolah->npsn }})
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- UPDATE PROFILE FORM -->
            <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4 pt-2">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap Pengguna <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Username Login (Tetap)</label>
                        <input type="text" value="{{ $user->username }}" readonly 
                               class="w-full bg-gray-100 border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 font-medium font-mono cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Peran / Role Pengguna</label>
                        <input type="text" value="{{ $user->role === 'ADMIN_DINAS' ? 'Admin Dinas Pendidikan' : 'Operator Satuan Pendidikan' }}" readonly 
                               class="w-full bg-gray-100 border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 font-medium cursor-not-allowed">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2 bg-blue-800 hover:bg-blue-900 text-white font-bold text-xs rounded-lg shadow-md transition flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-save"></i>
                        <span>Simpan Profil</span>
                    </button>
                </div>
            </form>

            <!-- UBAH PASSWORD FORM -->
            <div class="border-t border-gray-100 pt-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-key"></i> Ubah Kata Sandi (Password)
                    </h4>
                    <span class="text-[11px] text-gray-400">Gunakan kombinasi minimal 6 karakter.</span>
                </div>

                <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Password Saat Ini <span class="text-rose-500">*</span></label>
                            <input type="password" name="current_password" required placeholder="••••••••" 
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Password Baru <span class="text-rose-500">*</span></label>
                            <input type="password" name="new_password" required placeholder="••••••••" 
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                            <input type="password" name="new_password_confirmation" required placeholder="••••••••" 
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-lg shadow-md transition flex items-center gap-2 cursor-pointer">
                            <i class="fas fa-lock text-xs"></i>
                            <span>Ganti Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
