<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'ADMIN_DINAS')->first();
        $adminId = $admin?->id;
        $adminName = $admin?->name ?? 'Administrator Dinas Pendidikan';

        $announcements = [
            [
                'judul' => 'Jadwal Verifikasi & Validasi Berkas Kepegawaian Semester Ganjil 2026',
                'kategori' => 'Verifikasi',
                'ringkasan' => 'Dihimbau kepada seluruh Operator Satuan Pendidikan untuk melengkapi unggahan dokumen SK, Sertifikat Pendidik, dan Ijazah.',
                'isi' => "Sehubungan dengan agenda pemutakhiran data SIMPEG-SP Kabupaten/Kota tahun anggaran 2026, bersama ini disampaikan beberapa hal penting bagi seluruh Operator Satuan Pendidikan:\n\n1. Pengunggahan berkas digital (SK, Serdik, Ijazah) wajib diselesaikan sebelum batas waktu tanggal 15 Agustus 2026.\n2. Batas maksimal ukuran berkas adalah 10 MB untuk Foto (JPG/PNG) dan 20 MB untuk PDF.\n3. Berkas yang sudah diunggah akan diverifikasi langsung oleh Tim Validasi Dinas Pendidikan.\n4. Apabila terdapat catatan perbaikan (status REVISI), Operator Sekolah diharapkan segera melakukan perbaikan dokumen.\n\nDemikian edaran ini disampaikan untuk dilaksanakan sebagaimana mestinya.",
                'penulis_id' => $adminId,
                'penulis_nama' => $adminName,
                'is_published' => true,
            ],
            [
                'judul' => 'Batas Akhir Pemutakhiran Data TMT Jabatan & Sertifikasi Guru (NUPTK)',
                'kategori' => 'Penting',
                'ringkasan' => 'Batas akhir sinkronisasi data TMT Jabatan Fungsional dan Nomor Sertifikasi Guru untuk pencairan tunjangan kepegawaian.',
                'isi' => "Berdasarkan petunjuk teknis pencairan tunjangan kepegawaian dan Sertifikat Pendidik (Serdik), seluruh Operator Sekolah diminta untuk mencocokkan kembali data NUPTK, Nomor Sertifikasi, dan TMT Jabatan Fungsional Guru pada SIMPEG-SP.\n\nPastikan data yang diinputkan sesuai dengan dokumen asli. Kelalaian atau ketidaksesuaian data dapat mengakibatkan penundaan proses pencairan tunjangan.",
                'penulis_id' => $adminId,
                'penulis_nama' => $adminName,
                'is_published' => true,
            ],
            [
                'judul' => 'Surat Edaran Penggunaan Template Resmi Import Data Pegawai Excel',
                'kategori' => 'Surat Edaran',
                'ringkasan' => 'Panduan pengisian dan pengunggahan file Excel rekapitulasi data pegawai menggunakan template baku SIMPEG-SP.',
                'isi' => "Untuk menjaga konsistensi dan integritas data seluruh Satuan Pendidikan, penggunaan fitur Import Excel wajib menggunakan file template format xlsx/xls resmi dari Dinas Pendidikan.\n\nTemplate dapat diunduh langsung pada halaman Data Pegawai. Sistem secara otomatis melakukan validasi dan pembersihan data duplikat saat proses impor berlangsung.",
                'penulis_id' => $adminId,
                'penulis_nama' => $adminName,
                'is_published' => true,
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::create($data);
        }
    }
}
