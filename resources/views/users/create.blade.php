@extends('layouts.app')

@php
    $isEdit = isset($user) && $user->id;
    $title = $isEdit ? 'Edit Akun Pengguna - SIMPEG-SP' : 'Tambah Akun Pengguna Baru - SIMPEG-SP';
    $formUrl = $isEdit ? route('users.update', $user->id) : route('users.store');
@endphp

@section('title', $title)

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
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('users.index') }}" class="hover:underline">Manajemen User</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>{{ $isEdit ? 'Edit Akun' : 'Tambah Akun Baru' }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">
                    {{ $isEdit ? 'Edit Akun & Hak Akses Pengguna' : 'Form Tambah Akun Pengguna Baru' }}
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    {{ $isEdit ? 'Perbarui informasi profil, hak akses role, serta penetapan sekolah untuk ' . $user->name : 'Lengkapi informasi identitas akun, tentukan role hak akses, dan tautkan dengan Satuan Pendidikan.' }}
                </p>
            </div>
            
            <!-- Kembali Button -->
            <a href="{{ route('users.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Daftar User</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20">
        
        @if (isset($errors) && method_exists($errors, 'any') && $errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 space-y-1 shadow-md">
                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-triangle-exclamation"></i> Terdapat kesalahan pengisian form:</p>
                <ul class="list-disc list-inside pl-2 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formUrl }}" method="POST" class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- MAIN FORM CARD -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-6">
                
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-user-gear"></i> Informasi Akun & Role Pengguna
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap Pengguna <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Contoh: Muhammad Irfan, S.Kom." required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Username (ID Login) <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" placeholder="Contoh: ops_balunglor01" required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-mono">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Contoh: operator.sdnbalunglor01@gmail.com" required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Role Pengguna -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Role / Hak Akses Pengguna <span class="text-red-500">*</span></label>
                        @php
                            $currentRole = old('role', $user->role ?? 'OPERATOR_SEKOLAH');
                        @endphp
                        <select name="role" id="roleSelect" onchange="toggleSekolahField()" required
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none cursor-pointer">
                            <option value="OPERATOR_SEKOLAH" {{ $currentRole === 'OPERATOR_SEKOLAH' ? 'selected' : '' }}>Operator Sekolah (Satuan Pendidikan)</option>
                            <option value="ADMIN_DINAS" {{ $currentRole === 'ADMIN_DINAS' ? 'selected' : '' }}>Admin Dinas Pendidikan (Full Access)</option>
                        </select>
                    </div>

                </div>

                <!-- Satuan Pendidikan Field (Shown for Operator Sekolah) -->
                <div id="sekolahFieldWrapper" class="{{ $currentRole === 'ADMIN_DINAS' ? 'hidden' : '' }} border-t border-gray-100 pt-5">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Satuan Pendidikan / Sekolah Afiliasi <span class="text-red-500">*</span></label>
                    <div class="relative max-w-2xl" id="customSekolahSelect">
                        <input type="hidden" name="sekolah_id" id="sekolahIdInput" value="{{ old('sekolah_id', $user->sekolah_id ?? '') }}">
                        
                        <!-- Trigger Button -->
                        <button type="button" id="sekolahSelectBtn" onclick="toggleSekolahDropdown()"
                            class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-800/20 focus:outline-none transition hover:border-gray-300">
                            <span id="sekolahSelectLabel" class="truncate font-medium text-gray-700">
                                -- Pilih Satuan Pendidikan --
                            </span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 ml-2 flex-shrink-0"></i>
                        </button>

                        <!-- Dropdown Panel -->
                        <div id="sekolahDropdownPanel" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-2xl z-50 overflow-hidden animate-fadeIn">
                            <!-- Search Input Header -->
                            <div class="p-2 border-b border-gray-100 bg-gray-50/80">
                                <div class="relative">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="text" id="sekolahSearchInput" oninput="filterSekolahOptions()" placeholder="Ketik nama sekolah..."
                                        class="w-full bg-white border border-gray-200 rounded-lg pl-8 pr-8 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10">
                                    <button type="button" id="clearSekolahSearchBtn" onclick="clearSekolahSearch()" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                                        <i class="fas fa-xmark"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Options Scrollable Container -->
                            <div class="max-h-60 overflow-y-auto divide-y divide-gray-50 p-1" id="sekolahOptionsList">
                                <div class="sekolah-option-item px-3 py-2.5 text-xs hover:bg-blue-900 hover:text-white rounded-lg cursor-pointer transition flex items-center justify-between"
                                     data-id="" data-search="-- pilih satuan pendidikan --" onclick="selectSekolahOption('', '-- Pilih Satuan Pendidikan --')">
                                    <span class="font-medium text-gray-500">-- Pilih Satuan Pendidikan --</span>
                                </div>
                                @foreach($sekolahs as $s)
                                    @php
                                        $isSel = old('sekolah_id', $user->sekolah_id ?? '') == $s->id;
                                        $searchText = strtolower($s->nama_sekolah . ' ' . $s->npsn . ' ' . $s->kecamatan);
                                        $displayLabel = $s->nama_sekolah;
                                    @endphp
                                    <div class="sekolah-option-item group px-3 py-2.5 text-xs hover:bg-blue-900 hover:text-white rounded-lg cursor-pointer transition flex items-center justify-between {{ $isSel ? 'bg-blue-900 text-white font-bold' : 'text-gray-700' }}"
                                         data-id="{{ $s->id }}"
                                         data-name="{{ $displayLabel }}"
                                         data-search="{{ $searchText }}"
                                         onclick="selectSekolahOption('{{ $s->id }}', '{{ addslashes($s->nama_sekolah) }}')">
                                        <span class="font-semibold text-xs truncate group-hover:text-white {{ $isSel ? 'text-white' : 'text-gray-800' }}">{{ $s->nama_sekolah }}</span>
                                        @if($isSel)
                                            <i class="fas fa-check text-white text-xs flex-shrink-0 ml-2"></i>
                                        @endif
                                    </div>
                                @endforeach
                                <div id="noSekolahFound" class="hidden px-4 py-6 text-center text-xs text-gray-400 italic">
                                    <i class="fas fa-school-circle-xmark text-lg text-gray-300 mb-1 block"></i>
                                    Tidak ada sekolah yang cocok dengan pencarian.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION PASSWORD -->
                <div class="border-t border-gray-100 pt-5 space-y-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-lock"></i> Keamanan & Password
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Password {{ $isEdit ? '(Biarkan kosong jika tidak diubah)' : '*' }}
                            </label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" {{ $isEdit ? '' : 'required' }}
                                class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-blue-800 hover:bg-blue-900 rounded-lg shadow-md shadow-blue-900/30 transition flex items-center gap-2">
                        <i class="fas fa-save"></i> {{ $isEdit ? 'Perbarui Akun User' : 'Simpan Akun User Baru' }}
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script>
        function toggleSekolahField() {
            const roleSelect = document.getElementById('roleSelect');
            const wrapper = document.getElementById('sekolahFieldWrapper');
            if (roleSelect && wrapper) {
                if (roleSelect.value === 'ADMIN_DINAS') {
                    wrapper.classList.add('hidden');
                } else {
                    wrapper.classList.remove('hidden');
                }
            }
        }

        function toggleSekolahDropdown() {
            const panel = document.getElementById('sekolahDropdownPanel');
            const input = document.getElementById('sekolahSearchInput');
            if (!panel) return;
            const isHidden = panel.classList.contains('hidden');
            
            if (isHidden) {
                panel.classList.remove('hidden');
                setTimeout(() => input?.focus(), 50);
            } else {
                panel.classList.add('hidden');
            }
        }

        function selectSekolahOption(id, name) {
            const input = document.getElementById('sekolahIdInput');
            const label = document.getElementById('sekolahSelectLabel');
            const panel = document.getElementById('sekolahDropdownPanel');
            
            if (input) input.value = id;
            if (label) label.innerText = name || '-- Pilih Satuan Pendidikan --';
            if (panel) panel.classList.add('hidden');
            
            document.querySelectorAll('.sekolah-option-item').forEach(item => {
                const itemSpan = item.querySelector('span');
                let checkIcon = item.querySelector('.fa-check');
                
                if (item.getAttribute('data-id') == id) {
                    item.classList.add('bg-blue-900', 'text-white', 'font-bold');
                    item.classList.remove('text-gray-700');
                    if (itemSpan) {
                        itemSpan.classList.add('text-white');
                        itemSpan.classList.remove('text-gray-800');
                    }
                    if (!checkIcon && id !== '') {
                        checkIcon = document.createElement('i');
                        checkIcon.className = 'fas fa-check text-white text-xs flex-shrink-0 ml-2';
                        item.appendChild(checkIcon);
                    }
                } else {
                    item.classList.remove('bg-blue-900', 'text-white', 'font-bold');
                    item.classList.add('text-gray-700');
                    if (itemSpan) {
                        itemSpan.classList.remove('text-white');
                        itemSpan.classList.add('text-gray-800');
                    }
                    if (checkIcon) checkIcon.remove();
                }
            });
        }

        function filterSekolahOptions() {
            const searchInput = document.getElementById('sekolahSearchInput');
            const clearBtn = document.getElementById('clearSekolahSearchBtn');
            const noFound = document.getElementById('noSekolahFound');
            if (!searchInput) return;

            const query = searchInput.value.toLowerCase().trim().replace(/[^a-z0-9]/g, '');
            const items = document.querySelectorAll('.sekolah-option-item');
            let visibleCount = 0;

            if (query.length > 0) {
                clearBtn?.classList.remove('hidden');
            } else {
                clearBtn?.classList.add('hidden');
            }

            items.forEach(item => {
                const searchText = item.getAttribute('data-search') || '';
                const cleanSearch = searchText.replace(/[^a-z0-9]/g, '');
                
                if (!query || cleanSearch.includes(query)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                noFound?.classList.remove('hidden');
            } else {
                noFound?.classList.add('hidden');
            }
        }

        function clearSekolahSearch() {
            const input = document.getElementById('sekolahSearchInput');
            if (input) {
                input.value = '';
                filterSekolahOptions();
                input.focus();
            }
        }

        // Close dropdown on click outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('customSekolahSelect');
            const panel = document.getElementById('sekolahDropdownPanel');
            if (container && panel && !container.contains(e.target)) {
                panel.classList.add('hidden');
            }
        });

        // Initialize label if old/preset value exists
        document.addEventListener('DOMContentLoaded', function() {
            const hiddenVal = document.getElementById('sekolahIdInput')?.value;
            if (hiddenVal) {
                const activeItem = document.querySelector(`.sekolah-option-item[data-id="${hiddenVal}"]`);
                if (activeItem) {
                    const name = activeItem.getAttribute('data-name');
                    if (name) {
                        const label = document.getElementById('sekolahSelectLabel');
                        if (label) label.innerText = name;
                    }
                }
            }
        });
    </script>
@endsection
