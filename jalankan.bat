@echo off
color 0A
echo ===================================================
echo     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
echo        (SQLite - Tanpa MySQL Server)
echo ===================================================
echo.

:: ============================================================
:: LANGKAH 0: Cari PHP
:: ============================================================
set "PHP="

:: Cek apakah php ada di PATH sistem
where php >nul 2>nul
if %ERRORLEVEL% equ 0 (
    set "PHP=php"
    goto :php_found
)

:: Cek lokasi XAMPP umum
for %%P in (
    "C:\xampp\php\php.exe"
    "C:\XAMPP\php\php.exe"
    "D:\xampp\php\php.exe"
    "D:\XAMPP\php\php.exe"
) do (
    if exist %%P (
        set "PHP=%%~P"
        goto :php_found
    )
)

echo [ERROR] PHP tidak ditemukan!
echo Pastikan XAMPP terinstal atau PHP ada di PATH sistem Anda.
echo Download XAMPP: https://www.apachefriends.org/
pause
exit /b 1

:php_found
echo [INFO] PHP ditemukan: %PHP%

:: ============================================================
:: LANGKAH 0b: Aktifkan ekstensi zip di php.ini (otomatis)
:: ============================================================
:: Temukan php.ini yang digunakan
for /f "delims=" %%I in ('"%PHP%" -r "echo php_ini_loaded_file();" 2^>nul') do set "PHPINI=%%I"

if defined PHPINI (
    if exist "%PHPINI%" (
        :: Cek apakah zip sudah aktif
        "%PHP%" -m 2>nul | findstr /i "^zip$" >nul 2>nul
        if %ERRORLEVEL% neq 0 (
            echo [INFO] Mengaktifkan ekstensi zip di %PHPINI%...
            :: Hapus tanda ; sebelum extension=zip
            powershell -NoProfile -Command "(Get-Content '%PHPINI%') -replace '^;(extension=zip)', '$1' | Set-Content '%PHPINI%'"
            echo [INFO] Ekstensi zip telah diaktifkan.
        ) else (
            echo [INFO] Ekstensi zip sudah aktif.
        )
    )
)

:: ============================================================
:: [1/5] Install dependensi PHP via Composer
:: ============================================================
if not exist vendor\autoload.php (
    echo.
    echo [1/5] Menginstal dependensi PHP - Composer...

    :: Cari composer
    set "COMPOSER_CMD="
    where composer >nul 2>nul
    if %ERRORLEVEL% equ 0 (
        set "COMPOSER_CMD=composer"
        goto :run_composer
    )

    if exist composer.phar (
        set "COMPOSER_CMD=%PHP% composer.phar"
        goto :run_composer
    )

    :: Unduh composer.phar otomatis
    echo [INFO] Mengunduh Composer secara otomatis...
    "%PHP%" -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 2>nul
    if not exist composer-setup.php (
        echo [ERROR] Gagal mengunduh Composer. Periksa koneksi internet.
        pause
        exit /b 1
    )
    "%PHP%" composer-setup.php --quiet
    del composer-setup.php 2>nul
    if not exist composer.phar (
        echo [ERROR] Gagal menginstal Composer.
        pause
        exit /b 1
    )
    set "COMPOSER_CMD=%PHP% composer.phar"

    :run_composer
    :: Cek apakah zip tersedia
    "%PHP%" -m 2>nul | findstr /i "^zip$" >nul 2>nul
    if %ERRORLEVEL% equ 0 (
        :: Zip tersedia, install normal
        call %COMPOSER_CMD% install --no-interaction
    ) else (
        :: Zip tidak tersedia, pakai --prefer-source
        echo [INFO] Ekstensi zip tidak tersedia, menggunakan mode source...
        call %COMPOSER_CMD% install --no-interaction --prefer-source --ignore-platform-reqs
    )

    if not exist vendor\autoload.php (
        echo.
        echo [ERROR] Instalasi Composer gagal.
        echo Kemungkinan penyebab:
        echo   1. Tidak ada koneksi internet
        echo   2. PHP tidak bisa menjalankan HTTPS (cek php.ini)
        echo.
        echo Solusi manual:
        echo   - Buka XAMPP Control Panel
        echo   - Klik tombol Shell
        echo   - Jalankan: composer install --prefer-source --ignore-platform-reqs
        pause
        exit /b 1
    )
) else (
    echo [1/5] Dependensi PHP sudah terinstal. Melewati...
)

:: ============================================================
:: [2/5] Install dependensi Frontend via NPM (opsional)
:: ============================================================
echo.
if not exist node_modules (
    echo [2/5] Memeriksa dependensi Frontend - NPM...
    where npm >nul 2>nul
    if %ERRORLEVEL% neq 0 (
        echo [2/5] NPM tidak ditemukan. Melewati kompilasi frontend...
        echo        ^(Instal Node.js di https://nodejs.org/ jika perlu kompilasi ulang aset^)
    ) else (
        echo [2/5] Menginstal dependensi Frontend...
        call npm install
    )
) else (
    echo [2/5] Dependensi Frontend sudah terinstal. Melewati...
)

:: ============================================================
:: [3/5] Setup file .env
:: ============================================================
echo.
if not exist .env (
    echo [3/5] File .env tidak ditemukan. Menyalin dari .env.example...
    if exist .env.example (
        copy .env.example .env >nul
        echo [3/5] Menghasilkan Application Key...
        "%PHP%" artisan key:generate
    ) else (
        echo [WARNING] File .env.example tidak ditemukan. Membuat .env minimal...
        (
            echo APP_NAME=LPPM
            echo APP_ENV=local
            echo APP_KEY=
            echo APP_DEBUG=true
            echo APP_URL=http://127.0.0.1:8000
            echo DB_CONNECTION=sqlite
            echo DB_DATABASE=database/database.sqlite
        ) > .env
        "%PHP%" artisan key:generate
    )
) else (
    echo [3/5] File .env sudah ada. Melewati...
)

:: ============================================================
:: [4/5] Setup database SQLite
:: ============================================================
echo.
echo [4/5] Memeriksa database SQLite...
if not exist database (
    mkdir database
)
if not exist database\database.sqlite (
    echo [4/5] Membuat file database SQLite...
    type nul > database\database.sqlite
)

echo [4/5] Menginisiasi struktur tabel...
if exist setup_db.php    "%PHP%" setup_db.php
if exist setup_org.php   "%PHP%" setup_org.php
if exist setup_admin.php "%PHP%" setup_admin.php
echo [4/5] Database siap!

:: Cek token admin panel
if not exist storage\app\admin_token.txt (
    echo Menghasilkan token admin panel...
    if exist generate_token.php "%PHP%" generate_token.php
)

:: Pastikan storage bisa ditulis
if exist storage (
    "%PHP%" artisan storage:link >nul 2>nul
)

:: ============================================================
:: [5/5] Buka Browser dan jalankan server
:: ============================================================
echo.
echo [5/5] Membuka browser ke http://127.0.0.1:8000 ...
start http://127.0.0.1:8000

echo [5/5] Menjalankan server lokal Laravel...
echo Tekan Ctrl+C lalu ketik Y untuk mematikan server.
echo.
"%PHP%" artisan serve

pause
