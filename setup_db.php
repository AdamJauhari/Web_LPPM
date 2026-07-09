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
    // Aktifkan foreign key support di SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    // =========================================================
    // Users table
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(30) DEFAULT 'dosen',
        nim_nip VARCHAR(30) NULL,
        nidn VARCHAR(20) NULL,
        fakultas VARCHAR(10) NULL,
        jabatan_fungsional VARCHAR(100) NULL,
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    // Tambah kolom baru jika belum ada (ALTER TABLE untuk existing database)
    $cols = array_column($pdo->query("PRAGMA table_info(users)")->fetchAll(PDO::FETCH_ASSOC), 'name');
    if (!in_array('nidn', $cols))               $pdo->exec("ALTER TABLE users ADD COLUMN nidn VARCHAR(20) NULL");
    if (!in_array('fakultas', $cols))           $pdo->exec("ALTER TABLE users ADD COLUMN fakultas VARCHAR(10) NULL");
    if (!in_array('jabatan_fungsional', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN jabatan_fungsional VARCHAR(100) NULL");
    echo "[OK] Tabel users\n";

    // =========================================================
    // Researches table (berita penelitian)
    // =========================================================
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

    // =========================================================
    // Publications table
    // =========================================================
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

    // =========================================================
    // Community Services table
    // =========================================================
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

    // =========================================================
    // Expertises table
    // =========================================================
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

    // =========================================================
    // Migrations table
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        migration VARCHAR(255) NOT NULL,
        batch INTEGER NOT NULL
    )");
    echo "[OK] Tabel migrations\n";

    // =========================================================
    // Organization Members table
    // =========================================================
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

    // =========================================================
    // Research Submissions table (Pengajuan Penelitian Dosen)
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS research_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        fakultas VARCHAR(10) NULL,
        semester VARCHAR(10) NULL,
        tahun INTEGER NULL,
        nama_dosen VARCHAR(255) NULL,
        title VARCHAR(255) NOT NULL,
        abstract TEXT NULL,
        research_type VARCHAR(255) NULL,
        team_members TEXT NULL,
        sumber_dana VARCHAR(20) NULL,
        total_dana DECIMAL(15,0) NULL,
        kategori_luaran VARCHAR(100) NULL,
        status VARCHAR(50) DEFAULT 'pending',
        admin_notes TEXT NULL,
        rejection_reason TEXT NULL,
        assigned_to INTEGER NULL,
        reviewed_by INTEGER NULL,
        reviewed_at TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    // Tambah kolom baru jika belum ada
    $cols = array_column($pdo->query("PRAGMA table_info(research_submissions)")->fetchAll(PDO::FETCH_ASSOC), 'name');
    if (!in_array('fakultas', $cols))        $pdo->exec("ALTER TABLE research_submissions ADD COLUMN fakultas VARCHAR(10) NULL");
    if (!in_array('semester', $cols))        $pdo->exec("ALTER TABLE research_submissions ADD COLUMN semester VARCHAR(10) NULL");
    if (!in_array('tahun', $cols))           $pdo->exec("ALTER TABLE research_submissions ADD COLUMN tahun INTEGER NULL");
    if (!in_array('nama_dosen', $cols))      $pdo->exec("ALTER TABLE research_submissions ADD COLUMN nama_dosen VARCHAR(255) NULL");
    if (!in_array('sumber_dana', $cols))     $pdo->exec("ALTER TABLE research_submissions ADD COLUMN sumber_dana VARCHAR(20) NULL");
    if (!in_array('total_dana', $cols))      $pdo->exec("ALTER TABLE research_submissions ADD COLUMN total_dana DECIMAL(15,0) NULL");
    if (!in_array('kategori_luaran', $cols)) $pdo->exec("ALTER TABLE research_submissions ADD COLUMN kategori_luaran VARCHAR(100) NULL");
    if (!in_array('rejection_reason', $cols)) $pdo->exec("ALTER TABLE research_submissions ADD COLUMN rejection_reason TEXT NULL");
    if (!in_array('assigned_to', $cols))    $pdo->exec("ALTER TABLE research_submissions ADD COLUMN assigned_to INTEGER NULL");
    if (!in_array('reviewed_by', $cols))    $pdo->exec("ALTER TABLE research_submissions ADD COLUMN reviewed_by INTEGER NULL");
    if (!in_array('reviewed_at', $cols))    $pdo->exec("ALTER TABLE research_submissions ADD COLUMN reviewed_at TIMESTAMP NULL");
    echo "[OK] Tabel research_submissions\n";

    // =========================================================
    // PKM Submissions table (Pengajuan PKM Dosen)
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS pkm_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        fakultas VARCHAR(10) NULL,
        semester VARCHAR(10) NULL,
        tahun INTEGER NULL,
        nama_dosen VARCHAR(255) NULL,
        judul VARCHAR(255) NOT NULL,
        abstrak TEXT NOT NULL,
        sumber_dana VARCHAR(20) DEFAULT 'Internal',
        total_dana DECIMAL(15,0) NULL,
        pelaksanaan TEXT NULL,
        luaran_jurnal VARCHAR(100) NULL,
        sumber_dana_eksternal VARCHAR(255) NULL,
        team_members TEXT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        admin_notes TEXT NULL,
        rejection_reason TEXT NULL,
        assigned_to INTEGER NULL,
        reviewed_by INTEGER NULL,
        reviewed_at TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel pkm_submissions\n";

    // =========================================================
    // HKI Submissions table (Pengajuan HKI Dosen)
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS hki_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        fakultas VARCHAR(10) NULL,
        judul VARCHAR(255) NOT NULL,
        abstrak TEXT NOT NULL,
        jenis_hki VARCHAR(50) NOT NULL,
        tahun_pengajuan INTEGER NULL,
        tanggal_pengajuan DATE NULL,
        nomor_pendaftaran VARCHAR(100) NULL,
        team_members TEXT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        admin_notes TEXT NULL,
        rejection_reason TEXT NULL,
        assigned_to INTEGER NULL,
        reviewed_by INTEGER NULL,
        reviewed_at TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel hki_submissions\n";

    // =========================================================
    // Journal Submissions table (lama, dipertahankan)
    // =========================================================
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

    // =========================================================
    // Publikasis table (Luaran SINTA Dosen — Manual & API)
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS publikasis (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        judul VARCHAR(255) NOT NULL,
        abstrak TEXT NOT NULL,
        jenis_publikasi VARCHAR(50) NOT NULL,
        kategori_reputasi VARCHAR(255) NOT NULL,
        url_jurnal VARCHAR(255) NULL,
        url_repository VARCHAR(255) NULL,
        tahun_publikasi INTEGER NULL,
        nama_jurnal VARCHAR(255) NULL,
        volume_edisi VARCHAR(100) NULL,
        doi VARCHAR(255) NULL,
        sinta_id VARCHAR(100) NULL,
        scopus_id VARCHAR(100) NULL,
        garuda_id VARCHAR(100) NULL,
        sumber VARCHAR(30) DEFAULT 'manual',
        status_verifikasi VARCHAR(20) DEFAULT 'pending',
        catatan_admin TEXT NULL,
        verified_by INTEGER NULL,
        verified_at TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    // Tambah kolom baru jika belum ada (existing database)
    $cols = array_column($pdo->query("PRAGMA table_info(publikasis)")->fetchAll(PDO::FETCH_ASSOC), 'name');
    foreach ([
        'tahun_publikasi'  => 'INTEGER NULL',
        'nama_jurnal'      => 'VARCHAR(255) NULL',
        'volume_edisi'     => 'VARCHAR(100) NULL',
        'doi'              => 'VARCHAR(255) NULL',
        'sinta_id'         => 'VARCHAR(100) NULL',
        'scopus_id'        => 'VARCHAR(100) NULL',
        'garuda_id'        => 'VARCHAR(100) NULL',
        'sumber'           => "VARCHAR(30) DEFAULT 'manual'",
        'status_verifikasi'=> "VARCHAR(20) DEFAULT 'pending'",
        'catatan_admin'    => 'TEXT NULL',
        'verified_by'      => 'INTEGER NULL',
        'verified_at'      => 'TIMESTAMP NULL',
    ] as $col => $def) {
        if (!in_array($col, $cols)) {
            $pdo->exec("ALTER TABLE publikasis ADD COLUMN {$col} {$def}");
        }
    }
    echo "[OK] Tabel publikasis\n";

    // =========================================================
    // Pelaksanaans table
    // =========================================================
    $pdo->exec("CREATE TABLE IF NOT EXISTS pelaksanaans (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        jenis_kegiatan VARCHAR(50) NOT NULL,
        judul VARCHAR(255) NOT NULL,
        deskripsi_singkat TEXT NOT NULL,
        sumber_dana VARCHAR(255) NOT NULL,
        url VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");
    echo "[OK] Tabel pelaksanaans\n";

    // =========================================================
    // Failed jobs table
    // =========================================================
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
