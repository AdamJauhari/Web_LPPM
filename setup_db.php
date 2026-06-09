<?php
/**
 * Setup SQLite database tables for LPPM UCA
 * Jalankan: php setup_db.php
 */

$dbPath = __DIR__ . '/database/database.sqlite';

// Buat file jika belum ada
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "File database.sqlite dibuat\n";
}

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'mahasiswa',
        nim_nip VARCHAR(30) NULL,
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel users\n";
    
    // Researches table
    $pdo->exec("CREATE TABLE IF NOT EXISTS researches (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NULL,
        body TEXT NULL,
        thumbnail VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel researches\n";
    
    // Publications table
    $pdo->exec("CREATE TABLE IF NOT EXISTS publications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NULL,
        body TEXT NULL,
        file VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel publications\n";
    
    // Community Services table
    $pdo->exec("CREATE TABLE IF NOT EXISTS community_services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NULL,
        body TEXT NULL,
        thumbnail VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel community_services\n";
    
    // Expertises table
    $pdo->exec("CREATE TABLE IF NOT EXISTS expertises (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        expertise VARCHAR(255) NULL,
        faculty VARCHAR(255) NULL,
        study_program VARCHAR(255) NULL,
        email VARCHAR(255) NULL,
        phone VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel expertises\n";
    
    // Migrations table
    $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        migration VARCHAR(255) NOT NULL,
        batch INTEGER NOT NULL
    )");
    echo "[OK] Tabel migrations\n";

    // Organization Members table
    $pdo->exec("CREATE TABLE IF NOT EXISTS organization_members (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        position VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        photo VARCHAR(255) NULL,
        sort_order INTEGER DEFAULT 0,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel organization_members\n";
    
    // Research Submissions table
    $pdo->exec("CREATE TABLE IF NOT EXISTS research_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(255) NOT NULL,
        abstract TEXT NULL,
        research_type VARCHAR(255) NULL,
        team_members TEXT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        admin_notes TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel research_submissions\n";
    
    // Journal Submissions table
    $pdo->exec("CREATE TABLE IF NOT EXISTS journal_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(255) NOT NULL,
        file VARCHAR(255) NULL,
        journal_name VARCHAR(255) NULL,
        authors TEXT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        admin_notes TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel journal_submissions\n";

    // Publikasis table (Fitur Data Publikasi)
    $pdo->exec("CREATE TABLE IF NOT EXISTS publikasis (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        judul VARCHAR(255) NOT NULL,
        abstrak TEXT NOT NULL,
        jenis_publikasi VARCHAR(50) NOT NULL,
        kategori_reputasi VARCHAR(255) NOT NULL,
        url_jurnal VARCHAR(255) NULL,
        url_repository VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "[OK] Tabel publikasis\n";

    // Pelaksanaans table (Fitur Data Pelaksanaan)
    $pdo->exec("CREATE TABLE IF NOT EXISTS pelaksanaans (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        jenis_kegiatan VARCHAR(50) NOT NULL,
        judul VARCHAR(255) NOT NULL,
        deskripsi_singkat TEXT NOT NULL,
        sumber_dana VARCHAR(255) NOT NULL,
        url VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "[OK] Tabel pelaksanaans\n";

    // Failed jobs table
    $pdo->exec("CREATE TABLE IF NOT EXISTS failed_jobs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        connection TEXT NOT NULL,
        queue TEXT NOT NULL,
        payload TEXT NOT NULL,
        exception TEXT NOT NULL,
        failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "[OK] Tabel failed_jobs\n";
    
    echo "\n=== Database SQLite siap! ===\n";
    echo "Lokasi: $dbPath\n";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
