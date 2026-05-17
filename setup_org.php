<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$pdo->exec("CREATE TABLE IF NOT EXISTS organization_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    position VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NULL,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
)");

// Insert default data
$count = $pdo->query("SELECT COUNT(*) FROM organization_members")->fetchColumn();
if ($count == 0) {
    $members = [
        ['Rektor', '-', null, 1],
        ['Ketua LPPM', '-', null, 2],
        ['Kepala Pusat Penelitian', '-', null, 3],
        ['Kepala Pusat Pengabdian', '-', null, 4],
        ['Kepala Pusat Publikasi & HKI', '-', null, 5],
    ];
    $stmt = $pdo->prepare("INSERT INTO organization_members (position, name, photo, sort_order, created_at, updated_at) VALUES (?,?,?,?,datetime('now'),datetime('now'))");
    foreach ($members as $m) {
        $stmt->execute($m);
    }
    echo "Default members inserted\n";
}
echo "OK - organization_members table ready\n";
