<?php
/**
 * Generate Admin Token (12 digit acak)
 * Jalankan: php generate_token.php
 */

$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$token = '';
for ($i = 0; $i < 12; $i++) {
    $token .= $chars[random_int(0, strlen($chars) - 1)];
}

$tokenFile = __DIR__ . '/storage/app/admin_token.txt';

// Pastikan directory ada
if (!is_dir(dirname($tokenFile))) {
    mkdir(dirname($tokenFile), 0755, true);
}

file_put_contents($tokenFile, $token);

echo "===================================================\n";
echo "  ADMIN TOKEN BERHASIL DIGENERATE\n";
echo "===================================================\n";
echo "\n";
echo "  Token: $token\n";
echo "\n";
echo "  Gunakan token ini untuk masuk ke Admin Panel\n";
echo "  Token tersimpan di: storage/app/admin_token.txt\n";
echo "===================================================\n";
