<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabel Ajuan Proposal Penelitian
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS research_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(255) NOT NULL,
        abstract TEXT NULL,
        research_type VARCHAR(100) NULL,
        team_members TEXT NULL,
        file VARCHAR(255) NULL,
        status VARCHAR(20) DEFAULT 'pending',
        admin_notes TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel research_submissions\n";
} catch(Exception $e) { echo "[SKIP] " . $e->getMessage() . "\n"; }

// Tabel Ajuan Jurnal Penelitian
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS journal_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(255) NOT NULL,
        abstract TEXT NULL,
        journal_name VARCHAR(255) NULL,
        authors TEXT NULL,
        file VARCHAR(255) NULL,
        status VARCHAR(20) DEFAULT 'pending',
        admin_notes TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel journal_submissions\n";
} catch(Exception $e) { echo "[SKIP] " . $e->getMessage() . "\n"; }

echo "Selesai!\n";
