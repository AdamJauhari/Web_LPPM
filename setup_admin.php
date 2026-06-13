<?php
// Script untuk memastikan akun admin tersedia
$dbPath = __DIR__ . '/database/database.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Cek apakah user admin@uca.ac.id sudah ada
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute(['admin@uca.ac.id']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Admin sudah ada: {$user['name']} | Role: {$user['role']}\n";
    // Update password ke admin123
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->prepare("UPDATE users SET password = ?, role = 'admin' WHERE email = ?")->execute([$hash, 'admin@uca.ac.id']);
    echo "[OK] Password diperbarui ke: admin123\n";
} else {
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');
    $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, 'admin', ?, ?)")
        ->execute(['Administrator', 'admin@uca.ac.id', $hash, $now, $now]);
    echo "[OK] Akun admin dibuat:\n  Email   : admin@uca.ac.id\n  Password: admin123\n";
}

echo "\n=== Semua akun yang tersedia ===\n";
$rows = $pdo->query("SELECT id, name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo "  ID={$r['id']} | {$r['email']} | Role: {$r['role']}\n";
}
