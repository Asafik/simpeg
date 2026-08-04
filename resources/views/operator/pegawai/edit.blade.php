@extends('layouts.app')

@section('title', 'Edit Data Pegawai - ' . ($pegawai->nama_lengkap ?? 'SIMPEG-SP'))

@section('content')

    <!-- ===== HERO BLUE BANNER ===== -->
    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white px-6 md:px-10 pt-8 md:pt-10 pb-16 md:pb-20 shadow-lg shadow-blue-950/20 overflow-hidden">
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 text-xs text-blue-200 mb-1">
                    <a href="{{ route('operator.pegawai.index') }}" class="hover:underline">Data Pegawai</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>Edit Profil Pegawai</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-1">Edit Data Pegawai: {{ $pegawai->nama_lengkap }}</h2>
                <p class="text-blue-100 text-xs md:text-sm font-normal leading-relaxed opacity-90">
                    Perbarui data Aparatur Sipil Negara & Tenaga Kependidikan untuk <strong>{{ $sekolah->nama_sekolah ?? 'Satuan Pendidikan' }}</strong>.
                </p>
            </div>
            <a href="{{ route('operator.pegawai.index') }}" class="bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Data Pegawai</span>
            </a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="px-6 md:px-8 pb-8 flex-1 space-y-6 w-full -mt-8 relative z-20">

        <!-- Error Validation Summary -->
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 shadow-sm space-y-1">
                <p class="font-bold flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-rose-600"></i>
                    Terdapat kesalahan input formulir:
                </p>
                <ul class="list-disc list-inside text-rose-700 space-y-0.5 pl-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('operator.pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Card 1: Informasi Lembaga & Kepegawaian Utama -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-school text-blue-800"></i>
                        1. Informasi Lembaga & Kepegawaian Utama
                    </h3>
                    <span class="text-[10px] font-bold text-blue-800 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                        Wajib Diisi
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <!-- Satuan Pendidikan (Locked) -->
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="block font-bold text-gray-700 mb-1">Satuan Pendidikan</label>
                        <input type="hidden" name="sekolah_id" value="{{ $sekolah->id ?? $pegawai->sekolah_id }}">
                        <input type="text" readonly value="{{ $sekolah->nama_sekolah ?? 'Sekolah Operator' }} (NPSN: {{ $sekolah->npsn ?? '-' }})" class="w-full bg-gray-100 border border-gray-300 text-gray-700 font-bold rounded-lg px-3 py-2 cursor-not-allowed">
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Status Kepegawaian -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Status Kepegawaian <span class="text-rose-500">*</span></label>
                        <select name="status_kepegawaian" required class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="PNS" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                            <option value="PPPK PW" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PPPK PW' ? 'selected' : '' }}>PPPK PW (Paruh Waktu)</option>
                            <option value="Non-ASN" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Non-ASN' ? 'selected' : '' }}>Non-ASN / Honorer</option>
                        </select>
                    </div>

                    <!-- NIP / NIK -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">NIP / NIK</label>
                        <input type="text" name="nip_nik" value="{{ old('nip_nik', $pegawai->nip_nik) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- NIK (KTP) -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">NIK (KTP)</label>
                        <input type="text" name="nik" value="{{ old('nik', $pegawai->nik) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Pangkat / Golongan -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Pangkat / Golongan</label>
                        <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $pegawai->pangkat_golongan) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>
            </div>

            <!-- Card 2: Jabatan, Tugas, & Sertifikasi -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-briefcase text-blue-800"></i>
                        2. Jabatan, Tugas, & Sertifikasi Pendidik
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <!-- Jabatan Fungsional -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Jabatan Fungsional</label>
                        <input type="text" name="jabatan_fungsional" value="{{ old('jabatan_fungsional', $pegawai->jabatan_fungsional) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Jenis PTK -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Jenis PTK <span class="text-rose-500">*</span></label>
                        <select name="jenis_ptk" required class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="Pendidik" {{ old('jenis_ptk', $pegawai->jenis_ptk) == 'Pendidik' ? 'selected' : '' }}>Pendidik (Guru)</option>
                            <option value="Tenaga Kependidikan" {{ old('jenis_ptk', $pegawai->jenis_ptk) == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan (TU/Laboran)</option>
                        </select>
                    </div>

                    <!-- Jenis Guru -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Jenis Guru</label>
                        <select name="jenis_guru" class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="">-- Pilih Jenis Guru --</option>
                            <option value="Guru Kelas" {{ old('jenis_guru', $pegawai->jenis_guru) == 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
                            <option value="Guru Mata Pelajaran" {{ old('jenis_guru', $pegawai->jenis_guru) == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                            <option value="Guru BK" {{ old('jenis_guru', $pegawai->jenis_guru) == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                        </select>
                    </div>

                    <!-- Status Serdik -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Status Sertifikasi (Serdik) <span class="text-rose-500">*</span></label>
                        <select name="is_serdik" required class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="1" {{ old('is_serdik', $pegawai->is_serdik) == '1' ? 'selected' : '' }}>Sudah Serdik</option>
                            <option value="0" {{ old('is_serdik', $pegawai->is_serdik) == '0' ? 'selected' : '' }}>Belum Serdik</option>
                        </select>
                    </div>

                    <!-- No Serdik -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nomor Serdik</label>
                        <input type="text" name="no_serdik" value="{{ old('no_serdik', $pegawai->no_serdik) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- NUPTK -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">NUPTK</label>
                        <input type="text" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-mono focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>
                </div>
            </div>

            <!-- Card 3: Pendidikan & Biodata -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-blue-800"></i>
                        3. Pendidikan Terakhir & Biodata Diri
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <!-- Tingkat Pendidikan -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tingkat Pendidikan <span class="text-rose-500">*</span></label>
                        <select name="tingkat_pendidikan" required class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="S1/D4" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan) == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                            <option value="SMA/K" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan) == 'SMA/K' ? 'selected' : '' }}>SMA / SMK</option>
                            <option value="D3" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan) == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S2" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('tingkat_pendidikan', $pegawai->tingkat_pendidikan) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>

                    <!-- Jurusan / Prodi -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Jurusan / Program Studi</label>
                        <input type="text" name="jurusan_prodi" value="{{ old('jurusan_prodi', $pegawai->jurusan_prodi) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($pegawai->tanggal_lahir)->format('Y-m-d')) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Agama -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Agama</label>
                        <select name="agama" class="select2 w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800/20 cursor-pointer">
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama', $pegawai->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $pegawai->agama) == 'Kristen' || old('agama', $pegawai->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $pegawai->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $pegawai->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $pegawai->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('agama', $pegawai->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card 4: Upload Berkas PDF -->
            <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-xl shadow-gray-200/50 space-y-4">
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-file-pdf text-rose-600"></i>
                        4. Upload Dokumen Berkas (PDF / Gambar - Maks 2MB)
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">SK Kepegawaian Terakhir</label>
                        <input type="file" name="file_sk" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-lg border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                        @if($pegawai->file_sk)
                            <p class="text-[10px] text-emerald-600 font-semibold mt-1"><i class="fas fa-circle-check mr-1"></i>Berkas SK sudah ada</p>
                        @endif
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Sertifikat Pendidik (Serdik)</label>
                        <input type="file" name="file_serdik" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-lg border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                        @if($pegawai->file_serdik)
                            <p class="text-[10px] text-emerald-600 font-semibold mt-1"><i class="fas fa-circle-check mr-1"></i>Berkas Serdik sudah ada</p>
                        @endif
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Ijazah Terakhir</label>
                        <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-600 bg-gray-50 rounded-lg border border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-800/20">
                        @if($pegawai->file_ijazah)
                            <p class="text-[10px] text-emerald-600 font-semibold mt-1"><i class="fas fa-circle-check mr-1"></i>Berkas Ijazah sudah ada</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('operator.pegawai.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold px-6 py-2.5 rounded-lg shadow-md transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Perbarui Data Pegawai
                </button>
            </div>
        </form>
    </div>
@endsection
