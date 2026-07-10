# Data Flow Diagram (DFD) - Sistem Informasi Manajemen LPPM UCA

Berikut adalah rancangan struktural Diagram Aliran Data (DFD) Level 0, Level 1, dan Level 2 berdasarkan analisis menyeluruh pada direktori dan *source code* `Web_LPPM` (mencakup *Front-end*, Portal Dosen, hingga Panel Admin terpisah). Gunakan teks ini sebagai *prompt* atau instruksi kepada AI pembuat diagram grafis.

---

## 1. DFD Level 0 (Context Diagram)

**Entitas Eksternal (External Entities):**
1. **Pengunjung (Mahasiswa/Masyarakat Umum)**
2. **Dosen (Pengguna Terdaftar)**
3. **Administrator (Admin LPPM)**

**Proses Utama (System):**
- **0. Sistem Informasi LPPM UCA**

**Aliran Data (Data Flows):**
- **Pengunjung** -> (Permintaan akses info publik) -> **Sistem**
- **Sistem** -> (Informasi Penelitian, Pengabdian, Publikasi, Organisasi, Kepakaran) -> **Pengunjung**
- **Dosen** -> (Data Registrasi, Kredensial Login, Ajuan Proposal Penelitian/PKM/HKI/Jurnal, Data Luaran SINTA) -> **Sistem**
- **Sistem** -> (Status Ajuan, Histori Publikasi/Pelaksanaan, Akses Portal Dosen) -> **Dosen**
- **Admin** -> (Token Login, Input/Edit Master Data Publik, Verifikasi Ajuan, Kelola Data Dosen) -> **Sistem**
- **Sistem** -> (Dashboard Statistik, Notifikasi Ajuan Masuk, Rekapitulasi Data Master) -> **Admin**

---

## 2. DFD Level 1 (Dekomposisi Proses Utama)

Terdapat 5 proses operasional utama di dalam sistem:

### Proses 1.0: Autentikasi dan Pendaftaran
- **Entitas:** Dosen, Admin
- **Aliran:** 
  - Dosen mengirim Form Registrasi -> Sistem menyimpan ke *Data Store `users`*.
  - Dosen mengirim Email/Password -> Sistem mencocokkan ke *Data Store `users`*.
  - Admin memasukkan *Security Token* -> API memeriksa akses di server -> Otorisasi API diberikan.

### Proses 2.0: Layanan Informasi Publik
- **Entitas:** Pengunjung
- **Aliran:**
  - Pengunjung mengakses rute publik.
  - Proses membaca data dari *Data Store*: `researches`, `community_services`, `publications`, `organization_members`, `expertises`.
  - Proses mengembalikan *View HTML* yang sesuai.

### Proses 3.0: Layanan Pengajuan (Submission) Dosen
- **Entitas:** Dosen
- **Aliran:**
  - Dosen mengisi formulir ajuan via Portal Dosen.
  - Proses menyimpan proposal penelitian ke *Data Store `research_submissions`*.
  - Proses menyimpan ajuan PKM ke *Data Store `pkm_submissions`*.
  - Proses menyimpan ajuan HKI ke *Data Store `hki_submissions`*.
  - Proses menyimpan ajuan Jurnal ke *Data Store `journal_submissions`*.

### Proses 4.0: Pengelolaan Luaran Tridharma (Dosen & Admin)
- **Entitas:** Dosen, Admin
- **Aliran:**
  - Dosen mengunggah/sinkronisasi Luaran SINTA -> Proses menyimpan ke *Data Store `publikasis`*.
  - Dosen menginput riwayat kegiatan -> Proses menyimpan ke *Data Store `pelaksanaans`*.
  - Admin dapat memanipulasi (Edit/Verifikasi) data yang dimasukkan Dosen melalui Admin API yang terhubung ke `publikasis` dan `pelaksanaans`.

### Proses 5.0: Administrasi dan Verifikasi (Panel Admin)
- **Entitas:** Admin
- **Aliran:**
  - Admin (melalui REST API via app.js) meminta daftar tabel.
  - Sistem memberikan respon JSON dari *semua Data Store*.
  - Admin melakukan verifikasi (Terima/Tolak/Revisi) untuk ajuan Dosen.
  - Sistem mengupdate status (*Update*) ke tabel `_submissions`.
  - Admin melakukan CRUD (Create, Read, Update, Delete) informasi publik (Berita Penelitian, Publikasi Utama, Organisasi).
  - Admin mengelola Data Master (Fakultas, Prodi, Dosen) dan Data Transaksi LPPM Formal (Penelitian, HKI, Laporan, dll) ke tabel-tabel baru.

---

## 3. Data Stores (Tabel Database)
Sistem memiliki 21 penyimpanan data fisik utama yang digambarkan dalam diagram, yaitu:

**Data Berita & Profil Publik (Lama):**
1. `users` : Data akun kredensial (Admin, Dosen, Mahasiswa).
2. `organization_members` : Data struktur organisasi LPPM.
3. `expertises` : Data kelompok kepakaran.
4. `researches` : Data artikel/berita penelitian yang dipajang secara publik.
5. `community_services` : Data berita pengabdian yang dipajang secara publik.
6. `publications` : Master data publikasi LPPM untuk halaman publik.

**Data Historis Dosen (Lama):**
7. `publikasis` : Rekam jejak luaran khusus milik entitas Dosen (Luaran SINTA).
8. `pelaksanaans` : Rekam jejak pelaksanaan aktivitas Dosen.

**Data Ajuan User (Lama):**
9. `research_submissions` : Repositori ajuan proposal penelitian.
10. `pkm_submissions` : Repositori ajuan proposal PKM.
11. `hki_submissions` : Repositori ajuan pendaftaran HKI.
12. `journal_submissions` : Repositori ajuan insentif Jurnal.

**Data Master Institusi (Baru - ERD LPPM):**
13. `fakultas` : Master data Fakultas beserta pimpinannya.
14. `prodi` : Master data Program Studi beserta pimpinannya.
15. `dosen` : Master data spesifik dosen (NIDN, Jabatan Fungsional, Kepakaran).

**Data Transaksi LPPM Formal (Baru - ERD LPPM):**
16. `penelitian` : Data riset formal dosen.
17. `pengajuan_proposal` : Data pengajuan proposal formal yang direview oleh Reviewer.
18. `verifikasi_penelitian` : Data verifikasi/review dari pengajuan proposal.
19. `hki` : Data Hak Kekayaan Intelektual formal dosen.
20. `laporan_sidang` : Data pelaporan kemajuan/sidang.
21. `laporan_jurnal` : Data luaran pelaporan jurnal formal.

---

### Catatan Penting untuk AI Diagrammer:
- **Arsitektur Panel Admin Terpisah:** Admin Panel menggunakan koneksi REST API (`/api/admin/*`) tanpa interaksi *session server-side* langsung seperti dosen. Visualisasikan ini dengan menunjukkan alur API (JSON) antara Admin dan Sistem, berbeda dengan Dosen yang menggunakan View berbasis SSR (Blade Template).
- **Relasi Entitas Terhadap Data:** Entitas Dosen hanya menulis di tabel `users`, `_submissions`, `publikasis`, dan `pelaksanaans`. Namun Entitas Admin dapat melakukan aksi CRUD penuh pada SEMUA *data store*.
