# 🚀 Panduan Menjalankan Aplikasi LPPM UCA

---

## ✅ Prasyarat

### 🪟 Windows
- **XAMPP** (sudah include PHP 8.x) → [Download](https://www.apachefriends.org/)
- **Composer** → [Download](https://getcomposer.org/download/)

### 🐧 Linux (Ubuntu/Debian)
```bash
# Install PHP 8.2 beserta ekstensi yang dibutuhkan
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-sqlite3 php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip unzip -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

> Cek versi PHP: `php -v` (harus 8.x)

---

## 📁 Langkah 1 — Letakkan Project

### 🪟 Windows
```
C:\Users\NamaAnda\Desktop\Web_LPPM
```

### 🐧 Linux
```bash
# Clone dari GitHub (jika menggunakan Git)
git clone https://github.com/AdamJauhari/Web_LPPM.git
cd Web_LPPM

# ATAU ekstrak ZIP ke folder, lalu masuk ke dalamnya
cd ~/Web_LPPM
```

---

## 📋 Langkah 2 — Buat File `.env`

Buat file bernama `.env` di dalam folder project (karena `.env` tidak ikut di GitHub).
Isi dengan konten berikut:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:1Umdmb5rBNiZ3UzvuKKiihUODaRivg9bpFM9pWQnjok=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 🐧 Linux — Cara cepat buat `.env`:
```bash
cp .env.example .env
# Lalu edit DB_DATABASE menjadi: database/database.sqlite
# Dan hapus semua konfigurasi DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD
nano .env
```

---

## 📦 Langkah 3 — Install Dependensi

### 🪟 Windows (Command Prompt di folder project)
```bash
composer install
```

### 🐧 Linux (Terminal di folder project)
```bash
composer install --ignore-platform-reqs
```

> Tunggu hingga selesai. Butuh koneksi internet pertama kali.

---

## 🗄️ Langkah 4 — Setup Database

### 🪟 Windows
```bash
# Buat file database
php -r "touch('database/database.sqlite');"

# Buat semua tabel
php setup_db.php

# Isi data organisasi
php setup_org.php

# Buat akun admin
php setup_admin.php
```

### 🐧 Linux
```bash
# Buat file database
touch database/database.sqlite

# Buat semua tabel
php setup_db.php

# Isi data organisasi
php setup_org.php

# Buat akun admin
php setup_admin.php

# Pastikan permission file database bisa ditulis
chmod 664 database/database.sqlite
chmod 775 database/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## ▶️ Langkah 5 — Jalankan Server

### 🪟 Windows
**Cara 1 — Klik dua kali file:**
```
jalankan.bat
```

**Cara 2 — Manual via Command Prompt:**
```bash
php artisan serve
```

### 🐧 Linux
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

> Untuk menjalankan di port berbeda: `php artisan serve --port=8080`

---

## 🔐 Akun Login

### Login Website
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@uca.ac.id | **admin123** |
| Mahasiswa (contoh) | adamft@uca.ac.id | *(sesuai yang didaftarkan)* |

### Login Admin Panel
Buka path file: `admin/index.html` di browser

| Keterangan | Nilai |
|------------|-------|
| Server URL | http://127.0.0.1:8000 |
| Token Admin (12 digit) | `3OE2HLI35RBY` |

---

## ❓ Troubleshooting

| Error | Solusi |
|-------|--------|
| `php not found` | **Win:** Tambahkan `C:\xampp\php` ke PATH. **Linux:** Jalankan `sudo apt install php8.2-cli` |
| `No such table: ...` | Jalankan ulang `php setup_db.php` |
| `composer: command not found` | **Win:** Install dari https://getcomposer.org. **Linux:** Jalankan perintah install Composer di atas |
| `sqlite3 extension not found` | **Linux:** `sudo apt install php8.2-sqlite3` |
| `Permission denied` (Linux) | Jalankan `chmod -R 775 storage/ bootstrap/cache/` |
| Port 8000 sudah dipakai | Jalankan `php artisan serve --port=8080` |
| `Class not found` setelah install | Jalankan `composer dump-autoload` |

---

## 📂 Struktur File Penting

```
Web_LPPM/
├── .env                   ← File konfigurasi (WAJIB dibuat manual)
├── setup_db.php           ← Script membuat tabel database
├── setup_org.php          ← Script mengisi data organisasi
├── setup_admin.php        ← Script membuat akun admin
├── jalankan.bat           ← Shortcut jalankan server (Windows only)
├── database/
│   └── database.sqlite    ← File database (dibuat otomatis)
├── admin_electron/
│   └── index.html         ← Admin panel (buka langsung di browser)
└── storage/app/
    └── admin_token.txt    ← Token admin panel: 3OE2HLI35RBY
```

---

*Dibuat untuk keperluan penilaian mata kuliah — LPPM UCA Web Portal*
