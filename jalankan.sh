#!/bin/bash

# Warna terminal
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}==================================================="
echo "    MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM"
echo -e "===================================================${NC}"
echo ""

# [0/6] Cek dan jalankan MySQL
echo -e "${YELLOW}[0/6]${NC} Memeriksa MySQL..."
if command -v mysql &> /dev/null; then
    mysql -u root -e "SELECT 1" &> /dev/null
    if [ $? -ne 0 ]; then
        echo -e "${YELLOW}[0/6]${NC} MySQL belum berjalan. Mencoba menyalakan..."
        if command -v systemctl &> /dev/null; then
            sudo systemctl start mysql 2>/dev/null || sudo systemctl start mariadb 2>/dev/null
        elif command -v service &> /dev/null; then
            sudo service mysql start 2>/dev/null || sudo service mariadb start 2>/dev/null
        fi
        sleep 3
        mysql -u root -e "SELECT 1" &> /dev/null
        if [ $? -ne 0 ]; then
            echo -e "${RED}[ERROR]${NC} MySQL gagal dinyalakan!"
            echo "Pastikan MySQL/MariaDB terinstal. Jalankan:"
            echo "  sudo apt install mysql-server"
            echo "  atau"
            echo "  sudo apt install mariadb-server"
            exit 1
        fi
        echo -e "${GREEN}[0/6]${NC} MySQL berhasil dinyalakan!"
    else
        echo -e "${GREEN}[0/6]${NC} MySQL sudah berjalan. Melewati..."
    fi
else
    echo -e "${RED}[ERROR]${NC} MySQL tidak ditemukan!"
    echo "Install terlebih dahulu:"
    echo "  sudo apt install mysql-server"
    exit 1
fi

# [1/6] Cek dan install Composer
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}[1/6]${NC} Menginstal dependensi PHP - Composer..."
    if command -v composer &> /dev/null; then
        composer install
    else
        echo -e "${RED}[ERROR]${NC} Composer tidak ditemukan!"
        echo "Install terlebih dahulu:"
        echo "  curl -sS https://getcomposer.org/installer | php"
        echo "  sudo mv composer.phar /usr/local/bin/composer"
        exit 1
    fi
else
    echo -e "${GREEN}[1/6]${NC} Dependensi PHP sudah terinstal. Melewati..."
fi

# [2/6] Cek dan install NPM
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}[2/6]${NC} Menginstal dependensi Frontend - NPM..."
    if command -v npm &> /dev/null; then
        npm install
    else
        echo -e "${RED}[ERROR]${NC} NPM tidak ditemukan!"
        echo "Install Node.js terlebih dahulu:"
        echo "  curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -"
        echo "  sudo apt install -y nodejs"
        exit 1
    fi
else
    echo -e "${GREEN}[2/6]${NC} Dependensi Frontend sudah terinstal. Melewati..."
fi

# [3/6] Cek dan buat .env
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}[3/6]${NC} File .env tidak ditemukan. Menyalin dari .env.example..."
    cp .env.example .env
    echo -e "${YELLOW}[3/6]${NC} Menghasilkan Application Key..."
    php artisan key:generate
else
    echo -e "${GREEN}[3/6]${NC} File .env sudah ada. Melewati..."
fi

# [4/6] Buat database jika belum ada dan jalankan migrasi
echo -e "${YELLOW}[4/6]${NC} Memeriksa database..."
mysql -u root -e "CREATE DATABASE IF NOT EXISTS web_lppm;" 2>/dev/null
php artisan migrate --force &> /dev/null
echo -e "${GREEN}[4/6]${NC} Database siap!"

# [5/6] Compile Frontend (background)
echo -e "${YELLOW}[5/6]${NC} Mengompilasi aset frontend - npm run dev ..."
npm run dev &
NPM_PID=$!

# Tunggu sebentar agar Vite siap
sleep 3

# [6/6] Buka Browser dan jalankan server
echo -e "${YELLOW}[6/6]${NC} Membuka browser ke http://127.0.0.1:8000 ..."

# Buka browser otomatis (coba beberapa cara)
if command -v xdg-open &> /dev/null; then
    xdg-open http://127.0.0.1:8000 &> /dev/null &
elif command -v gnome-open &> /dev/null; then
    gnome-open http://127.0.0.1:8000 &> /dev/null &
elif command -v sensible-browser &> /dev/null; then
    sensible-browser http://127.0.0.1:8000 &> /dev/null &
else
    echo "Buka browser secara manual: http://127.0.0.1:8000"
fi

echo -e "${GREEN}[6/6]${NC} Menjalankan server lokal Laravel..."
echo -e "${YELLOW}Tekan Ctrl+C untuk mematikan server${NC}"
echo ""

# Trap untuk membersihkan proses NPM saat keluar
cleanup() {
    echo ""
    echo -e "${YELLOW}Mematikan server...${NC}"
    kill $NPM_PID 2>/dev/null
    echo -e "${GREEN}Server berhasil dimatikan. Sampai jumpa!${NC}"
    exit 0
}
trap cleanup SIGINT SIGTERM

php artisan serve

# Cleanup saat selesai
kill $NPM_PID 2>/dev/null
