@extends('layouts.app')

@section('title', 'Kelola Pengumuman Publik - SIMPEG-SP')

@section('content')
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
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Kelola Pengumuman Publik</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Pengelolaan pengumuman, edaran dinas, dan berita resmi untuk Operator Sekolah serta Pegawai Dinas Pendidikan.
                </p>
            </div>
            <a href="{{ route('pengumuman.create') }}" class="bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition cursor-pointer">
                <i class="fas fa-plus text-xs"></i>
                <span>Tambah Pengumuman Baru</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6">

        <!-- Flash Messages Alert -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-sm relative z-30">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fas fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 cursor-pointer"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        <!-- SUMMARY METRIC CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 -mt-12 md:-mt-14 mb-6 relative z-10">
            
            <!-- Card 1: Total Pengumuman -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-blue-800 flex items-center justify-center text-blue-800 font-bold bg-blue-900/10 flex-shrink-0">
                        <i class="fas fa-bullhorn text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Pengumuman</p>
                        <p class="text-xl md:text-2xl font-extrabold text-gray-900 mt-0.5">{{ $totalAnnouncements }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 2: Dipublikasikan -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50/50 flex-shrink-0">
                        <i class="fas fa-circle-check text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Aktif / Dipublikasikan</p>
                        <p class="text-xl md:text-2xl font-extrabold text-emerald-600 mt-0.5">{{ \App\Models\Announcement::where('is_published', true)->count() }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

            <!-- Card 3: Draft -->
            <div class="stat-card bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-gray-200/50 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-amber-500 flex items-center justify-center text-amber-600 font-bold bg-amber-50/50 flex-shrink-0">
                        <i class="fas fa-file-pen text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Draft / Disimpan</p>
                        <p class="text-xl md:text-2xl font-extrabold text-amber-600 mt-0.5">{{ \App\Models\Announcement::where('is_published', false)->count() }}</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            </div>

        </div>

        <!-- Filter Bar Panel -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4 relative z-30">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Filter &amp; Pencarian Pengumuman
                </h3>
            </div>

            <form action="{{ route('pengumuman.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                <!-- Search Keyword -->
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Cari Judul / Topik Pengumuman</label>
                    <div class="relative flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pengumuman..." 
                               class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg pl-3 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium">
                        <button type="submit" class="absolute right-1 w-7 h-7 bg-blue-800 hover:bg-blue-900 text-white rounded-md transition flex items-center justify-center shadow-sm cursor-pointer">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Kategori Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Kategori Pengumuman</label>
                    <select name="kategori" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer font-medium">
                        <option value="">Semua Kategori</option>
                        <option value="Penting" {{ request('kategori') == 'Penting' ? 'selected' : '' }}>Penting</option>
                        <option value="Verifikasi" {{ request('kategori') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="Surat Edaran" {{ request('kategori') == 'Surat Edaran' ? 'selected' : '' }}>Surat Edaran</option>
                        <option value="Informasi Umum" {{ request('kategori') == 'Informasi Umum' ? 'selected' : '' }}>Informasi Umum</option>
                    </select>
                </div>

                <!-- Submit & Reset -->
                <div class="flex items-end justify-end gap-2">
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('pengumuman.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
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

        <!-- Table Card Container -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-xl shadow-gray-200/50 overflow-hidden relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-bold">
                    Menampilkan <span class="font-bold text-gray-800">{{ $announcements->total() }}</span> Pengumuman Publik
                </span>
                <span class="text-xs text-blue-800 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full font-bold">
                    <i class="fas fa-bullhorn mr-1"></i> Informasi Resmi Dinas Pendidikan
                </span>
            </div>

            <div class="table-scroll overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5 text-center">No.</th>
                            <th class="px-6 py-3.5">Judul Pengumuman &amp; Ringkasan</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Tanggal Terbit</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi &amp; Kelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @if(count($announcements) > 0)
                            @foreach($announcements as $index => $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-4 text-center font-bold text-gray-400">
                                        {{ $announcements->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-extrabold text-gray-900 text-xs flex items-center gap-2">
                                                <i class="fas fa-bullhorn text-blue-800"></i>
                                                {{ $item->judul }}
                                            </p>
                                            <p class="text-[11px] text-gray-500 mt-1 line-clamp-2">
                                                {{ $item->ringkasan ?: Str::limit(strip_tags($item->isi), 120) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border {{ $item->kategori_badge_class }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-600 whitespace-nowrap">
                                        {{ $item->created_at ? $item->created_at->format('d M Y • H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->is_published)
                                            <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-200 text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fas fa-circle-check text-emerald-700"></i> Dipublikasikan
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-200 text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fas fa-file-pen text-amber-700"></i> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('pengumuman.edit', $item->id) }}" class="px-2.5 py-1.5 bg-gray-100 hover:bg-blue-800 hover:text-white text-gray-700 font-bold rounded-lg transition shadow-2xs" title="Edit Pengumuman">
                                                <i class="fas fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 font-bold rounded-lg transition shadow-2xs cursor-pointer" title="Hapus Pengumuman">
                                                    <i class="fas fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-bullhorn text-3xl text-gray-300"></i>
                                        <p class="font-bold text-gray-600">Belum ada pengumuman publik yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            @if(method_exists($announcements, 'hasPages') && $announcements->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col lg:flex-row items-center justify-between gap-3 bg-gray-50/50">
                    <span class="text-xs text-gray-500 font-medium">
                        Halaman <span class="font-bold text-gray-800">{{ $announcements->currentPage() }}</span> dari <span class="font-bold text-gray-800">{{ $announcements->lastPage() }}</span>
                    </span>
                    <div>
                        {{ $announcements->links() }}
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
