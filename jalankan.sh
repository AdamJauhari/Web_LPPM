#!/bin/bash
echo "==================================================="
echo "    MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM"
echo "       (SQLite - Tanpa XAMPP/MySQL)"
echo "==================================================="
echo ""

# [1/5] Cek dan install Composer
if [ ! -d "vendor" ]; then
    echo "[1/5] Menginstal dependensi PHP - Composer..."
    composer install
else
    echo "[1/5] Dependensi PHP sudah terinstal. Melewati..."
fi

# [2/5] Cek dan install NPM
if [ ! -d "node_modules" ]; then
    echo "[2/5] Menginstal dependensi Frontend - NPM..."
    npm install
else
    echo "[2/5] Dependensi Frontend sudah terinstal. Melewati..."
fi

# [3/5] Cek dan buat .env
if [ ! -f ".env" ]; then
    echo "[3/5] File .env tidak ditemukan. Menyalin dari .env.example..."
    cp .env.example .env
    echo "[3/5] Menghasilkan Application Key..."
    php artisan key:generate
else
    echo "[3/5] File .env sudah ada. Melewati..."
fi

# [4/5] Setup database SQLite
echo "[4/5] Memeriksa database SQLite..."
if [ ! -f "database/database.sqlite" ]; then
    echo "[4/5] Membuat database SQLite..."
    touch database/database.sqlite
    php setup_db.php
else
    echo "[4/5] Database SQLite sudah ada. Melewati..."
fi
echo "[4/5] Database siap!"

# [5/5] Buka Browser dan jalankan server
echo "[5/5] Membuka browser dan menjalankan server Laravel..."
echo "Buka browser ke http://127.0.0.1:8000"
echo "Tekan Ctrl+C untuk mematikan server"

# Buka browser (cross-platform)
if command -v xdg-open &> /dev/null; then
    xdg-open http://127.0.0.1:8000 &
elif command -v open &> /dev/null; then
    open http://127.0.0.1:8000 &
fi

php artisan serve
