#!/bin/bash
# ===================================================
#     MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM
#        (SQLite - Tanpa MySQL Server) - LINUX
# ===================================================

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}==================================================="
echo -e "    MEMULAI SETUP DAN MENJALANKAN APLIKASI LPPM"
echo -e "       (SQLite - Tanpa MySQL Server) - LINUX"
echo -e "===================================================${NC}"
echo ""

# Cek PHP
if ! command -v php &> /dev/null; then
    echo -e "${RED}[ERROR] PHP tidak ditemukan!${NC}"
    echo "Jalankan: sudo apt install php8.2 php8.2-cli php8.2-sqlite3 php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip -y"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION;")
if [ "$PHP_VERSION" -lt 8 ]; then
    echo -e "${RED}[ERROR] PHP versi 8.x dibutuhkan. Versi saat ini: $(php -v | head -1)${NC}"
    exit 1
fi
echo -e "${GREEN}[OK] PHP ditemukan: $(php -v | head -1)${NC}"

# Cek Composer
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}[1/4] Composer tidak ditemukan. Menginstall...${NC}"
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
else
    echo -e "${GREEN}[OK] Composer ditemukan.${NC}"
fi

# [1/4] Install dependensi
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}[1/4] Menginstall dependensi PHP via Composer...${NC}"
    composer install --ignore-platform-reqs
else
    echo -e "${GREEN}[1/4] Dependensi PHP sudah terinstall. Melewati...${NC}"
fi

# [2/4] Setup .env
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}[2/4] File .env tidak ditemukan. Menyalin dari .env.example...${NC}"
    cp .env.example .env
    php artisan key:generate
else
    echo -e "${GREEN}[2/4] File .env sudah ada. Melewati...${NC}"
fi

# [3/4] Setup database SQLite
echo -e "${YELLOW}[3/4] Memeriksa database SQLite...${NC}"
if [ ! -f "database/database.sqlite" ]; then
    echo -e "${YELLOW}[3/4] Membuat file database SQLite...${NC}"
    touch database/database.sqlite
fi

# Fix permissions
chmod 664 database/database.sqlite
chmod 775 database/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
echo -e "${GREEN}[3/4] Database & permissions siap!${NC}"

# [4/4] Jalankan server
echo ""
echo -e "${GREEN}[4/4] Menjalankan server Laravel...${NC}"
echo -e "${YELLOW}Buka browser ke: http://127.0.0.1:8000${NC}"
echo -e "${YELLOW}Login: admin@uca.ac.id / admin123${NC}"
echo -e "${YELLOW}Tekan Ctrl+C untuk menghentikan server${NC}"
echo ""

# Buka browser jika tersedia
if command -v xdg-open &> /dev/null; then
    sleep 2 && xdg-open http://127.0.0.1:8000 &
fi

php artisan serve
