@echo off
color 0A
echo ===================================================
echo     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
echo ===================================================
echo.

:: [0/6] Cek dan jalankan MySQL (XAMPP)
echo [0/6] Memeriksa MySQL...
C:\xampp\mysql\bin\mysql.exe -u root -e "SELECT 1" >nul 2>&1
if %errorlevel% neq 0 (
    echo [0/6] MySQL belum berjalan. Menyalakan MySQL XAMPP...
    start "" /B C:\xampp\mysql\bin\mysqld.exe --defaults-file=C:\xampp\mysql\bin\my.ini
    echo [0/6] Menunggu MySQL siap...
    timeout /t 5 /nobreak >nul
    C:\xampp\mysql\bin\mysql.exe -u root -e "SELECT 1" >nul 2>&1
    if %errorlevel% neq 0 (
        echo [ERROR] MySQL gagal dinyalakan! Pastikan XAMPP terinstal dengan benar.
        pause
        exit /b 1
    )
    echo [0/6] MySQL berhasil dinyalakan!
) else (
    echo [0/6] MySQL sudah berjalan. Melewati...
)

:: [1/6] Cek dan install Composer
if not exist vendor (
    echo [1/6] Menginstal dependensi PHP - Composer...
    call composer install
) else (
    echo [1/6] Dependensi PHP sudah terinstal. Melewati...
)

:: [2/6] Cek dan install NPM
if not exist node_modules (
    echo [2/6] Menginstal dependensi Frontend - NPM...
    call npm install
) else (
    echo [2/6] Dependensi Frontend sudah terinstal. Melewati...
)

:: [3/6] Cek dan buat .env
if not exist .env (
    echo [3/6] File .env tidak ditemukan. Menyalin dari .env.example...
    copy .env.example .env
    echo [3/6] Menghasilkan Application Key...
    call C:\xampp\php\php.exe artisan key:generate
) else (
    echo [3/6] File .env sudah ada. Melewati...
)

:: [4/6] Buat database jika belum ada dan jalankan migrasi
echo [4/6] Memeriksa database...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS web_lppm;"
C:\xampp\php\php.exe artisan migrate --force >nul 2>&1
echo [4/6] Database siap!

:: [5/6] Compile Frontend
echo [5/6] Mengompilasi aset frontend - npm run dev ...
call npm run dev

:: [6/6] Buka Browser dan jalankan server
echo [6/6] Membuka browser ke http://127.0.0.1:8000 ...
start http://127.0.0.1:8000

echo [6/6] Menjalankan server lokal Laravel...
echo Tekan Ctrl+C dan ketik Y jika ingin mematikan server
call C:\xampp\php\php.exe artisan serve

pause
