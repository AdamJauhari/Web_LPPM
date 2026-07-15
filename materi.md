# MATERI PROYEK INTEGRATIF (PI)
## Sistem Informasi Manajemen LPPM Universitas Cendekia Abditama (UCA)

**Nama Mahasiswa :** Adam Arias Jauhari  
**NIM :** 2322105018  
**No. Absen :** 16  
**Kode Kelas :** 3TI01  
**Instansi :** Universitas Cendekia Abditama  
**Tanggal Dibuat :** 15 Juli 2026  

---

## 1. LATAR BELAKANG

Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) merupakan lembaga integral yang ada di setiap perguruan tinggi, termasuk Universitas Cendekia Abditama (UCA). LPPM bertugas sebagai pengelola dan koordinator seluruh kegiatan penelitian, pengabdian kepada masyarakat, dan publikasi ilmiah yang dilakukan oleh civitas akademika.

Sebelum adanya sistem ini, pengelolaan data di LPPM UCA masih dilakukan secara manual dan konvensional. Dosen yang ingin mengajukan proposal penelitian, PKM, atau mendaftarkan Hak Kekayaan Intelektual (HKI) harus melalui proses birokrasi yang panjang secara offline. Demikian pula dengan pencatatan luaran penelitian dan publikasi ilmiah yang belum terdigitalisasi.

**Masalah yang diidentifikasi:**
- Ketidakefisienan proses pengajuan proposal penelitian secara manual (tatap muka/surat fisik).
- Tidak adanya transparansi status pengajuan yang bisa dipantau dosen secara real-time.
- Sulitnya mengelola dan merekap data publikasi, luaran SINTA, dan rekam jejak kegiatan dosen.
- Informasi publik tentang LPPM (penelitian, pengabdian, kepakaran) yang belum terpublikasi digital.
- Tidak adanya dashboard terpusat bagi administrator untuk memantau seluruh aktivitas Tridharma dosen.

Maka dari itu, dibangunlah **Sistem Informasi Manajemen LPPM UCA** berbasis web yang mengintegrasikan portal publik, portal khusus dosen, dan panel administrasi dalam satu ekosistem aplikasi.

---

## 2. RUMUSAN MASALAH

1. Bagaimana merancang sistem informasi berbasis web yang dapat mengelola data LPPM UCA secara digital dan terpusat?
2. Bagaimana mengimplementasikan fitur pengajuan proposal penelitian, PKM, dan HKI secara online dengan mekanisme workflow yang terstruktur?
3. Bagaimana membangun portal khusus dosen yang memungkinkan mereka mencatat luaran Tridharma (publikasi SINTA) secara mandiri?
4. Bagaimana membangun panel administrasi yang aman dan efisien untuk administrator LPPM?
5. Bagaimana menyajikan informasi publik tentang kegiatan LPPM UCA secara menarik dan mudah diakses?

---

## 3. TUJUAN

1. **Membangun** sistem informasi manajemen LPPM UCA berbasis web menggunakan framework Laravel.
2. **Mengimplementasikan** modul pengajuan digital (Proposal Penelitian, PKM, HKI) dengan workflow status yang jelas.
3. **Menyediakan** portal dosen untuk manajemen luaran SINTA dengan verifikasi admin.
4. **Membangun** panel administrasi berbasis REST API dengan autentikasi token 12-digit.
5. **Mempublikasikan** informasi kegiatan penelitian, pengabdian, kepakaran, dan publikasi LPPM secara digital.

---

## 4. BATASAN MASALAH

- Sistem dibangun menggunakan **PHP 7.3/8.x** dengan **framework Laravel 8**.
- Database menggunakan **SQLite** (file-based), tidak memerlukan server database terpisah.
- Sinkronisasi SINTA dilakukan secara manual input oleh dosen (tidak terintegrasi langsung dengan API SINTA).
- Admin Panel adalah halaman HTML terpisah yang berkomunikasi dengan backend melalui REST API.
- Autentikasi admin panel menggunakan token 12-digit yang disimpan di file server.
- Fitur notifikasi email belum diaktifkan.

---

## 5. TEKNOLOGI YANG DIGUNAKAN

| Kategori | Teknologi | Keterangan |
|---|---|---|
| Backend Framework | Laravel 8 | PHP MVC Framework |
| Bahasa Pemrograman | PHP 7.3 / 8.x | Server-side scripting |
| Template Engine | Blade (Laravel) | Server-Side Rendering (SSR) |
| Database | SQLite | File-based RDBMS |
| ORM | Eloquent ORM | Laravel database abstraction |
| HTTP Client | Guzzle 7 | Untuk keperluan HTTP request |
| CORS Handler | fruitcake/laravel-cors | Menangani Cross-Origin Resource Sharing |
| Frontend Styling | Bootstrap (via CDN) | Komponen UI responsif |
| Asset Bundler | Laravel Mix (Webpack) | Kompilasi asset CSS/JS |
| Admin Panel | Vanilla HTML/CSS/JS | Antarmuka admin terpisah |
| Autentikasi | Laravel Auth + Token | Session-based + File token |
| Pengujian | PHPUnit 9 | Unit testing framework |
| Version Control | Git + GitHub | Manajemen versi kode |

### Dependensi Utama (composer.json)

```json
"require": {
    "php": "^7.3|^8.0",
    "fideloper/proxy": "^4.4",
    "fruitcake/laravel-cors": "^2.0",
    "guzzlehttp/guzzle": "^7.0.1",
    "laravel/framework": "^8.0",
    "laravel/tinker": "^2.5"
}
```

---

## 6. ARSITEKTUR SISTEM

### 6.1 Pola Arsitektur MVC

Sistem menggunakan pola **MVC (Model-View-Controller)** bawaan Laravel:

```
Browser -> Route (web.php) -> Controller -> Model (Eloquent) -> Database (SQLite)
                                  |
                                View (Blade Template) -> HTML Response
```

### 6.2 Tiga Lapisan Antarmuka

Sistem memiliki tiga lapisan antarmuka yang terintegrasi:

**1. Portal Publik** (`/`, `/penelitian`, `/pengabdian`, dll.)
- Diakses siapa saja tanpa login
- Menggunakan Blade Template (SSR)
- Menampilkan data dari tabel publik LPPM

**2. Portal Dosen** (`/dosen/*`)
- Memerlukan login dosen
- Dilindungi oleh Laravel Auth middleware
- CRUD luaran SINTA dan pengajuan proposal

**3. Admin Panel REST API** (`/api/admin/*`)
- Diakses melalui file `admin/index.html` (terpisah dari aplikasi utama)
- Autentikasi menggunakan token 12-digit via header `X-Admin-Token`
- Respons berformat JSON
- Dapat mengelola semua 21 tabel database

---

## 7. STRUKTUR DIREKTORI PROYEK

```
Web_LPPM/
|
|-- .env                          <- Konfigurasi environment (DB, Key, dll)
|-- .env.example                  <- Template konfigurasi
|-- composer.json                 <- Daftar dependensi PHP
|-- artisan                       <- CLI Laravel
|-- package.json                  <- Dependensi Node.js
|-- webpack.mix.js                <- Konfigurasi kompilasi asset
|-- phpunit.xml                   <- Konfigurasi unit testing
|-- setup_db.php                  <- Script setup database manual (14 KB)
|-- setup_admin.php               <- Script buat akun admin
|-- setup_org.php                 <- Script isi data organisasi
|-- jalankan.bat                  <- Shortcut jalankan server (Windows)
|-- CARA_MENJALANKAN.md           <- Panduan instalasi lengkap
|-- DFD.md                        <- Dokumentasi DFD Level 0, 1, 2
|-- admin.md                      <- Dokumentasi panel admin
|
|-- admin/                        <- Panel Admin (Standalone HTML App)
|   |-- index.html                <- Antarmuka utama admin panel
|   |-- app.js                    <- Logic JS REST API calls & UI (25 KB)
|   |-- style.css                 <- Styling panel admin
|   `-- admin_token.txt           <- Token autentikasi admin (12 digit)
|
|-- app/                          <- Logika Aplikasi Inti (Laravel)
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- AdminController.php          <- Dashboard admin SSR
|   |   |   |-- AdminApiController.php       <- REST API admin (286 baris)
|   |   |   |-- HomeController.php           <- Halaman beranda
|   |   |   |-- PenelitianController.php     <- CRUD berita penelitian
|   |   |   |-- PengabdianController.php     <- CRUD berita pengabdian
|   |   |   |-- PublikasiController.php      <- CRUD publikasi publik
|   |   |   |-- KepakaranController.php      <- CRUD kepakaran
|   |   |   |-- RisetController.php          <- Halaman produk riset
|   |   |   |-- SubmissionController.php     <- Pengajuan legacy
|   |   |   |-- DataPublikasiController.php  <- CRUD data publikasi dosen
|   |   |   |-- PelaksanaanController.php    <- CRUD data pelaksanaan
|   |   |   |-- Auth/
|   |   |   |   `-- RegisterDosenController.php  <- Registrasi dosen
|   |   |   `-- Dosen/
|   |   |       |-- LuaranSintaController.php    <- CRUD luaran SINTA (157 baris)
|   |   |       |-- PenelitianSubmissionController.php
|   |   |       |-- PkmSubmissionController.php
|   |   |       `-- HkiSubmissionController.php
|   |   |-- Middleware/
|   |   |   |-- Authenticate.php             <- Cek autentikasi user
|   |   |   |-- CheckRole.php                <- Cek role (admin_lppm, dosen, dll)
|   |   |   |-- RedirectIfAuthenticated.php  <- Redirect jika sudah login
|   |   |   |-- VerifyCsrfToken.php          <- Proteksi CSRF
|   |   |   `-- ... (middleware standar Laravel)
|   |   `-- Kernel.php                       <- Registrasi middleware
|   |
|   |-- User.php                  <- Model pengguna (semua role)
|   |-- Publikasi.php             <- Model luaran SINTA dosen
|   |-- Pelaksanaan.php           <- Model rekam kegiatan dosen
|   |-- ResearchSubmission.php    <- Model ajuan proposal penelitian
|   |-- PkmSubmission.php         <- Model ajuan PKM
|   |-- HkiSubmission.php         <- Model ajuan HKI
|   |-- Penelitian.php            <- Model data penelitian formal
|   |-- PengajuanProposal.php     <- Model pengajuan proposal formal
|   |-- VerifikasiPenelitian.php  <- Model verifikasi penelitian
|   |-- Researche.php             <- Model berita penelitian publik
|   |-- CommunityService.php      <- Model berita pengabdian publik
|   |-- Publication.php           <- Model publikasi publik
|   |-- Expertise.php             <- Model kepakaran
|   |-- Dosen.php                 <- Model data master dosen
|   |-- Fakultas.php              <- Model data master fakultas
|   |-- Prodi.php                 <- Model data master prodi
|   |-- LaporanSidang.php         <- Model laporan sidang
|   |-- LaporanJurnal.php         <- Model laporan jurnal
|   `-- HkiModel.php              <- Model HKI formal
|
|-- database/
|   |-- database.sqlite           <- File database SQLite (utama)
|   |-- migrations/               <- 29 file migration (skema tabel)
|   |-- seeds/                    <- Seeder data awal
|   `-- factories/                <- Factory untuk testing
|
|-- resources/
|   |-- views/                    <- Blade template (view layer)
|   |   |-- index.blade.php                 <- Beranda publik (18 KB)
|   |   |-- tentang.blade.php               <- Tentang LPPM (17 KB)
|   |   |-- forkomil-dan-conferences.blade.php
|   |   |-- paten.blade.php
|   |   |-- hakcipta.blade.php
|   |   |-- layout/                         <- Master layout
|   |   |-- admin/                          <- 13 view admin SSR
|   |   |   |-- index.blade.php             <- Dashboard admin
|   |   |   |-- login.blade.php             <- Form login
|   |   |   |-- adm_penelitian.blade.php
|   |   |   |-- adm_pengabdian.blade.php
|   |   |   |-- adm_publikasi.blade.php
|   |   |   |-- adm_kepakaran.blade.php
|   |   |   |-- adm_kelola_publikasi.blade.php
|   |   |   |-- adm_kelola_pelaksanaan.blade.php
|   |   |   `-- ... (form create/edit)
|   |   |-- auth/
|   |   |   `-- register_dosen.blade.php    <- Form registrasi dosen
|   |   |-- dosen/                          <- Portal Dosen (4 sub-folder)
|   |   |   |-- luaran-sinta/
|   |   |   |-- penelitian/
|   |   |   |-- pkm/
|   |   |   `-- hki/
|   |   |-- submissions/
|   |   |   |-- research.blade.php
|   |   |   |-- journal.blade.php
|   |   |   |-- status.blade.php
|   |   |   `-- jurnal-saya.blade.php
|   |   `-- ... (8 folder view lainnya)
|   |-- js/                       <- JavaScript sumber
|   |-- sass/                     <- SCSS sumber
|   `-- lang/                     <- File bahasa
|
|-- routes/
|   |-- web.php                   <- Semua route web (221 baris)
|   |-- api.php                   <- Route API
|   |-- console.php               <- Route artisan
|   `-- channels.php              <- Route broadcasting
|
|-- public/                       <- Web root (document root)
|   |-- index.php                 <- Entry point Laravel
|   |-- .htaccess                 <- Konfigurasi Apache
|   |-- css/                      <- CSS dikompilasi
|   |-- js/                       <- JS dikompilasi
|   |-- img/                      <- Gambar (penelitian, pengabdian, org)
|   |-- fonts/                    <- Font kustom
|   |-- download/                 <- File PDF yang dapat diunduh
|   |-- uploads/                  <- Upload dari pengguna
|   `-- vendors/                  <- Library frontend pihak ketiga
|
|-- config/                       <- Konfigurasi Laravel
|-- storage/                      <- Storage (log, cache, session, token)
|-- bootstrap/                    <- Bootstrap aplikasi
|-- tests/                        <- Unit & Feature test
`-- vendor/                       <- Dependensi Composer
```

---

## 8. SKEMA DATABASE (21 Tabel)

Sistem memiliki **29 file migration** yang menghasilkan **21 tabel aktif**, terbagi dalam 4 kelompok:

### 8.1 Tabel Akun Pengguna

#### Tabel `users` — Data Akun Semua Pengguna

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key auto increment |
| name | VARCHAR(255) | Nama lengkap pengguna |
| username | VARCHAR(50) | Username unik |
| email | VARCHAR(255) UNIQUE | Email untuk login |
| password | VARCHAR(255) | Password di-hash bcrypt |
| role | VARCHAR | admin, admin_lppm, admin_uppm, dosen, mahasiswa |
| nim_nip | VARCHAR(20) | NIM atau NIP |
| nidn | VARCHAR(20) | NIDN (khusus dosen) |
| fakultas | VARCHAR(100) | Asal fakultas |
| jabatan_fungsional | VARCHAR(100) | Jabatan fungsional dosen |
| email_verified_at | TIMESTAMP | Waktu verifikasi email |
| remember_token | VARCHAR(100) | Token "ingat saya" |
| created_at, updated_at | TIMESTAMP | Timestamp otomatis |

### 8.2 Tabel Data Publik LPPM

#### Tabel `researches` — Berita Penelitian Publik

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| title | VARCHAR(255) | Judul artikel penelitian |
| slug | VARCHAR(255) UNIQUE | Slug untuk URL friendly |
| description | TEXT | Konten artikel (HTML/teks) |
| date | DATE | Tanggal publikasi |
| thumbnail | VARCHAR(255) | Path file gambar thumbnail |

#### Tabel `community_services` — Berita Pengabdian Publik

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| title | VARCHAR(255) | Judul pengabdian |
| slug | VARCHAR(255) | Slug URL |
| description | TEXT | Konten artikel |
| date | DATE | Tanggal kegiatan |
| thumbnail | VARCHAR(255) | Path gambar |

#### Tabel `publications` — Publikasi LPPM

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| title | VARCHAR(255) | Judul publikasi |
| author | VARCHAR(255) | Nama penulis |
| date | DATE | Tanggal terbit |
| file | VARCHAR(255) | Path file PDF yang bisa diunduh |
| doi | VARCHAR(255) | Digital Object Identifier |
| url | VARCHAR(255) | URL eksternal |

#### Tabel `expertises` — Kelompok Kepakaran

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| name | VARCHAR(255) | Nama kelompok kepakaran |
| description | TEXT | Deskripsi kepakaran |

#### Tabel `organization_members` — Struktur Organisasi LPPM

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| name | VARCHAR(255) | Nama anggota |
| position | VARCHAR(255) | Jabatan dalam organisasi |
| photo | VARCHAR(255) | Path foto profil |
| sort_order | INT | Urutan tampil di halaman |

### 8.3 Tabel Data Luaran Dosen

#### Tabel `publikasis` — Luaran SINTA Dosen

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Relasi ke tabel users |
| judul | VARCHAR(255) | Judul artikel/buku/HKI |
| abstrak | TEXT | Abstrak karya ilmiah |
| jenis_publikasi | ENUM | Jurnal, Prosiding, Buku, HKI |
| kategori_reputasi | VARCHAR(255) | Scopus Q1-Q4, Sinta S1-S6, dll |
| tahun_publikasi | YEAR | Tahun terbit |
| nama_jurnal | VARCHAR(255) | Nama jurnal atau prosiding |
| volume_edisi | VARCHAR(100) | Volume dan edisi jurnal |
| doi | VARCHAR(255) | DOI artikel |
| sinta_id | VARCHAR(100) | ID di database SINTA |
| scopus_id | VARCHAR(100) | ID di Scopus |
| garuda_id | VARCHAR(100) | ID di Garuda |
| url_jurnal | VARCHAR(255) | URL halaman jurnal |
| url_repository | VARCHAR(255) | URL repositori institusi |
| sumber | VARCHAR(50) | manual atau sinkronisasi |
| status_verifikasi | ENUM | pending, verified, rejected |
| catatan_admin | TEXT | Catatan/feedback dari admin |
| verified_by | BIGINT FK | User admin yang memverifikasi |
| verified_at | TIMESTAMP | Waktu verifikasi |

**Konstanta KATEGORI_LUARAN yang tersedia:**
- Scopus Q1, Q2, Q3, Q4
- Sinta S1, S2, S3, S4, S5, S6
- Non-Sinta
- Prosiding Internasional
- Prosiding Nasional
- HKI - Paten
- HKI - Hak Cipta (HAKI)

#### Tabel `pelaksanaans` — Rekam Jejak Kegiatan Dosen

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Relasi ke users |
| jenis_kegiatan | ENUM | Penelitian, Pengabdian |
| judul | VARCHAR(255) | Judul kegiatan |
| deskripsi_singkat | TEXT | Deskripsi kegiatan |
| sumber_dana | VARCHAR(255) | Sumber pendanaan |
| url | VARCHAR(255) | Tautan referensi |

### 8.4 Tabel Pengajuan (Submission)

#### Tabel `research_submissions` — Ajuan Proposal Penelitian

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Dosen pengaju |
| title | VARCHAR(255) | Judul penelitian |
| abstract | TEXT | Abstrak proposal |
| research_type | VARCHAR(100) | Jenis penelitian |
| team_members | VARCHAR(500) | Anggota tim peneliti |
| fakultas | VARCHAR(10) | Kode fakultas |
| semester | VARCHAR(10) | Ganjil atau Genap |
| tahun | YEAR | Tahun pengajuan |
| sumber_dana | VARCHAR(20) | Internal atau Eksternal |
| total_dana | DECIMAL(15,0) | Total anggaran (Rupiah) |
| kategori_luaran | VARCHAR(255) | Target luaran penelitian |
| status | ENUM | pending, assigned, under_review, approved, rejected |
| admin_notes | TEXT | Catatan dari admin |
| rejection_reason | TEXT | Alasan penolakan |
| assigned_to | BIGINT FK | Reviewer yang ditugaskan |
| reviewed_by | BIGINT FK | Yang melakukan review |
| reviewed_at | TIMESTAMP | Waktu review selesai |

#### Tabel `pkm_submissions` — Ajuan PKM

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Dosen pengaju |
| judul | VARCHAR(255) | Judul PKM |
| abstrak | TEXT | Abstrak proposal |
| sumber_dana | VARCHAR(20) | Internal atau Eksternal |
| total_dana | DECIMAL(15,0) | Total anggaran |
| pelaksanaan | TEXT | Deskripsi rencana pelaksanaan |
| luaran_jurnal | VARCHAR(100) | Target jurnal luaran |
| sumber_dana_eksternal | VARCHAR(255) | Nama sumber dana eksternal |
| team_members | VARCHAR(500) | Anggota tim |
| status | ENUM | pending, assigned, under_review, approved, rejected |

#### Tabel `hki_submissions` — Ajuan Hak Kekayaan Intelektual

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Dosen pengaju |
| judul | VARCHAR(255) | Judul karya/invensi |
| abstrak | TEXT | Deskripsi karya |
| jenis_hki | ENUM | Paten, HAKI, Non-Scopus / Hak Cipta Lainnya |
| tahun_pengajuan | YEAR | Tahun pengajuan |
| tanggal_pengajuan | DATE | Tanggal pengajuan |
| nomor_pendaftaran | VARCHAR(100) | Nomor pendaftaran HKI resmi |
| team_members | VARCHAR(500) | Anggota tim |
| status | ENUM | pending, assigned, under_review, approved, rejected |

### 8.5 Tabel Master Institusi (ERD LPPM Formal)

#### Tabel `fakultas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| nama_fakultas | VARCHAR(100) | Nama fakultas |
| nama_dekan | VARCHAR(100) | Nama dekan saat ini |

#### Tabel `prodi`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| nama_prodi | VARCHAR(100) | Nama program studi |
| id_fakultas | BIGINT FK | Relasi ke tabel fakultas |
| jenjang | VARCHAR(10) | D3, S1, S2, atau S3 |
| nama_kaprodi | VARCHAR(100) | Nama kepala program studi |

#### Tabel `dosen` — Master Data Dosen

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT PK | Primary key |
| user_id | BIGINT FK | Relasi ke users (nullable) |
| nama_dosen | VARCHAR(100) | Nama lengkap dosen |
| nidn | VARCHAR(20) | Nomor Induk Dosen Nasional |
| nupk | VARCHAR(20) | Nomor Unik Pendidik |
| pangkat_jabatan | VARCHAR(100) | Pangkat dan jabatan fungsional |
| id_prodi | BIGINT FK | Relasi ke tabel prodi |
| dosen_luaran | TEXT | Daftar luaran/karya dosen |
| no_hp | VARCHAR(20) | Nomor handphone |
| sk_dosen | VARCHAR(255) | Nomor atau path file SK Dosen |

### 8.6 Tabel Transaksi LPPM Formal

| Tabel | Fungsi |
|---|---|
| penelitian | Data penelitian formal dosen yang sudah diverifikasi |
| pengajuan_proposal | Pengajuan proposal formal dengan mekanisme reviewer |
| verifikasi_penelitian | Catatan verifikasi dan review dari setiap pengajuan |
| hki | Data HKI formal yang sudah terdaftar resmi |
| laporan_sidang | Data pelaporan kemajuan penelitian dan sidang |
| laporan_jurnal | Data luaran laporan jurnal formal |

---

## 9. DIAGRAM ALIR DATA (DFD)

### 9.1 DFD Level 0 — Context Diagram

**Entitas Eksternal:**
1. Pengunjung (Mahasiswa/Masyarakat Umum)
2. Dosen (Pengguna Terdaftar)
3. Administrator (Admin LPPM)

**Aliran Data:**

```
PENGUNJUNG  --(Permintaan akses info publik)--> [SISTEM INFORMASI LPPM UCA]
            <--(Informasi Penelitian, Pengabdian, Publikasi, Kepakaran)---

DOSEN       --(Registrasi, Login, Ajuan Proposal, Input Luaran SINTA)--> [SISTEM]
            <--(Status Ajuan, Portal Dosen, Histori Publikasi)---

ADMIN       --(Token Login, CRUD Data, Verifikasi Ajuan)--> [SISTEM]
            <--(Dashboard Statistik, Rekapitulasi Data, JSON Response)---
```

### 9.2 DFD Level 1 — Dekomposisi Proses

| No | Proses | Entitas | Deskripsi |
|---|---|---|---|
| 1.0 | Autentikasi & Pendaftaran | Dosen, Admin | Registrasi, login web, login token API |
| 2.0 | Layanan Informasi Publik | Pengunjung | Tampilkan penelitian, pengabdian, kepakaran, publikasi |
| 3.0 | Layanan Pengajuan Dosen | Dosen | Kirim proposal penelitian, PKM, HKI |
| 4.0 | Pengelolaan Luaran Tridharma | Dosen, Admin | Input luaran SINTA, kelola pelaksanaan |
| 5.0 | Administrasi & Verifikasi | Admin | CRUD semua tabel, verifikasi ajuan, kelola master |

---

## 10. FITUR-FITUR SISTEM

### 10.1 Portal Publik (Tanpa Login)

| No | Fitur | Route | Keterangan |
|---|---|---|---|
| 1 | Beranda | / | Halaman utama dengan statistik dan highlight |
| 2 | Tentang LPPM | /tentang | Profil dan struktur organisasi LPPM |
| 3 | Berita Penelitian | /penelitian | Daftar dan detail berita penelitian |
| 4 | Berita Pengabdian | /pengabdian | Daftar dan detail berita pengabdian |
| 5 | Produk Riset | /riset | Katalog produk riset LPPM |
| 6 | Kepakaran | /kepakaran | Kelompok kepakaran dosen |
| 7 | Publikasi | /publikasi | Daftar publikasi dengan unduh PDF |
| 8 | Forkomil & Conferences | /forkomil-dan-conferences | Info forum ilmiah |
| 9 | Paten | /paten | Informasi paten |
| 10 | Hak Cipta | /hakcipta | Informasi hak cipta |

### 10.2 Portal Dosen (Memerlukan Login)

| No | Fitur | Route | Keterangan |
|---|---|---|---|
| 1 | Registrasi Dosen | /daftar-dosen | Form pendaftaran akun khusus dosen |
| 2 | Login | /login | Autentikasi email dan password |
| 3 | Dashboard Dosen | /dosen/dashboard | Redirect ke Luaran SINTA |
| 4 | Luaran SINTA | /dosen/luaran-sinta | CRUD luaran publikasi dosen |
| 5 | Buat Luaran | /dosen/luaran-sinta/create | Form input luaran baru |
| 6 | Ajuan Penelitian | /dosen/penelitian | Form pengajuan proposal penelitian |
| 7 | Ajuan PKM | /dosen/pkm | Form pengajuan Program Kreativitas |
| 8 | Ajuan HKI | /dosen/hki | Form pengajuan Hak Kekayaan Intelektual |
| 9 | Status Peninjauan | /status-peninjauan | Pantau status semua pengajuan |

### 10.3 Admin Panel REST API

| No | Endpoint | Method | Fungsi |
|---|---|---|---|
| 1 | /api/admin/verify | POST | Verifikasi token admin |
| 2 | /api/admin/stats | GET | Dashboard statistik semua 21 tabel |
| 3 | /api/admin/list/{table} | GET | Daftar data dengan fitur pencarian |
| 4 | /api/admin/show/{table}/{id} | GET | Detail satu record |
| 5 | /api/admin/store/{table} | POST | Buat data baru |
| 6 | /api/admin/update/{table}/{id} | PUT | Update data |
| 7 | /api/admin/delete/{table}/{id} | DELETE | Hapus data |
| 8 | /api/admin/upload-photo | POST | Upload foto anggota organisasi |
| 9 | /api/admin/upload-file | POST | Upload file penelitian/pengabdian/publikasi |

---

## 11. ALUR KERJA (WORKFLOW) SISTEM

### 11.1 Alur Registrasi dan Login Dosen

```
[Dosen] -> [Akses /daftar-dosen]
         -> [Isi Form: Nama, Email, Password, NIDN, Fakultas, Jabatan]
         -> [POST /daftar-dosen -> RegisterDosenController@register]
         -> [Data disimpan ke tabel 'users' dengan role='dosen']
         -> [Redirect ke /login]
         -> [POST /login/checklogin -> AdminController@checklogin]
         -> [Auth::attempt() berhasil -> Cek role='dosen']
         -> [Redirect ke / (beranda) dengan akses menu Portal Dosen]
```

### 11.2 Alur Pengajuan Proposal

```
[Dosen Login]
  -> [Akses /dosen/penelitian/create]
  -> [Isi Formulir: Judul, Abstrak, Tim, Dana, Luaran, dll]
  -> [POST -> PenelitianSubmissionController@store]
  -> [Data tersimpan di 'research_submissions' dengan status='pending']

  [Admin via Panel]
  -> [Lihat daftar ajuan di tabel research_submissions]
  -> [Assign reviewer -> status berubah menjadi 'assigned']
  -> [Reviewer mulai review -> status: 'under_review']
  -> [Keputusan: status='approved' atau status='rejected']

  [Dosen]
  -> [Pantau di /status-peninjauan]
  -> [Lihat status terkini ajuan]
```

**Status Lifecycle Pengajuan:**
```
pending -> assigned -> under_review -> approved
                                    -> rejected
```

### 11.3 Alur Input dan Verifikasi Luaran SINTA

```
[Dosen Login]
  -> [Akses /dosen/luaran-sinta/create]
  -> [Isi Form: Judul, Abstrak, Jenis, Kategori Reputasi, Tahun, DOI, dll]
  -> [POST -> LuaranSintaController@store]
  -> [Tersimpan: sumber='manual', status_verifikasi='pending']

  [Admin via Panel]
  -> [Akses tabel 'publikasis' di Admin Panel]
  -> [Verifikasi data luaran dosen]
  -> [Status: 'verified' atau 'rejected', + catatan_admin]

  [Peraturan Sistem]
  -> Luaran dengan status 'verified' TIDAK DAPAT diedit atau dihapus oleh dosen
  -> Hanya luaran berstatus 'pending' yang bisa dimodifikasi
```

### 11.4 Alur Login Admin Panel (Token-Based)

```
[Admin]
  -> [Buka file admin/index.html di browser]
  -> [Input: Server URL = http://127.0.0.1:8000]
  -> [Input: Token 12 digit = 3OE2HLI35RBY]
  -> [app.js: POST /api/admin/verify]
       Header: X-Admin-Token: 3OE2HLI35RBY
  -> [AdminApiController::verifyToken()]
  -> [Baca file: storage/app/admin_token.txt]
  -> [Bandingkan token: cocok -> {status:'ok'}]
  -> [Admin Panel terbuka]
  -> [GET /api/admin/stats -> Dashboard statistik semua tabel]
  -> [Admin dapat CRUD semua 21 tabel melalui antarmuka]
```

---

## 12. KEAMANAN SISTEM

### 12.1 Mekanisme Autentikasi

| Layer | Mekanisme | Keterangan |
|---|---|---|
| Portal Dosen | Laravel Auth (session) | Auth::attempt(), CSRF token |
| Admin Panel | Token file 12-digit | Header X-Admin-Token, stateless |
| CSRF | VerifyCsrfToken middleware | Semua POST/PUT/DELETE dilindungi |

### 12.2 Role-Based Access Control (RBAC)

```php
// File: app/Http/Middleware/CheckRole.php
// Cara penggunaan di route:
->middleware('role:admin_lppm,admin_uppm')

// Definisi role di User.php:
isAdminLppm()  -> role === 'admin_lppm'  (Admin LPPM Pusat)
isAdminUppm()  -> role === 'admin_uppm'  (Admin UPPM Fakultas)
isDosen()      -> role === 'dosen'        (Portal Dosen)
isAdmin()      -> in_array(role, ['admin_lppm', 'admin_uppm'])
```

### 12.3 Proteksi Data

1. Password di-hash menggunakan **bcrypt** via `Hash::make()`
2. Kolom `password` dan `remember_token` tersembunyi di model User (property `$hidden`)
3. Admin via form web login diarahkan ke panel terpisah (tidak boleh login via form dosen)
4. Semua endpoint Admin API memvalidasi token sebelum mengeksekusi operasi apapun
5. Slug URL di-generate otomatis untuk mencegah URL manipulation

---

## 13. CARA MENJALANKAN APLIKASI

### 13.1 Prasyarat

| Software | Versi Minimum | Keterangan |
|---|---|---|
| PHP | 7.3 atau 8.x | Ekstensi: sqlite3, mbstring, xml, curl, zip |
| Composer | 2.x | Package manager PHP |
| XAMPP (Windows) | Opsional | Sudah termasuk PHP 8.x |

### 13.2 Langkah Instalasi (Windows)

**Langkah 1 — Buat File `.env`**
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:1Umdmb5rBNiZ3UzvuKKiihUODaRivg9bpFM9pWQnjok=
APP_DEBUG=true
APP_URL=http://localhost
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
LOG_CHANNEL=stack
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

**Langkah 2 — Install Dependensi**
```bash
composer install
```

**Langkah 3 — Setup Database**
```bash
# Buat file database SQLite
php -r "touch('database/database.sqlite');"

# Buat semua tabel (29 tabel)
php setup_db.php

# Isi data struktur organisasi LPPM
php setup_org.php

# Buat akun admin bawaan
php setup_admin.php
```

**Langkah 4 — Jalankan Server**
```bash
php artisan serve
# Atau klik dua kali file: jalankan.bat
```

**Akses di:** `http://127.0.0.1:8000`

### 13.3 Akun Bawaan Sistem

| Role | Credentials | Cara Akses |
|---|---|---|
| Admin Web (SSR) | admin@uca.ac.id / admin123 | Login di /login |
| Admin Panel (API) | Token: 3OE2HLI35RBY | Buka admin/index.html |
| Dosen | Daftar sendiri di /daftar-dosen | Login di /login |

### 13.4 URL Akses Semua Modul

| Antarmuka | URL |
|---|---|
| Portal Publik | http://127.0.0.1:8000 |
| Login | http://127.0.0.1:8000/login |
| Registrasi Dosen | http://127.0.0.1:8000/daftar-dosen |
| Luaran SINTA Dosen | http://127.0.0.1:8000/dosen/luaran-sinta |
| Ajuan Penelitian | http://127.0.0.1:8000/dosen/penelitian/create |
| Ajuan PKM | http://127.0.0.1:8000/dosen/pkm/create |
| Ajuan HKI | http://127.0.0.1:8000/dosen/hki/create |
| Status Pengajuan | http://127.0.0.1:8000/status-peninjauan |
| Dashboard Admin SSR | http://127.0.0.1:8000/admin/successlogin |
| Admin Panel API | Buka file admin/index.html di browser |

---

## 14. PENJELASAN FILE-FILE PENTING

### `setup_db.php` (14 KB)
Script PHP mandiri (tanpa framework) yang membuat seluruh 29+ tabel database SQLite. Merupakan alternatif dari `php artisan migrate` untuk kemudahan deployment tanpa konfigurasi framework tambahan.

### `admin/app.js` (25 KB)
File JavaScript inti Admin Panel berisi:
- Fungsi autentikasi token (verifyToken, saveToken)
- Fungsi CRUD generik yang bekerja untuk semua 21 tabel
- Fungsi render tabel dinamis berdasarkan respons JSON
- Fungsi upload file dan foto ke direktori public/
- Semua UI interaction handler (murni Vanilla JS, tanpa framework)

### `routes/web.php` (221 baris)
Mendefinisikan seluruh URL route aplikasi:
- Route publik (tanpa auth middleware)
- Route dengan `middleware('auth')` untuk dosen
- Route API admin dengan prefix `/api/admin`
- Route CRUD lengkap untuk semua modul

### `app/Http/Controllers/AdminApiController.php` (286 baris)
Controller REST API yang melayani Admin Panel. Pola kerja:
1. Setiap method memanggil `verifyToken()`
2. Token dibaca dari `storage/app/admin_token.txt`
3. Jika cocok, eksekusi operasi database
4. Kembalikan respons JSON

### `app/Publikasi.php` — Model Luaran SINTA
Model Eloquent dengan relasi `belongsTo User` (dosen dan verifier), konstanta `KATEGORI_LUARAN` (Scopus Q1-Q4, Sinta S1-S6, dll), dan scope `pending()` / `verified()` untuk filter query.

### `app/ResearchSubmission.php` — Model Ajuan Penelitian
Model dengan 5 status lifecycle, konstanta `SUMBER_DANA` dan `SEMESTER`, serta accessor `getStatusLabelAttribute()` dan `getStatusBadgeAttribute()` untuk tampilan badge status.

---

## 15. RELASI ANTAR MODEL (Eloquent Relationships)

```
User (tabel: users)
  |-- hasMany --> Publikasi         (luaran SINTA milik dosen)
  |-- hasMany --> Pelaksanaan       (riwayat kegiatan dosen)
  `-- hasMany --> Dosen             (data master dosen)

Publikasi (tabel: publikasis)
  |-- belongsTo --> User            (dosen pemilik, FK: user_id)
  `-- belongsTo --> User            (admin verifier, FK: verified_by)

ResearchSubmission (tabel: research_submissions)
  |-- belongsTo --> User            (pengaju, FK: user_id)
  |-- belongsTo --> User            (penugasan, FK: assigned_to)
  `-- belongsTo --> User            (reviewer, FK: reviewed_by)

PkmSubmission (tabel: pkm_submissions)
  |-- belongsTo --> User            (pengaju, FK: user_id)
  |-- belongsTo --> User            (penugasan, FK: assigned_to)
  `-- belongsTo --> User            (reviewer, FK: reviewed_by)

HkiSubmission (tabel: hki_submissions)
  |-- belongsTo --> User            (pengaju, FK: user_id)
  |-- belongsTo --> User            (penugasan, FK: assigned_to)
  `-- belongsTo --> User            (reviewer, FK: reviewed_by)

Dosen (tabel: dosen)
  |-- belongsTo --> User            (akun dosen, FK: user_id)
  `-- belongsTo --> Prodi           (FK: id_prodi)

Prodi (tabel: prodi)
  `-- belongsTo --> Fakultas        (FK: id_fakultas)
```

---

## 16. ANALISIS KELEBIHAN DAN KEKURANGAN

### 16.1 Kelebihan Sistem

| No | Kelebihan | Detail |
|---|---|---|
| 1 | Ringan dan Mudah Dideploy | SQLite tidak butuh server database terpisah |
| 2 | Arsitektur Dual-Interface | Portal SSR untuk dosen + Admin Panel API standalone |
| 3 | Workflow Terstruktur | 5 tahap status pengajuan yang jelas |
| 4 | Data Komprehensif | 21 tabel mencakup seluruh aspek pengelolaan LPPM |
| 5 | Role-Based Access | Sistem hak akses berlapis untuk berbagai jenis pengguna |
| 6 | Verifikasi Luaran | Luaran terverifikasi tidak bisa diedit sembarang pihak |
| 7 | Admin Panel Generik | Satu panel dapat mengelola semua tabel tanpa kode tambahan |
| 8 | Dokumentasi Lengkap | DFD.md, CARA_MENJALANKAN.md, admin.md tersedia |

### 16.2 Kekurangan dan Saran Pengembangan

| No | Kekurangan | Saran Pengembangan |
|---|---|---|
| 1 | SQLite kurang cocok multi-user serentak banyak | Migrasi ke MySQL atau PostgreSQL |
| 2 | Admin Panel tanpa framework JS modern | Gunakan Vue.js atau React untuk SPA yang lebih baik |
| 3 | Tidak ada notifikasi email otomatis | Implementasi Laravel Notification + konfigurasi SMTP |
| 4 | Sinkronisasi SINTA masih manual input | Integrasi dengan API SINTA resmi |
| 5 | Belum ada ekspor data (Excel/PDF) | Tambahkan library maatwebsite/excel atau dompdf |
| 6 | Token admin disimpan di file teks | Ganti dengan Laravel Sanctum atau Passport |
| 7 | Belum ada fitur pencarian global | Implementasi Laravel Scout |
| 8 | Belum ada notifikasi in-app real-time | Tambahkan Pusher atau Laravel Echo |

---

## 17. KONTRIBUSI TIM

Proyek ini dikerjakan dalam kerangka **Proyek Integratif (PI) Kelompok 7**, di bawah bimbingan dosen pengampu (Pak Pungky), pada Program Studi Teknik Informatika Universitas Cendekia Abditama.

- **Repository GitHub:** https://github.com/AdamJauhari/Web_LPPM
- **Clone Repository:** `git clone https://github.com/AdamJauhari/Web_LPPM.git`

---

## 18. PENUTUP

Sistem Informasi Manajemen LPPM UCA berhasil mengimplementasikan solusi digital terintegrasi yang mencakup:

- **Portal Informasi Publik** — Menyajikan data LPPM yang dapat diakses siapa saja tanpa login
- **Portal Dosen Terautentikasi** — Manajemen luaran SINTA dan pengajuan proposal dengan middleware keamanan berlapis
- **Sistem Pengajuan Digital** — Workflow pengajuan Penelitian, PKM, dan HKI dengan 5 tahap status terstruktur
- **Admin Panel Mandiri** — Pengelolaan 21 tabel via REST API dengan keamanan token 12-digit
- **Basis Data Komprehensif** — 21 tabel yang mencakup seluruh aspek pengelolaan LPPM dari data publik hingga transaksi formal

Sistem dibangun menggunakan **Laravel 8** sebagai fondasi backend, **SQLite** sebagai basis data ringan, **Blade Template** untuk rendering sisi server, dan antarmuka admin berbasis **HTML/JavaScript murni** yang terkoneksi melalui **REST API** — menjadikan proyek ini sebagai implementasi nyata konsep *full-stack web development* dalam konteks institusi pendidikan tinggi.

---

*Dokumen ini dibuat berdasarkan analisis menyeluruh seluruh kode sumber proyek Web_LPPM.*
*Program Studi Teknik Informatika — Universitas Cendekia Abditama — 2026*
