@echo off
color 0A
echo ===================================================
echo     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
echo        (SQLite - Tanpa MySQL Server)
echo ===================================================
echo.

:: Mencari PHP (Cek di PATH sistem terlebih dahulu, jika tidak ada cari di XAMPP)
where php >nul 2>nul
if %ERRORLEVEL% equ 0 (
    set "PHP=php"
) else (
    set "PHP=C:\xampp\php\php.exe"
)

:: Verifikasi apakah PHP bisa dijalankan
%PHP% -v >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo [ERROR] PHP tidak ditemukan atau tidak dapat dijalankan.
    echo Pastikan XAMPP terinstal di C:\xampp atau PHP ada di PATH sistem Anda.
    pause
    exit /b 1
)

:: [1/5] Cek dan install Composer
if not exist vendor (
    echo [1/5] Menginstal dependensi PHP - Composer...
    where composer >nul 2>nul
    if %errorlevel% equ 0 (
        call composer install
    ) else (
        echo [INFO] Composer tidak ditemukan secara global, mengunduh composer.phar secara otomatis...
        if not exist composer.phar (
            %PHP% -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
            %PHP% composer-setup.php --quiet
            del composer-setup.php
        )
        if exist composer.phar (
            %PHP% composer.phar install
        ) else (
            echo [ERROR] Gagal mengunduh Composer. Pastikan komputer terhubung ke internet.
            pause
            exit /b 1
        )
    )
) else (
    echo [1/5] Dependensi PHP sudah terinstal. Melewati...
)

:: [2/5] Cek dan install NPM
if not exist node_modules (
    echo [2/5] Menginstal dependensi Frontend - NPM...
    where npm >nul 2>nul
    if %errorlevel% neq 0 (
        echo [WARNING] NPM tidak ditemukan!
        echo Pastikan Node.js terinstal ^(https://nodejs.org/^) jika butuh kompilasi frontend.
        echo Melewati instalasi NPM...
    ) else (
        call npm install
    )
) else (
    echo [2/5] Dependensi Frontend sudah terinstal. Melewati...
)

:: Memastikan vendor terinstal
if not exist vendor\autoload.php (
    echo [ERROR] File vendor\autoload.php tidak ditemukan.
    echo Pastikan instalasi composer berhasil sebelum menjalankan aplikasi.
    pause
    exit /b 1
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
