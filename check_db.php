<?php
// Test koneksi database langsung via PDO (tanpa booting Laravel penuh)
$envFile = __DIR__ . '/.env';
$dbPath  = null;

if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES) as $line) {
        if (preg_match('/^DB_DATABASE=(.+)/', $line, $m)) {
            $dbPath = trim($m[1]);
            break;
        }
    }
}

if (!$dbPath) {
    echo '[ERROR] DB_DATABASE tidak ditemukan di .env!' . PHP_EOL;
    exit(1);
}

echo 'DB_DATABASE = ' . $dbPath . PHP_EOL;

if (!file_exists($dbPath)) {
    echo '[ERROR] File database tidak ada: ' . $dbPath . PHP_EOL;
    exit(1);
}

try {
    $pdo    = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '[OK] Koneksi database berhasil!' . PHP_EOL;
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")
                  ->fetchAll(PDO::FETCH_COLUMN);
    echo 'Total tabel: ' . count($tables) . PHP_EOL;
    foreach ($tables as $t) {
        echo '  - ' . $t . PHP_EOL;
    }
} catch (Exception $e) {
    echo '[ERROR] ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
