@extends('layouts.app')

@section('title', 'Sign In - SIMPEG-SP Dinas Pendidikan')

@section('hideNav', true)

@section('content')
    <!-- Split Screen 50/50 Grid Container -->
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <!-- LEFT SIDE: LOGIN FORM (Hope UI Style) -->
        <div class="flex flex-col justify-between px-8 sm:px-12 md:px-20 py-10 bg-white z-10">
            
            <!-- Brand Logo Header -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain">
                <div>
                    <h1 class="font-extrabold text-lg leading-tight text-gray-900 tracking-tight">SIMPEG-SP</h1>
                    <p class="text-[10px] uppercase tracking-widest text-blue-800 font-extrabold">Dinas Pendidikan</p>
                </div>
            </div>

            <!-- Main Sign In Form Area -->
            <div class="my-auto py-8 max-w-md w-full mx-auto">
                <div class="mb-8 text-center sm:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Sign In</h2>
                    <p class="text-xs text-gray-500 mt-1.5 font-medium leading-relaxed">Login untuk masuk ke Sistem Informasi Manajemen Pegawai Satuan Pendidikan.</p>
                </div>

                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 font-medium">
                        <i class="fas fa-exclamation-circle mr-1.5 text-red-500"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-700 font-medium">
                        <i class="fas fa-info-circle mr-1.5 text-blue-600"></i>
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Username / NIP Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Username / NIP
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="login" placeholder="Masukkan NIP atau Username" value="{{ old('login') }}" required
                                class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800/20 focus:border-blue-800 transition font-medium">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kata Sandi (Password)
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800/20 focus:border-blue-800 transition font-medium">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-xs text-gray-600 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer font-medium">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-800 focus:ring-blue-800">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="#" class="text-blue-800 font-bold hover:underline">Lupa Password?</a>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit" class="w-full py-3 bg-blue-800 hover:bg-blue-900 text-white font-bold rounded-lg shadow-md shadow-blue-900/30 transition flex items-center justify-center gap-2 text-xs mt-3 tracking-wide">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </form>

                <p class="text-xs text-gray-400 text-center mt-6 font-medium">
                    Belum punya akun? <a href="#" class="text-blue-800 font-bold hover:underline">Hubungi Admin Dinas</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="text-xs text-gray-400 text-center sm:text-left font-medium">
                &copy; 2026 <span class="font-bold text-gray-600">SIMPEG-SP</span> — Dinas Pendidikan. All rights reserved.
            </div>
        </div>

        <!-- RIGHT SIDE: LOCAL BUILDING PHOTO WITH BLUE OVERLAY -->
        <div class="hidden lg:block relative overflow-hidden bg-blue-950">
            <!-- Local Building Photo -->
            <img src="{{ asset('images/dinas_pendidikan.jpg') }}" 
                 alt="Gedung Dinas Pendidikan" 
                 class="w-full h-full object-cover object-center">

            <!-- Deep Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-950/95 via-blue-900/75 to-blue-800/40 backdrop-blur-[2px]"></div>

            <!-- Hero Text Content Overlay -->
            <div class="absolute inset-0 flex flex-col justify-end p-16 text-white z-10 max-w-xl">
                <div class="w-12 h-1 bg-blue-400 mb-6 rounded-full"></div>
                <h3 class="text-3xl font-extrabold leading-tight tracking-tight mb-3">
                    Pemusatan Data Kepegawaian Satuan Pendidikan Terpadu
                </h3>
                <p class="text-xs text-blue-100/90 leading-relaxed font-normal">
                    Memetakan kualifikasi, status kepegawaian (PNS, PPPK, PPPK PW, Non-ASN), dan sertifikasi pendidik secara real-time di seluruh sekolah lingkungan Dinas Pendidikan.
                </p>

                <!-- Stats Badges Footer -->
                <div class="flex items-center gap-6 mt-8 pt-6 border-t border-white/15 text-xs font-bold">
                    <div>
                        <p class="text-xl font-extrabold">1.284+</p>
                        <p class="text-[10px] text-blue-200 uppercase font-medium">Total PTK Terdata</p>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div>
                        <p class="text-xl font-extrabold">48</p>
                        <p class="text-[10px] text-blue-200 uppercase font-medium">Satuan Pendidikan</p>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div>
                        <p class="text-xl font-extrabold">100%</p>
                        <p class="text-[10px] text-blue-200 uppercase font-medium">Real-time Data</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
