# Product Requirement Document (PRD)
## Sistem Informasi Manajemen Pegawai Satuan Pendidikan (SIMPEG-SP)
**Dinas Pendidikan**

---

| Informasi Dokumen | Detail |
| :--- | :--- |
| **Nama Proyek** | Sistem Informasi Manajemen Pegawai Satuan Pendidikan (SIMPEG-SP) |
| **Versi Document** | v1.0 |
| **Status** | Ready for Implementation |
| **Target Pengguna** | Dinas Pendidikan & Satuan Pendidikan (Sekolah) |

---

## 1. Latar Belakang & Tujuan

### 1.1 Latar Belakang
Dinas Pendidikan memerlukan sistem pengelolaan data kepegawaian terpusat untuk memetakan kondisi kualifikasi, status, serta distribusi pendidik dan tenaga kependidikan (PTK) di seluruh satuan pendidikan. Dengan variasi status kepegawaian (PNS, PPPK, PPPK PW, Non-ASN) serta kebutuhan pemetaan kompetensi, dibutuhkan aplikasi berbasis web yang akurat dan real-time.

### 1.2 Tujuan Utama
1. **Pemusatan Data:** Menyediakan data pegawai terpusat (*single source of truth*) di lingkungan Dinas Pendidikan.
2. **Efisiensi Pendataan:** Pembagian peran input data ke Operator Sekolah guna mengurangi penumpukan beban administrasi di Dinas.
3. **Pengambilan Keputusan Berbasis Data:** Menyediakan dashboard analitik, filter interaktif, serta laporan rekapitulasi untuk mendukung kebijakan pemerataan tenaga pendidik.

---

## 2. Hak Akses & Peran Pengguna (User Roles)

Sistem ini menerapkan *Role-Based Access Control* (RBAC) dengan 2 peran utama:

| Peran (Role) | Hak Akses & Cakupan Kerja |
| :--- | :--- |
| **Admin Dinas Pendidikan** | - Kelola Master Data (Daftar Sekolah, Jabatan, Jenis Guru, dll.)<br>- Akses Dashboard & Rekapitulasi seluruh sekolah.<br>- Multi-filtering & Pencarian Data Pegawai.<br>- Export Laporan Rekapitulasi (Excel & PDF).<br>- Verifikasi & Penguncian Data. |
| **Operator Sekolah** | - Login khusus per Satuan Pendidikan/Sekolah.<br>- Input, Edit, Hapus (CRUD) data pegawai internal sekolah.<br>- Upload berkas pendukung pegawai (SK, Ijazah, Serdik).<br>- Download rekapitulasi data internal sekolah. |

---

## 3. Spesifikasi 7 Kriteria & Struktur Data Utama

Setiap profil pegawai mencakup **7 kriteria wajib** sesuai kebutuhan pendataan Dinas Pendidikan:

| No | Kriteria / Parameter | Pilihan / Format Data | Tipe Data |
| :---: | :--- | :--- | :--- |
| **1** | **Status Kepegawaian** | PNS, PPPK, PPPK PW (Paruh Waktu), Non-ASN | Enum / Dropdown |
| **2** | **Jabatan Fungsional** | Guru Ahli Pertama, Guru Ahli Muda, Kepala Sekolah, Penilik, dll. | Dropdown / Text |
| **3** | **Sertifikasi Pendidik** | Serdik (Sudah Bersertifikasi) / Non-Serdik (Belum) | Boolean / Select |
| **4** | **Jenis PTK** | Pendidik (Guru) / Tenaga Kependidikan (TU, Laboran, dll.) | Dropdown |
| **5** | **Jenis Guru** | Guru Kelas, Guru Mata Pelajaran (Mapel), Guru BK, Guru Inklusi | Dropdown |
| **6** | **Tingkat Pendidikan** | SMA/K, D3, S1/D4, S2, S3 | Dropdown |
| **7** | **Usia / Tanggal Lahir** | Tanggal Lahir (Usia dihitung otomatis secara real-time) | Date (Auto-calc) |

---

## 4. Modul & Spesifikasi Fitur Sistem

### 4.1 Modul Otentikasi & Akun
- **Login Multi-Role:** Akses terpisah untuk Admin Dinas dan Operator Sekolah.
- **Reset Password:** Admin Dinas dapat mereset password akun Operator Sekolah jika lupa.

### 4.2 Modul Pengelolaan Data Pegawai (CRUD)
- **Form Input Pegawai:** Input identitas (NIP/NIK, Nama, Tempat/Tgl Lahir) + 7 Kriteria Utama.
- **Upload Berkas Pendukung:**
  - SK Kepegawaian (PDF, max 2 MB)
  - Sertifikat Pendidik (PDF, max 2 MB)
  - Ijazah Terakhir (PDF, max 2 MB)
- **Preview & Validasi Berkas:** Peninjauan dokumen terlampir secara langsung di web.

### 4.3 Modul Dashboard & Analitik
- **Summary Cards:** Total Pegawai, Total PNS, Total PPPK, Total Non-ASN, dan % Guru Serdik.
- **Grafik Rekapitulasi (Charts):**
  - Distribusi Status Kepegawaian per Kecamatan/Sekolah.
  - Sebaran Kelompok Usia (<30 thn, 31-40 thn, 41-50 thn, >55 thn menjelang pensiun).
  - Komposisi Tingkat Pendidikan.

### 4.4 Modul Pencarian & Filter Lanjutan
- **Pencarian Cepat:** Berdasarkan Nama, NIP/NIK, atau Nama Sekolah.
- **Multi-Filter Kombinasi:** Gabungan filter (contoh: *Non-ASN + S1 + Belum Serdik*).

### 4.5 Modul Laporan & Export Data
- **Export Excel (.xlsx):** Download data hasil filter atau seluruh master data pegawai.
- **Export PDF:** Cetak rekapitulasi statistik atau daftar ringkas pegawai ber-header resmi.

---

## 5. Alur Kerja Sistem (Workflow)

```
[Operator Sekolah] ---> Login ---> Input/Update Data + Upload Berkas ---> Simpan
                                                                             |
                                                                             v
[Sistem] -------------> Validasi Data & Perhitungan Usia Otomatis
                                                                             |
                                                                             v
[Database] -----------> Tersimpan
                                                                             |
                                                                             v
[Admin Dinas] --------> Login ---> Filter 7 Kriteria / Dashboard ---> Export Excel / PDF
```

---

## 6. Rancangan Struktur Basis Data (Database Schema)

```sql
-- Tabel Sekolah
CREATE TABLE sekolah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    npsn VARCHAR(10) UNIQUE NOT NULL,
    nama_sekolah VARCHAR(150) NOT NULL,
    alamat TEXT
);

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('ADMIN_DINAS', 'OPERATOR_SEKOLAH') NOT NULL,
    sekolah_id INT NULL,
    FOREIGN KEY (sekolah_id) REFERENCES sekolah(id) ON DELETE SET NULL
);

-- Tabel Pegawai
CREATE TABLE pegawai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sekolah_id INT NOT NULL,
    nip_nik VARCHAR(30) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(150) NOT NULL,
    status_kepegawaian ENUM('PNS', 'PPPK', 'PPPK PW', 'Non-ASN') NOT NULL,
    jabatan_fungsional VARCHAR(100),
    is_serdik BOOLEAN DEFAULT FALSE,
    jenis_ptk ENUM('Pendidik', 'Tenaga Kependidikan') NOT NULL,
    jenis_guru VARCHAR(100),
    tingkat_pendidikan ENUM('SMA/K', 'D3', 'S1/D4', 'S2', 'S3') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    file_sk VARCHAR(255),
    file_serdik VARCHAR(255),
    file_ijazah VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sekolah_id) REFERENCES sekolah(id) ON DELETE CASCADE
);
```

---

## 7. Tahapan Eksekusi Fitur (Task-Based Execution)

- [ ] **Modul 1:** Setup Database Schema & Auth Login (Admin / Operator).
- [ ] **Modul 2:** CRUD Data Pegawai & Upload Berkas (Form + Validation).
- [ ] **Modul 3:** Halaman Tabel Data & Filter Kombinasi 7 Kriteria.
- [ ] **Modul 4:** Halaman Dashboard Analitik & Visualisasi Grafik.
- [ ] **Modul 5:** Fitur Export Data (Excel & PDF).