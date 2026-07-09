# Panduan Menjalankan Panel Admin (Mode Terpisah)

Panel Admin sekarang telah dipisahkan dari struktur aplikasi utama Laravel (demi keamanan) dan berada di dalam folder `admin/`. 

Karena berjalan secara terpisah, Anda perlu menjalankan *backend* (API Laravel) dan *frontend* (Panel Admin) secara bersamaan. Berikut adalah langkah-langkahnya:

### 1. Jalankan Server Backend (Laravel)
Pastikan server utama Laravel Anda sudah berjalan, karena panel admin membutuhkan API ini untuk mengambil dan menyimpan data.
- Buka terminal/command prompt.
- Pastikan Anda berada di folder utama proyek (Web_LPPM).
- Jalankan perintah:
  ```bash
  php artisan serve
  ```
  *(Atau Anda bisa menggunakan file `jalankan.bat` / `jalankan.sh` yang sudah ada)*. Server akan berjalan di `http://127.0.0.1:8000`.

### 2. Jalankan Panel Admin (Frontend)
Buka terminal/command prompt **baru** (biarkan terminal pertama tetap berjalan), lalu lakukan langkah berikut:

**Opsi A: Menggunakan PHP Built-in Server (Paling Mudah)**
- Masuk ke folder admin:
  ```bash
  cd admin
  ```
- Jalankan server khusus untuk folder admin di port 8001:
  ```bash
  php -S localhost:8001
  ```
- Buka browser dan akses: [http://localhost:8001](http://localhost:8001)

**Opsi B: Menggunakan Ekstensi VS Code (Live Server)**
- Buka folder proyek ini menggunakan Visual Studio Code.
- Pastikan Anda sudah menginstal ekstensi **Live Server**.
- Buka file `admin/index.html`.
- Klik kanan di area kode dan pilih **"Open with Live Server"**.

### 3. Login Menggunakan Token
Panel admin yang baru menggunakan **Sistem Token** untuk verifikasi masuk, bukan email/password biasa.
- Token login dapat Anda temukan di file `admin_token.txt` (di dalam folder `admin/`).
- Salin token tersebut dan tempelkan di kotak "Security Token" pada halaman login admin.
- Klik **"Masuk ke Admin Panel"**.

*(Catatan: Jika Anda tidak menemukan file token atau ingin membuat ulang token, Anda bisa menjalankan perintah `php generate_token.php` di folder utama aplikasi).*

---

**Troubleshooting / Masalah Umum:**
- Jika tabel data kosong padahal di website ada datanya, pastikan Server Backend (Langkah 1) sudah menyala di port `8000`. Panel Admin mencari API di alamat `http://127.0.0.1:8000`.
- Jika Anda melihat layar putih atau *"Connection Refused"*, periksa jendela terminal dan pastikan tidak ada yang *crash*.

