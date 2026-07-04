<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * Auto-creates the SQLite database and all required tables
     * if they don't exist — works on any machine without manual setup.
     */
    public function boot(): void
    {
        $this->ensureSqliteDatabaseExists();
    }

    /**
     * Create the SQLite database file and all tables if they don't exist.
     */
    private function ensureSqliteDatabaseExists(): void
    {
        // Only run for SQLite connections
        if (config('database.default') !== 'sqlite') {
            return;
        }

        $dbPath = database_path('database.sqlite');

        // Create the SQLite file if it doesn't exist
        if (!file_exists($dbPath)) {
            touch($dbPath);
        }

        try {
            $pdo = new \PDO("sqlite:{$dbPath}");
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // Create all tables
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

            $pdo->exec("CREATE TABLE IF NOT EXISTS researches (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NULL,
                body TEXT NULL,
                thumbnail VARCHAR(255) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )");

            $pdo->exec("CREATE TABLE IF NOT EXISTS publications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NULL,
                body TEXT NULL,
                file VARCHAR(255) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )");

            $pdo->exec("CREATE TABLE IF NOT EXISTS community_services (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NULL,
                body TEXT NULL,
                thumbnail VARCHAR(255) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )");

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

            $pdo->exec("CREATE TABLE IF NOT EXISTS organization_members (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                position VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                photo VARCHAR(255) NULL,
                photo_position VARCHAR(50) DEFAULT 'center',
                sort_order INTEGER DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )");

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

            $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                migration VARCHAR(255) NOT NULL,
                batch INTEGER NOT NULL
            )");

            $pdo->exec("CREATE TABLE IF NOT EXISTS failed_jobs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                connection TEXT NOT NULL,
                queue TEXT NOT NULL,
                payload TEXT NOT NULL,
                exception TEXT NOT NULL,
                failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Seed default admin account if users table is empty
            $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
            if ($count == 0) {
                $now = date('Y-m-d H:i:s');
                $hash = password_hash('admin123', PASSWORD_BCRYPT);
                $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, 'admin', ?, ?)")
                    ->execute(['Administrator', 'admin@uca.ac.id', $hash, $now, $now]);
            }

            // Seed default org structure if empty
            $orgCount = $pdo->query("SELECT COUNT(*) FROM organization_members")->fetchColumn();
            if ($orgCount == 0) {
                $now = date('Y-m-d H:i:s');
                $defaults = [
                    [1, 'Rektor',                      '-', 1],
                    [2, 'Ketua LPPM',                  '-', 2],
                    [3, 'Kepala Pusat Penelitian',      '-', 3],
                    [4, 'Kepala Pusat Pengabdian',      '-', 4],
                    [5, 'Kepala Pusat Publikasi & HKI', '-', 5],
                ];
                $stmt = $pdo->prepare("INSERT INTO organization_members (id, position, name, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
                foreach ($defaults as $row) {
                    $stmt->execute([$row[0], $row[1], $row[2], $row[3], $now, $now]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail — Laravel will show its own DB error if something is wrong
        }
    }
}

