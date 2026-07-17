<?php
/**
 * setup_env.php
 * Dipanggil dari jalankan.bat untuk menyiapkan file .env dengan path absolut
 */

$projDir  = __DIR__;
$envFile  = $projDir . DIRECTORY_SEPARATOR . '.env';
$envExample = $projDir . DIRECTORY_SEPARATOR . '.env.example';
$sqliteFile = $projDir . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'database.sqlite';

// Normalisasi path untuk .env (gunakan forward slash)
$sqlitePathForEnv = str_replace('\\', '/', $sqliteFile);

// 1. Buat .env dari .env.example jika belum ada
if (!file_exists($envFile)) {
    if (file_exists($envExample)) {
        copy($envExample, $envFile);
        echo "[OK] .env disalin dari .env.example\n";
    } else {
        $defaultEnv = "APP_NAME=LPPM_UCA\n"
                    . "APP_ENV=local\n"
                    . "APP_KEY=\n"
                    . "APP_DEBUG=true\n"
                    . "APP_URL=http://127.0.0.1:8000\n"
                    . "LOG_CHANNEL=stack\n"
                    . "DB_CONNECTION=sqlite\n"
                    . "DB_DATABASE=\n"
                    . "BROADCAST_DRIVER=log\n"
                    . "CACHE_DRIVER=file\n"
                    . "QUEUE_CONNECTION=sync\n"
                    . "SESSION_DRIVER=file\n"
                    . "SESSION_LIFETIME=120\n";
        file_put_contents($envFile, $defaultEnv);
        echo "[OK] .env dibuat dari template default\n";
    }
} else {
    echo "[OK] .env sudah ada, memverifikasi konfigurasi...\n";
}

// 2. Baca .env
$lines = file($envFile, FILE_IGNORE_NEW_LINES);
$newLines   = [];
$foundDb    = false;
$foundConn  = false;
$foundKey   = false;

foreach ($lines as $line) {
    // Deteksi DB_DATABASE (termasuk yang dikomentari)
    if (preg_match('/^#?\s*DB_DATABASE\s*=/', $line)) {
        $newLines[] = 'DB_DATABASE=' . $sqlitePathForEnv;
        $foundDb    = true;
        echo "[OK] DB_DATABASE diset: $sqlitePathForEnv\n";
    }
    // Deteksi DB_CONNECTION
    elseif (preg_match('/^DB_CONNECTION\s*=/', $line)) {
        $newLines[]  = 'DB_CONNECTION=sqlite';
        $foundConn   = true;
    }
    // Deteksi APP_URL (pastikan pakai port 8000)
    elseif (preg_match('/^APP_URL\s*=/', $line)) {
        $newLines[] = 'APP_URL=http://127.0.0.1:8000';
    }
    else {
        $newLines[] = $line;
    }

    if (preg_match('/^APP_KEY\s*=\s*\S+/', $line)) {
        $foundKey = true;
    }
}

// Tambahkan jika tidak ditemukan
if (!$foundDb) {
    $newLines[] = 'DB_DATABASE=' . $sqlitePathForEnv;
    echo "[OK] DB_DATABASE ditambahkan: $sqlitePathForEnv\n";
}
if (!$foundConn) {
    $newLines[] = 'DB_CONNECTION=sqlite';
    echo "[OK] DB_CONNECTION ditambahkan\n";
}

// 3. Tulis kembali .env
file_put_contents($envFile, implode(PHP_EOL, $newLines) . PHP_EOL);
echo "[OK] .env berhasil diperbarui\n";

// 4. Verifikasi hasil
$check = file_get_contents($envFile);
if (preg_match('/^DB_DATABASE=(.+)/m', $check, $m)) {
    echo "[VERIFY] DB_DATABASE = " . trim($m[1]) . "\n";
} else {
    echo "[ERROR] DB_DATABASE tidak ditemukan di .env!\n";
    exit(1);
}

// 5. Buat file database jika belum ada
$dbDir = $projDir . DIRECTORY_SEPARATOR . 'database';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
    echo "[OK] Folder database dibuat\n";
}
if (!file_exists($sqliteFile)) {
    touch($sqliteFile);
    echo "[OK] File database.sqlite dibuat: $sqliteFile\n";
} else {
    echo "[OK] File database.sqlite sudah ada\n";
}

// 6. Test koneksi SQLite
try {
    $pdo = new PDO('sqlite:' . $sqliteFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("PRAGMA foreign_keys = ON");
    echo "[OK] Koneksi SQLite berhasil\n";
} catch (Exception $e) {
    echo "[ERROR] Koneksi SQLite gagal: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== Setup .env dan database selesai! ===\n";
