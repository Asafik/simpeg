@extends('layouts.app')

@section('title', 'Manajemen User - SIMPEG-SP')

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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Manajemen User & Hak Akses (RBAC)</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Pengelolaan akun pengguna multi-role (Admin Dinas Pendidikan & Operator Sekolah).
                </p>
            </div>
            <a href="{{ route('users.create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-user-plus text-xs"></i>
                <span>Tambah Akun User</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container (With overlapping top margin) -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">
        
        <!-- Flash Messages Alert -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- SUMMARY METRIC CARDS (Exact Match to Sekolah Index UI) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Pengguna -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-users-gear text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Akun Terdaftar</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalUsers ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: Admin Dinas -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-indigo-500 flex items-center justify-center text-indigo-600 font-bold bg-indigo-50/50 flex-shrink-0">
                        <i class="fas fa-user-shield text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Admin Dinas</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalAdminDinas ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: Operator Sekolah -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-user-tie text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Operator Sekolah</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">
                            {{ number_format($totalOperatorSekolah ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

        </div>

        <!-- Filter Bar Panel (Exact Match to Sekolah Index Filter) -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4 relative z-30">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Filter &amp; Pencarian Akun User
                </h3>
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ route('users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                
                <!-- Search Input -->
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari Username / Nama / Sekolah</label>
                    <div class="relative flex items-center">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama, username, email..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-3 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                        <button type="submit" class="absolute right-1 w-7 h-7 bg-blue-800 hover:bg-blue-900 text-white rounded-md transition flex items-center justify-center shadow-sm cursor-pointer" title="Cari Data">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Filter Role / Hak Akses</label>
                    <select name="role" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Role (Admin & Operator)</option>
                        <option value="ADMIN_DINAS" {{ $role == 'ADMIN_DINAS' ? 'selected' : '' }}>Admin Dinas Pendidikan</option>
                        <option value="OPERATOR_SEKOLAH" {{ $role == 'OPERATOR_SEKOLAH' ? 'selected' : '' }}>Operator Sekolah</option>
                    </select>
                </div>

                <!-- Filter Submit Button -->
                <div class="col-span-1 sm:col-span-2 md:col-span-1 flex items-end justify-end gap-2">
                    @if($search || $role)
                        <a href="{{ route('users.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                            <i class="fas fa-rotate-left text-[10px]"></i> Reset
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card Container (Exact Match to Sekolah Index Table) -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan {{ $users->total() }} Akun Pengguna Terdaftar
                </span>
                @if($search || $role)
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full font-bold">
                            <i class="fas fa-check-circle mr-1"></i> Filter Aktif: 
                            @if($role) Role: {{ $role === 'ADMIN_DINAS' ? 'Admin Dinas' : 'Operator Sekolah' }} @endif
                            @if($search) | Kata Kunci: "{{ $search }}" @endif
                        </span>
                    </div>
                @endif
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5 text-center">No.</th>
                            <th class="px-6 py-3.5">Nama & Username</th>
                            <th class="px-6 py-3.5">Role / Peranan</th>
                            <th class="px-6 py-3.5">Satuan Pendidikan Affiliasi</th>
                            <th class="px-6 py-3.5 text-right">Aksi & Pengaturan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $u)
                            <tr class="hover:bg-gray-50/50 transition">
                                <!-- Number Column -->
                                <td class="px-4 py-4 text-center font-bold text-gray-400 text-xs">
                                    {{ $loop->iteration + ($users->firstItem() - 1) }}
                                </td>

                                <!-- User Details -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full {{ $u->role === 'ADMIN_DINAS' ? 'bg-blue-900' : 'bg-emerald-600' }} text-white font-extrabold text-xs flex items-center justify-center shadow-xs flex-shrink-0">
                                            {{ strtoupper(substr($u->name, 0, 2)) }}
                                        </div>
                                        <div class="truncate">
                                            <p class="font-extrabold text-gray-900 text-xs truncate">{{ $u->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium">
                                                Username: <span class="font-bold text-blue-950 font-mono">{{ $u->username }}</span> &bull; {{ $u->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role Badge -->
                                <td class="px-6 py-4">
                                    @if($u->role === 'ADMIN_DINAS')
                                        <span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-900 border border-blue-200 text-[11px] font-bold inline-flex items-center gap-1">
                                            <i class="fas fa-user-shield text-blue-700"></i> Admin Dinas
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-200 text-[11px] font-bold inline-flex items-center gap-1">
                                            <i class="fas fa-user-tie text-emerald-700"></i> Operator Sekolah
                                        </span>
                                    @endif
                                </td>

                                <!-- Sekolah Affiliation -->
                                <td class="px-6 py-4 text-xs font-medium text-gray-700">
                                    @if($u->role === 'ADMIN_DINAS')
                                        <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-900 border border-blue-100 text-[11px] font-bold inline-flex items-center gap-1">
                                            <i class="fas fa-building text-blue-700"></i> Dinas Pendidikan Kabupaten
                                        </span>
                                    @else
                                        @if($u->sekolah)
                                            <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 text-[11px] font-semibold inline-flex items-center gap-1">
                                                <i class="fas fa-school text-gray-500"></i> {{ $u->sekolah->nama_sekolah }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">Belum Ditautkan</span>
                                        @endif
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $u->id) }}" class="px-2.5 py-1.5 bg-gray-100 hover:bg-blue-800 hover:text-white text-gray-700 text-xs font-bold rounded-lg transition shadow-2xs" title="Edit Akun User">
                                            <i class="fas fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- Reset Password Form Button -->
                                        <form action="{{ route('users.reset-password', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mereset password akun {{ addslashes($u->name) }} menjadi default password?')">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white border border-amber-200 text-xs font-bold rounded-lg transition shadow-2xs" title="Reset Password ke default 'password'">
                                                <i class="fas fa-key"></i> Reset
                                            </button>
                                        </form>

                                        <!-- Delete Button -->
                                        @if(Auth::id() !== $u->id)
                                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($u->name) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 text-xs font-bold rounded-lg transition shadow-2xs" title="Hapus Akun User">
                                                    <i class="fas fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                    <i class="fas fa-users-slash text-2xl mb-2 text-gray-300 block"></i>
                                    Tidak ada akun pengguna yang sesuai dengan kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination (Matches Custom SIMPEG-SP UI Styling) -->
            @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 bg-gray-50/50">
                    <span class="text-xs text-gray-500 font-medium">
                        Halaman <span class="font-bold text-gray-800">{{ $users->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $users->lastPage() }}</span> (Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} Akun Pengguna)
                    </span>
                    <div class="flex items-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="px-3 py-1.5 text-xs bg-blue-800 text-white font-bold rounded-lg shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 bg-white rounded-lg transition font-medium border border-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 bg-white transition"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-300 cursor-not-allowed bg-white"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @elseif(isset($users) && method_exists($users, 'total'))
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <span class="text-xs text-gray-500 font-medium">Menampilkan {{ $users->total() }} Akun Pengguna</span>
                </div>
            @endif

        </div>

    </div>
@endsection
