@echo off
setlocal EnableDelayedExpansion
color 0A
echo ===================================================
echo     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
echo        (SQLite - Tanpa MySQL Server)
echo ===================================================
echo.

:: Simpan direktori project (folder tempat .bat ini berada)
set "PROJDIR=%~dp0"
if "%PROJDIR:~-1%"=="\" set "PROJDIR=%PROJDIR:~0,-1%"

:: ============================================================
:: LANGKAH 0: Cari PHP
:: ============================================================
set "PHP="

where php >nul 2>nul
if %ERRORLEVEL% equ 0 (
    set "PHP=php"
    goto :php_found
)

for %%P in (
    "C:\xampp\php\php.exe"
    "C:\XAMPP\php\php.exe"
    "D:\xampp\php\php.exe"
    "D:\XAMPP\php\php.exe"
    "C:\php\php.exe"
    "D:\php\php.exe"
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
echo [INFO] PHP: %PHP%

:: ============================================================
:: LANGKAH 0b: Aktifkan ekstensi penting di php.ini
:: ============================================================
for /f "delims=" %%I in ('"%PHP%" -r "echo php_ini_loaded_file();" 2^>nul') do set "PHPINI=%%I"

if defined PHPINI (
    if exist "%PHPINI%" (
        echo [INFO] php.ini: %PHPINI%
        :: Aktifkan zip, openssl, pdo_sqlite, sqlite3 jika dikomentari
        powershell -NoProfile -Command ^
            "$c = Get-Content '%PHPINI%';" ^
            "$c = $c -replace '^;extension=zip','extension=zip';" ^
            "$c = $c -replace '^;extension=openssl','extension=openssl';" ^
            "$c = $c -replace '^;extension=pdo_sqlite','extension=pdo_sqlite';" ^
            "$c = $c -replace '^;extension=sqlite3','extension=sqlite3';" ^
            "$c | Set-Content '%PHPINI%';" ^
            "Write-Host '[INFO] Ekstensi PHP diverifikasi.'"
    )
)

:: ============================================================
:: [1/5] Install dependensi PHP via Composer
:: ============================================================
echo.
if not exist "%PROJDIR%\vendor\autoload.php" (
    echo [1/5] Menginstal dependensi PHP - Composer...

    :: Cari composer
    set "COMPOSER_CMD="
    where composer >nul 2>nul
    if !ERRORLEVEL! equ 0 (
        set "COMPOSER_CMD=composer"
        goto :run_composer
    )

    if exist "%PROJDIR%\composer.phar" (
        set "COMPOSER_CMD="%PHP%" "%PROJDIR%\composer.phar""
        goto :run_composer
    )

    :: Unduh composer.phar otomatis
    echo [INFO] Mengunduh Composer...
    "%PHP%" -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    if not exist "%PROJDIR%\composer-setup.php" (
        echo [ERROR] Gagal mengunduh Composer. Periksa koneksi internet.
        pause
        exit /b 1
    )
    "%PHP%" "%PROJDIR%\composer-setup.php" --quiet
    del "%PROJDIR%\composer-setup.php" 2>nul
    if not exist "%PROJDIR%\composer.phar" (
        echo [ERROR] Gagal menginstal Composer.
        pause
        exit /b 1
    )
    set "COMPOSER_CMD="%PHP%" "%PROJDIR%\composer.phar""

    :run_composer
    "%PHP%" -m 2>nul | findstr /i "^zip$" >nul 2>nul
    if !ERRORLEVEL! equ 0 (
        call %COMPOSER_CMD% install --no-interaction --working-dir="%PROJDIR%"
    ) else (
        echo [INFO] Zip tidak aktif, menggunakan --prefer-source...
        call %COMPOSER_CMD% install --no-interaction --prefer-source --ignore-platform-reqs --working-dir="%PROJDIR%"
    )

    if not exist "%PROJDIR%\vendor\autoload.php" (
        echo.
        echo [ERROR] Instalasi Composer gagal!
        echo Solusi: Buka CMD di folder project ini, jalankan:
        echo   composer install --prefer-source --ignore-platform-reqs
        pause
        exit /b 1
    )
    echo [1/5] Dependensi PHP berhasil diinstal.
) else (
    echo [1/5] Dependensi PHP sudah terinstal. Melewati...
)

:: ============================================================
:: [2/5] Install dependensi Frontend via NPM (opsional)
:: ============================================================
echo.
if not exist "%PROJDIR%\node_modules" (
    where npm >nul 2>nul
    if !ERRORLEVEL! neq 0 (
        echo [2/5] NPM tidak ditemukan - melewati kompilasi frontend.
    ) else (
        echo [2/5] Menginstal dependensi Frontend...
        call npm install --prefix "%PROJDIR%"
    )
) else (
    echo [2/5] Dependensi Frontend sudah terinstal. Melewati...
)

:: ============================================================
:: [3/5] Setup .env dan database (path absolut)
:: ============================================================
echo.
echo [3/5] Menyiapkan konfigurasi .env dan database...
:: Gunakan PHP helper agar path absolut diset dengan benar
"%PHP%" "%PROJDIR%\setup_env.php"
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Setup .env gagal!
    pause
    exit /b 1
)

:: Generate APP_KEY jika kosong
"%PHP%" "%PROJDIR%\artisan" key:generate --force >nul 2>nul
:: Bersihkan config cache agar .env yang baru langsung terbaca
"%PHP%" "%PROJDIR%\artisan" config:clear >nul 2>nul
"%PHP%" "%PROJDIR%\artisan" cache:clear  >nul 2>nul
echo [3/5] Konfigurasi siap.

:: ============================================================
:: [4/5] Inisiasi struktur tabel database
:: ============================================================
echo.
echo [4/5] Menginisiasi struktur tabel database...
if exist "%PROJDIR%\setup_db.php"    "%PHP%" "%PROJDIR%\setup_db.php"
if exist "%PROJDIR%\setup_org.php"   "%PHP%" "%PROJDIR%\setup_org.php"
if exist "%PROJDIR%\setup_admin.php" "%PHP%" "%PROJDIR%\setup_admin.php"
echo [4/5] Database siap!

:: Token admin panel
if not exist "%PROJDIR%\storage\app\admin_token.txt" (
    echo [4/5] Menghasilkan token admin panel...
    if exist "%PROJDIR%\generate_token.php" "%PHP%" "%PROJDIR%\generate_token.php"
)

:: Storage link
if exist "%PROJDIR%\storage" (
    "%PHP%" "%PROJDIR%\artisan" storage:link >nul 2>nul
)

:: ============================================================
:: VERIFIKASI AKHIR - Test koneksi sebelum buka browser
:: ============================================================
echo.
echo [INFO] Verifikasi akhir koneksi database...
"%PHP%" "%PROJDIR%\check_db.php"
if %ERRORLEVEL% neq 0 (
    echo.
    echo [ERROR] Koneksi database gagal. Coba jalankan kembali script ini.
    pause
    exit /b 1
)

:: ============================================================
:: [5/5] Buka Browser dan jalankan server
:: ============================================================
echo.
echo ===================================================
echo   SETUP SELESAI! Aplikasi siap digunakan.
echo ===================================================
echo.
echo [5/5] Membuka browser ke http://127.0.0.1:8000 ...
timeout /t 2 /nobreak >nul
start http://127.0.0.1:8000

echo [5/5] Menjalankan server lokal Laravel...
echo Tekan Ctrl+C lalu ketik Y untuk mematikan server.
echo.
"%PHP%" "%PROJDIR%\artisan" serve

pause
