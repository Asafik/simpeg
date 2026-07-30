@extends('layouts.app')

@php
    $isEdit = isset($pegawai) && $pegawai->id;
    $title = $isEdit ? 'Edit Data Pegawai - SIMPEG-SP' : 'Tambah Data Pegawai - SIMPEG-SP';
    $formUrl = $isEdit ? route('pegawai.update', $pegawai->id) : route('pegawai.store');
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
                    <a href="{{ route('pegawai.index') }}" class="hover:underline">Data Pegawai</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>{{ $isEdit ? 'Edit Pegawai' : 'Input Baru' }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">
                    {{ $isEdit ? 'Edit Profil & Data Pegawai' : 'Form Input Data Pegawai (PTK)' }}
                </h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    {{ $isEdit ? 'Perbarui identitas, kriteria kepegawaian, dan berkas pendukung untuk ' . $pegawai->nama_lengkap : 'Lengkapi identitas diri, 25 kriteria kepegawaian resmi, serta unggah berkas pendukung.' }}
                </p>
            </div>
            
            <!-- Kembali Button -->
            <a href="{{ route('pegawai.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Data Pegawai</span>
            </a>
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 w-full -mt-8 relative z-20">
        
        @if (isset($errors) && method_exists($errors, 'any') && $errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 space-y-1 shadow-md animate-fade-in">
                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-triangle-exclamation"></i> Terdapat kesalahan pengisian form:</p>
                <ul class="list-disc list-inside pl-2 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- SECTION 1: IDENTITAS DIRI & SEKOLAH -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-user"></i> Identitas Diri & Satuan Pendidikan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Satuan Pendidikan / Sekolah (Custom Searchable Dropdown) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Satuan Pendidikan / Sekolah <span class="text-red-500">*</span></label>
                        <div class="relative" id="customSekolahSelect">
                            <input type="hidden" name="sekolah_id" id="sekolahIdInput" value="{{ old('sekolah_id', $pegawai->sekolah_id ?? '') }}" required>
                            
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
                                        <input type="text" id="sekolahSearchInput" oninput="filterSekolahOptions()" placeholder="Ketik nama sekolah, NPSN, atau kecamatan..."
                                            class="w-full bg-white border border-gray-200 rounded-lg pl-8 pr-8 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10">
                                        <button type="button" id="clearSekolahSearchBtn" onclick="clearSekolahSearch()" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Options Scrollable Container -->
                                <div class="max-h-60 overflow-y-auto divide-y divide-gray-50 p-1" id="sekolahOptionsList">
                                    <div class="sekolah-option-item px-3 py-2 text-xs hover:bg-blue-50 text-gray-700 rounded-lg cursor-pointer transition flex items-center justify-between"
                                         data-id="" data-search="-- pilih satuan pendidikan --" onclick="selectSekolahOption('', '-- Pilih Satuan Pendidikan --')">
                                        <span class="font-medium text-gray-500">-- Pilih Satuan Pendidikan --</span>
                                    </div>
                                    @foreach($sekolahs as $s)
                                        @php
                                            $isSel = old('sekolah_id', $pegawai->sekolah_id ?? '') == $s->id;
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

                    <!-- Foto Profil -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <!-- Preview Avatar -->
                            <div class="relative w-16 h-16 rounded-full overflow-hidden border-2 border-gray-200 flex-shrink-0 bg-gray-100 flex items-center justify-center shadow-sm">
                                @php
                                    $hasPhoto = isset($pegawai) && $pegawai->photo_profile;
                                    $name = old('nama_lengkap', $pegawai->nama_lengkap ?? '');
                                    $initials = 'PT';
                                    if(trim($name)) {
                                        $words = explode(' ', trim($name));
                                        if(count($words) >= 2) {
                                            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                        } else {
                                            $initials = strtoupper(substr($words[0], 0, 2));
                                        }
                                    }
                                @endphp
                                <img id="photo_preview_img" src="{{ $hasPhoto ? $pegawai->profile_picture_url : '' }}" alt="Foto Profil" class="{{ $hasPhoto ? '' : 'hidden' }} w-full h-full object-cover">
                                <div id="photo_preview_initials" class="{{ $hasPhoto ? 'hidden' : 'flex' }} w-full h-full bg-blue-800 text-white items-center justify-center text-xl font-bold">
                                    {{ $initials }}
                                </div>
                            </div>
                            
                            <!-- Input Field -->
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" id="photo_profile_input" name="photo_profile" accept="image/jpeg,image/png,image/jpg,image/webp,application/pdf" class="hidden" onchange="previewPhoto(this)">
                                    <input type="hidden" id="remove_photo_profile_input" name="remove_photo_profile" value="0">
                                    <label for="photo_profile_input" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-xs font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:border-blue-300 hover:text-blue-700 transition">
                                        <i class="fas fa-camera"></i> Pilih Berkas / Foto
                                    </label>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1.5">Format: JPG, PNG, WEBP, PDF (Max 20MB). Kosongkan jika tidak ada.</p>
                                <button type="button" onclick="removePhoto()" id="btn_remove_photo" class="{{ $hasPhoto ? 'inline-block' : 'hidden' }} mt-1 text-[10px] text-red-500 hover:text-red-700 font-semibold"><i class="fas fa-trash-alt"></i> Hapus Foto</button>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap + Gelar -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_lengkap_input" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap ?? '') }}" placeholder="Contoh: DIYANDIKA ANGGRAENI, S.Pd." required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none" oninput="updateInitials(this.value)">
                    </div>

                    <!-- NIP / NIK -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip_nik" value="{{ old('nip_nik', $pegawai->nip_nik ?? '') }}" placeholder="Masukkan NIP (Kosongkan jika Non-ASN)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- NIK terpisah -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">NIK (Nomor Induk Kependudukan 16 Digit)</label>
                        <input type="text" name="nik" value="{{ old('nik', $pegawai->nik ?? '') }}" placeholder="Contoh: 3509264912890003" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}" placeholder="Contoh: JEMBER" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($pegawai->tanggal_lahir) ? Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '') }}" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="select2 w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Agama -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Agama</label>
                        <select name="agama" class="select2 w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu', 'Lainnya'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama', $pegawai->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: STATUS KEPEGAWAIAN & JABATAN FUNGSIONAL -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-id-card"></i> Status Kepegawaian & Jabatan Fungsional
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status Kepegawaian -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Status Kepegawaian <span class="text-red-500">*</span></label>
                        <select name="status_kepegawaian" required class="select2 w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="PNS" {{ old('status_kepegawaian', $pegawai->status_kepegawaian ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ old('status_kepegawaian', $pegawai->status_kepegawaian ?? '') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                            <option value="PPPK PW" {{ old('status_kepegawaian', $pegawai->status_kepegawaian ?? '') == 'PPPK PW' ? 'selected' : '' }}>PPPK PW (Paruh Waktu)</option>
                            <option value="Non-ASN" {{ old('status_kepegawaian', $pegawai->status_kepegawaian ?? '') == 'Non-ASN' ? 'selected' : '' }}>Non-ASN</option>
                        </select>
                    </div>

                    <!-- Pangkat / Golongan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Pangkat / Golongan Ruang</label>
                        @php
                            $currentPangkat = old('pangkat_golongan', $pegawai->pangkat_golongan ?? '');
                            $pangkatOptions = [
                                'Non-ASN / Honorer' => [
                                    '-' => '- (Non-ASN / Honorer)',
                                ],
                                'PPPK (Pegawai Pemerintah dengan Perjanjian Kerja)' => [
                                    'IX' => 'Golongan IX (PPPK - S1 / Sarjana)',
                                    'X' => 'Golongan X (PPPK - S2 / Magister)',
                                    'XI' => 'Golongan XI (PPPK - S3 / Doktor)',
                                    'V' => 'Golongan V (PPPK - D3)',
                                    'VII' => 'Golongan VII (PPPK - Sarjana Muda)',
                                    'VIII' => 'Golongan VIII (PPPK)',
                                    'I' => 'Golongan I (PPPK)',
                                    'II' => 'Golongan II (PPPK)',
                                    'III' => 'Golongan III (PPPK)',
                                    'IV' => 'Golongan IV (PPPK)',
                                    'VI' => 'Golongan VI (PPPK)',
                                    'XII' => 'Golongan XII (PPPK)',
                                    'XIII' => 'Golongan XIII (PPPK)',
                                    'XIV' => 'Golongan XIV (PPPK)',
                                    'XV' => 'Golongan XV (PPPK)',
                                    'XVI' => 'Golongan XVI (PPPK)',
                                    'XVII' => 'Golongan XVII (PPPK)',
                                ],
                                'PNS - Golongan III (Penata)' => [
                                    'Penata Muda (III/a)' => 'Penata Muda (III/a)',
                                    'Penata Muda Tk. I, III/b' => 'Penata Muda Tingkat I (III/b)',
                                    'Penata, III/c' => 'Penata (III/c)',
                                    'Penata Tk. I, III/d' => 'Penata Tingkat I (III/d)',
                                ],
                                'PNS - Golongan IV (Pembina)' => [
                                    'Pembina, IV/a' => 'Pembina (IV/a)',
                                    'Pembina Tk. I, IV/b' => 'Pembina Tingkat I (IV/b)',
                                    'Pembina Utama Muda, IV/c' => 'Pembina Utama Muda (IV/c)',
                                    'Pembina Utama Madya (IV/d)' => 'Pembina Utama Madya (IV/d)',
                                    'Pembina Utama (IV/e)' => 'Pembina Utama (IV/e)',
                                ],
                                'PNS - Golongan II (Pengatur)' => [
                                    'Pengatur Muda, II/a' => 'Pengatur Muda (II/a)',
                                    'Pengatur Muda Tk. I, II/b' => 'Pengatur Muda Tingkat I (II/b)',
                                    'Pengatur, II/c' => 'Pengatur (II/c)',
                                    'Pengatur Tk. I, II/d' => 'Pengatur Tingkat I (II/d)',
                                ],
                                'PNS - Golongan I (Juru)' => [
                                    'Juru Muda (I/a)' => 'Juru Muda (I/a)',
                                    'Juru Muda Tingkat I (I/b)' => 'Juru Muda Tingkat I (I/b)',
                                    'Juru (I/c)' => 'Juru (I/c)',
                                    'Juru Tingkat I (I/d)' => 'Juru Tingkat I (I/d)',
                                ],
                            ];
                            $matchedOption = false;
                        @endphp
                        <select name="pangkat_golongan" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="">-- Pilih Pangkat / Golongan --</option>
                            @foreach($pangkatOptions as $groupLabel => $options)
                                <optgroup label="{{ $groupLabel }}">
                                    @foreach($options as $val => $label)
                                        @php
                                            $isSelected = ($currentPangkat === $val || (strlen($currentPangkat) > 0 && strtolower(trim($currentPangkat)) === strtolower(trim($val))));
                                            if ($isSelected) $matchedOption = true;
                                        @endphp
                                        <option value="{{ $val }}" {{ $isSelected ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                            @if(!empty($currentPangkat) && !$matchedOption)
                                <option value="{{ $currentPangkat }}" selected>{{ $currentPangkat }} (Custom)</option>
                            @endif
                        </select>
                    </div>

                    <!-- Jabatan Fungsional -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jabatan Fungsional</label>
                        <input type="text" name="jabatan_fungsional" value="{{ old('jabatan_fungsional', $pegawai->jabatan_fungsional ?? '') }}" placeholder="Contoh: Guru Ahli Pertama" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- No. SK Jabfung -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">No. SK Jabfung</label>
                        <input type="text" name="no_sk_jabfung" value="{{ old('no_sk_jabfung', $pegawai->no_sk_jabfung ?? '') }}" placeholder="Nomor SK Jabatan Fungsional" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- TMT Jabfung -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">TMT Jabfung</label>
                        <input type="text" name="tmt_jabfung" value="{{ old('tmt_jabfung', $pegawai->tmt_jabfung ?? '') }}" placeholder="TMT Jabatan Fungsional" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Status Serdik -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Status Sertifikasi (Serdik) <span class="text-red-500">*</span></label>
                        <select name="is_serdik" required class="select2 w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="1" {{ old('is_serdik', isset($pegawai) && $pegawai->is_serdik ? '1' : '0') == '1' ? 'selected' : '' }}>SERDIK (Bersertifikasi)</option>
                            <option value="0" {{ old('is_serdik', isset($pegawai) && $pegawai->is_serdik ? '1' : '0') == '0' ? 'selected' : '' }}>NON SERDIK</option>
                        </select>
                    </div>

                    <!-- Nomor Serdik -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Serdik</label>
                        <input type="text" name="no_serdik" value="{{ old('no_serdik', $pegawai->no_serdik ?? '') }}" placeholder="Nomor Sertifikat Pendidik" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Tanggal Serdik -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Serdik</label>
                        <input type="text" name="tgl_serdik" value="{{ old('tgl_serdik', $pegawai->tgl_serdik ?? '') }}" placeholder="Tanggal Sertifikat (contoh: 15/09/2022)" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- SECTION 3: TUGAS, PTK & PENGAJARAN -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-chalkboard-user"></i> Penugasan PTK & Mengajar
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Jenis PTK -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis PTK <span class="text-red-500">*</span></label>
                        <select name="jenis_ptk" required class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none font-medium">
                            <option value="Pendidik" {{ old('jenis_ptk', $pegawai->jenis_ptk ?? '') == 'Pendidik' ? 'selected' : '' }}>Pendidik (Guru)</option>
                            <option value="Tenaga Kependidikan" {{ old('jenis_ptk', $pegawai->jenis_ptk ?? '') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan (Staf TU / Administrasi / Laboran)</option>
                            <option value="Penjaga Sekolah" {{ old('jenis_ptk', $pegawai->jenis_ptk ?? '') == 'Penjaga Sekolah' ? 'selected' : '' }}>Penjaga Sekolah / Kebersihan / Keamanan</option>
                        </select>
                    </div>

                    <!-- Jenis Guru -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis Guru / Tugas</label>
                        <input type="text" name="jenis_guru" value="{{ old('jenis_guru', $pegawai->jenis_guru ?? '') }}" placeholder="Contoh: Guru Kelas, Guru PAI, Guru PJOK" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Jumlah JP Mengajar -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jumlah JP Mengajar</label>
                        <input type="text" name="jumlah_jp" value="{{ old('jumlah_jp', $pegawai->jumlah_jp ?? '') }}" placeholder="Contoh: 32 JP" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- NUPTK -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">NUPTK</label>
                        <input type="text" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk ?? '') }}" placeholder="Nomor Unik Pendidik" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>

                    <!-- Tingkat Pendidikan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tingkat Pendidikan <span class="text-red-500">*</span></label>
                        <select name="tingkat_pendidikan" required class="select2 w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                            <option value="SMA/K" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan ?? '') == 'SMA/K' ? 'selected' : '' }}>SMA / Sederajat</option>
                            <option value="D3" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan ?? '') == 'D3' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                            <option value="S1/D4" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan ?? 'S1/D4') == 'S1/D4' ? 'selected' : '' }}>Strata 1 (S1) / D4</option>
                            <option value="S2" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan ?? '') == 'S2' ? 'selected' : '' }}>Strata 2 (S2)</option>
                            <option value="S3" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan ?? '') == 'S3' ? 'selected' : '' }}>Strata 3 (S3)</option>
                        </select>
                    </div>

                    <!-- Jurusan / Program Studi -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jurusan / Program Studi</label>
                        <input type="text" name="jurusan_prodi" value="{{ old('jurusan_prodi', $pegawai->jurusan_prodi ?? '') }}" placeholder="Contoh: Pendidikan Matematika, PGSD" class="w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-800/20 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- SECTION 4: UPLOAD BERKAS PENDUKUNG (PDF / Gambar, Max 2 MB) -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-blue-800 flex items-center gap-2">
                        <i class="fas fa-folder-open text-sm"></i> Upload Berkas Pendukung (PDF / Gambar, Max 2 MB)
                    </h3>
                    <span class="text-[10px] text-gray-400 font-medium"><i class="fas fa-shield-halved text-emerald-600 mr-1"></i>Aman & Terenkripsi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- 1. FILE SK KEPEGAWAIAN -->
                    <div class="relative bg-gray-50/60 hover:bg-blue-50/40 border-2 border-dashed border-gray-200 hover:border-blue-500 rounded-2xl p-5 text-center transition duration-200 group cursor-pointer"
                         onclick="document.getElementById('file_sk_input').click()">
                        
                        <input type="file" name="file_sk[]" multiple id="file_sk_input" accept="image/*,.pdf" class="hidden" onclick="event.stopPropagation()"
                               onchange="handleFileUploadPreview(this, 'file_sk_preview', 'file_sk_info', 'file_sk_icon', 'file_sk_preview_icon')">

                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100/80 group-hover:bg-blue-800 text-blue-800 group-hover:text-white mx-auto flex items-center justify-center transition duration-200 shadow-sm">
                                <i id="file_sk_icon" class="fas fa-file-pdf text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-800 group-hover:text-blue-900 transition">SK Kepegawaian (SK Terakhir)</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 leading-tight">Unggah SK Terakhir (Bisa lebih dari 1 file berkas/foto/PDF, maks 3 file @ 20MB)</p>
                            </div>

                            @if(isset($pegawai->file_sk) && is_array($pegawai->file_sk) && count($pegawai->file_sk) > 0)
                                <div class="mt-2 bg-emerald-50 border border-emerald-200 rounded-lg p-2 text-left">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i class="fas fa-file-circle-check text-emerald-600 text-sm"></i>
                                        <span class="text-[10px] font-bold text-emerald-800">{{ count($pegawai->file_sk) }} Berkas Terunggah</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($pegawai->file_sk as $idx => $path)
                                            <a href="{{ asset('files/' . $path) }}" target="_blank" onclick="event.stopPropagation()" class="text-[10px] font-bold text-blue-600 hover:underline flex-shrink-0">
                                                File {{ $idx+1 }} <i class="fas fa-external-link-alt text-[9px]"></i>
                                            </a>
                                            @if(!$loop->last) <span class="text-gray-300">|</span> @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div id="file_sk_preview" class="hidden mt-2 bg-white border border-blue-200 rounded-lg p-2 text-left shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 truncate">
                                        <i id="file_sk_preview_icon" class="fas fa-file-pdf text-rose-500 text-sm"></i>
                                        <span id="file_sk_info" class="text-[10px] font-bold text-gray-800 truncate"></span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">Siap Upload</span>
                                        <button type="button" onclick="clearFileUpload(event, 'file_sk_input', 'file_sk_preview', 'file_sk_icon')" class="w-5 h-5 flex items-center justify-center rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition" title="Hapus Pilihan">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1">
                                <span id="file_sk_btn_text" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-gray-700 font-bold text-[10px] shadow-xs group-hover:border-blue-300 group-hover:text-blue-800 transition">
                                    <i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. FILE SERTIFIKAT PENDIDIK (SERDIK) -->
                    <div class="relative bg-gray-50/60 hover:bg-emerald-50/40 border-2 border-dashed border-gray-200 hover:border-emerald-500 rounded-2xl p-5 text-center transition duration-200 group cursor-pointer"
                         onclick="document.getElementById('file_serdik_input').click()">
                        
                        <input type="file" name="file_serdik[]" multiple id="file_serdik_input" accept="image/*,.pdf" class="hidden" onclick="event.stopPropagation()"
                               onchange="handleFileUploadPreview(this, 'file_serdik_preview', 'file_serdik_info', 'file_serdik_icon', 'file_serdik_preview_icon')">

                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100/80 group-hover:bg-emerald-700 text-emerald-700 group-hover:text-white mx-auto flex items-center justify-center transition duration-200 shadow-sm">
                                <i id="file_serdik_icon" class="fas fa-award text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-800 group-hover:text-emerald-900 transition">Sertifikat Pendidik (Serdik)</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 leading-tight">Unggah Serdik (Bisa lebih dari 1 file berkas/foto/PDF, maks 3 file @ 20MB)</p>
                            </div>

                            @if(isset($pegawai->file_serdik) && is_array($pegawai->file_serdik) && count($pegawai->file_serdik) > 0)
                                <div class="mt-2 bg-emerald-50 border border-emerald-200 rounded-lg p-2 text-left">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i class="fas fa-file-circle-check text-emerald-600 text-sm"></i>
                                        <span class="text-[10px] font-bold text-emerald-800">{{ count($pegawai->file_serdik) }} Berkas Terunggah</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($pegawai->file_serdik as $idx => $path)
                                            <a href="{{ asset('files/' . $path) }}" target="_blank" onclick="event.stopPropagation()" class="text-[10px] font-bold text-blue-600 hover:underline flex-shrink-0">
                                                File {{ $idx+1 }} <i class="fas fa-external-link-alt text-[9px]"></i>
                                            </a>
                                            @if(!$loop->last) <span class="text-gray-300">|</span> @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div id="file_serdik_preview" class="hidden mt-2 bg-white border border-emerald-200 rounded-lg p-2 text-left shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 truncate">
                                        <i id="file_serdik_preview_icon" class="fas fa-file-pdf text-rose-500 text-sm"></i>
                                        <span id="file_serdik_info" class="text-[10px] font-bold text-gray-800 truncate"></span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">Siap Upload</span>
                                        <button type="button" onclick="clearFileUpload(event, 'file_serdik_input', 'file_serdik_preview', 'file_serdik_icon')" class="w-5 h-5 flex items-center justify-center rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition" title="Hapus Pilihan">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1">
                                <span id="file_serdik_btn_text" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-gray-700 font-bold text-[10px] shadow-xs group-hover:border-emerald-300 group-hover:text-emerald-800 transition">
                                    <i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. FILE IJAZAH TERAKHIR -->
                    <div class="relative bg-gray-50/60 hover:bg-purple-50/40 border-2 border-dashed border-gray-200 hover:border-purple-500 rounded-2xl p-5 text-center transition duration-200 group cursor-pointer"
                         onclick="document.getElementById('file_ijazah_input').click()">
                        
                        <input type="file" name="file_ijazah[]" multiple id="file_ijazah_input" accept="image/*,.pdf" class="hidden" onclick="event.stopPropagation()"
                               onchange="handleFileUploadPreview(this, 'file_ijazah_preview', 'file_ijazah_info', 'file_ijazah_icon', 'file_ijazah_preview_icon')">

                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-2xl bg-purple-100/80 group-hover:bg-purple-700 text-purple-700 group-hover:text-white mx-auto flex items-center justify-center transition duration-200 shadow-sm">
                                <i id="file_ijazah_icon" class="fas fa-graduation-cap text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-800 group-hover:text-purple-900 transition">Ijazah (S1 / S2 / S3)</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 leading-tight">Unggah Ijazah (Jika S2/S3, bisa upload S1 & S2/S3 sekaligus, maks 3 file @ 20MB)</p>
                            </div>

                            @if(isset($pegawai->file_ijazah) && is_array($pegawai->file_ijazah) && count($pegawai->file_ijazah) > 0)
                                <div class="mt-2 bg-emerald-50 border border-emerald-200 rounded-lg p-2 text-left">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i class="fas fa-file-circle-check text-emerald-600 text-sm"></i>
                                        <span class="text-[10px] font-bold text-emerald-800">{{ count($pegawai->file_ijazah) }} Berkas Terunggah</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($pegawai->file_ijazah as $idx => $path)
                                            <a href="{{ asset('files/' . $path) }}" target="_blank" onclick="event.stopPropagation()" class="text-[10px] font-bold text-blue-600 hover:underline flex-shrink-0">
                                                File {{ $idx+1 }} <i class="fas fa-external-link-alt text-[9px]"></i>
                                            </a>
                                            @if(!$loop->last) <span class="text-gray-300">|</span> @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div id="file_ijazah_preview" class="hidden mt-2 bg-white border border-purple-200 rounded-lg p-2 text-left shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 truncate">
                                        <i id="file_ijazah_preview_icon" class="fas fa-file-pdf text-rose-500 text-sm"></i>
                                        <span id="file_ijazah_info" class="text-[10px] font-bold text-gray-800 truncate"></span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">Siap Upload</span>
                                        <button type="button" onclick="clearFileUpload(event, 'file_ijazah_input', 'file_ijazah_preview', 'file_ijazah_icon')" class="w-5 h-5 flex items-center justify-center rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition" title="Hapus Pilihan">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1">
                                <span id="file_ijazah_btn_text" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-gray-700 font-bold text-[10px] shadow-xs group-hover:border-purple-300 group-hover:text-purple-800 transition">
                                    <i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('pegawai.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-blue-800 hover:bg-blue-900 rounded-lg shadow-md shadow-blue-900/30 transition flex items-center gap-2 cursor-pointer">
                    <i class="fas fa-save"></i> {{ $isEdit ? 'Perbarui Data Pegawai' : 'Simpan Data Pegawai' }}
                </button>
            </div>

        </form>
    </div>

    <script>
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
            
            // Update checkmarks & styling
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

        const fileAccumulators = {};

        window.clearFileUpload = function(event, inputId, previewId, iconId) {
            event.stopPropagation();
            const input = document.getElementById(inputId);
            if (input) {
                input.value = ''; // clears actual input
                fileAccumulators[inputId] = new DataTransfer(); // reset accumulator
            }
            document.getElementById(previewId).classList.add('hidden');
            document.getElementById(iconId).classList.remove('text-white');
            document.getElementById(iconId).parentElement.classList.remove('bg-opacity-100');
            
            const btnTextElem = document.getElementById(inputId.replace('_input', '') + '_btn_text');
            if (btnTextElem) {
                btnTextElem.innerHTML = '<i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas';
            }
        };

        window.handleFileUploadPreview = function(input, previewId, infoId, iconId, previewIconId) {
            let dt = fileAccumulators[input.id] || new DataTransfer();

            if (input.files && input.files.length > 0) {
                // Append files
                for (let i = 0; i < input.files.length; i++) {
                    if (dt.items.length < 3) {
                        dt.items.add(input.files[i]);
                    } else {
                        alert('Maksimal 3 file yang diizinkan! Kelebihan file diabaikan.');
                        break;
                    }
                }
            }

            // Assign back to input so it's sent on submit
            input.files = dt.files;
            fileAccumulators[input.id] = dt;

            const count = input.files.length;
            
            const infoElem = document.getElementById(infoId);
            const previewElem = document.getElementById(previewId);
            const iconElem = document.getElementById(iconId);
            const previewIconElem = document.getElementById(previewIconId);
            const btnTextElem = document.getElementById(input.id.replace('_input', '') + '_btn_text');
            
            if (count > 0) {
                if (previewIconElem) {
                    previewIconElem.className = 'fas fa-images text-blue-600 text-sm';
                }
                
                if (infoElem) {
                    let totalSize = 0;
                    for (let i = 0; i < count; i++) {
                        totalSize += input.files[i].size;
                    }
                    const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
                    infoElem.textContent = count + ' file terpilih (' + totalSizeMB + ' MB)';
                }
                
                if (previewElem) {
                    previewElem.classList.remove('hidden');
                    previewElem.classList.add('animate-fadeIn');
                }
                if (iconElem) {
                    iconElem.classList.add('text-white');
                    iconElem.parentElement.classList.add('bg-opacity-100');
                }

                if (btnTextElem) {
                    if (count < 3) {
                        btnTextElem.innerHTML = '<i class="fas fa-plus text-[10px]"></i> Tambah Berkas';
                    } else {
                        btnTextElem.innerHTML = '<i class="fas fa-check text-[10px]"></i> Maksimal (3)';
                    }
                }
            } else {
                if (previewElem) previewElem.classList.add('hidden');
                if (iconElem) {
                    iconElem.classList.remove('text-white');
                    iconElem.parentElement.classList.remove('bg-opacity-100');
                }
                if (btnTextElem) {
                    btnTextElem.innerHTML = '<i class="fas fa-paperclip text-[10px]"></i> Pilih Berkas';
                }
            }
        };

        window.previewPhoto = function(input) {
            const previewImg = document.getElementById('photo_preview_img');
            const previewInitials = document.getElementById('photo_preview_initials');
            const removeBtn = document.getElementById('btn_remove_photo');
            const removeInput = document.getElementById('remove_photo_profile_input');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    previewInitials.classList.remove('flex');
                    previewInitials.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                    removeBtn.classList.add('inline-block');
                    if (removeInput) removeInput.value = '0';
                }
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removePhoto = function() {
            const input = document.getElementById('photo_profile_input');
            const previewImg = document.getElementById('photo_preview_img');
            const previewInitials = document.getElementById('photo_preview_initials');
            const removeBtn = document.getElementById('btn_remove_photo');
            const removeInput = document.getElementById('remove_photo_profile_input');
            
            input.value = ''; // Hapus pilihan file
            if (removeInput) removeInput.value = '1'; // Tandai untuk dihapus di database
            
            previewImg.src = '';
            previewImg.classList.add('hidden');
            previewInitials.classList.remove('hidden');
            previewInitials.classList.add('flex');
            removeBtn.classList.remove('inline-block');
            removeBtn.classList.add('hidden');
        };

        window.updateInitials = function(name) {
            const previewInitials = document.getElementById('photo_preview_initials');
            if (previewInitials && !previewInitials.classList.contains('hidden')) {
                let initials = 'PT';
                name = name.trim();
                if (name) {
                    const words = name.split(' ').filter(w => w.length > 0);
                    if (words.length >= 2) {
                        initials = (words[0][0] + words[1][0]).toUpperCase();
                    } else if (words.length === 1) {
                        initials = (words[0][0] + (words[0][1] || '')).toUpperCase();
                    }
                }
                previewInitials.textContent = initials;
            }
        };

        window.syncTanggalLahir = function() {
            const day = document.getElementById('dob_day').value;
            const month = document.getElementById('dob_month').value;
            const year = document.getElementById('dob_year').value;
            const hiddenInput = document.getElementById('tanggal_lahir_hidden');

            if (day && month && year) {
                hiddenInput.value = `${year}-${month}-${day}`;
            } else {
                hiddenInput.value = '';
            }
        };

        // Run sync once on page load if values pre-filled
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof syncTanggalLahir === 'function') {
                syncTanggalLahir();
            }
        });
    </script>
@endsection
