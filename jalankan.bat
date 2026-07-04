@echo off
color 0A
echo ===================================================
echo     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
echo        (SQLite - Tanpa MySQL Server)
echo ===================================================
echo.

:: Gunakan PHP dari XAMPP (versi 7.4 kompatibel Laravel 7)
set "PHP=C:\xampp\php\php.exe"
if not exist "%PHP%" (
    echo [ERROR] PHP tidak ditemukan di %PHP%
    echo Pastikan XAMPP terinstal di C:\xampp
    pause
    exit /b 1
)

:: [1/5] Cek dan install Composer
if not exist vendor (
    echo [1/5] Menginstal dependensi PHP - Composer...
    call composer install
) else (
    echo [1/5] Dependensi PHP sudah terinstal. Melewati...
)

:: [2/5] Cek dan install NPM
if not exist node_modules (
    echo [2/5] Menginstal dependensi Frontend - NPM...
    call npm install
) else (
    echo [2/5] Dependensi Frontend sudah terinstal. Melewati...
)

:: [3/5] Cek dan buat .env
if not exist .env (
    echo [3/5] File .env tidak ditemukan. Menyalin dari .env.example...
    copy .env.example .env
    echo [3/5] Menghasilkan Application Key...
    %PHP% artisan key:generate
) else (
    echo [3/5] File .env sudah ada. Melewati...
)

:: [4/5] Setup database SQLite
echo [4/5] Memeriksa database SQLite...
if not exist database (
    mkdir database
)
if not exist database\database.sqlite (
    echo [4/5] Membuat database SQLite...
    type nul > database\database.sqlite
)

echo [4/5] Menginisiasi struktur tabel...
%PHP% setup_db.php
%PHP% setup_org.php
%PHP% setup_admin.php
echo [4/5] Database siap!

:: Cek token admin panel
if not exist storage\app\admin_token.txt (
    echo Menghasilkan token admin panel...
    %PHP% generate_token.php
)

:: [5/5] Buka Browser dan jalankan server
echo [5/5] Membuka browser ke http://127.0.0.1:8000 ...
start http://127.0.0.1:8000

echo [5/5] Menjalankan server lokal Laravel...
echo Tekan Ctrl+C dan ketik Y jika ingin mematikan server
%PHP% artisan serve

pause
