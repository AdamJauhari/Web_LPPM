<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
try {
    $pdo->exec("ALTER TABLE organization_members ADD COLUMN photo_position VARCHAR(50) DEFAULT 'center'");
    echo "OK - photo_position column added\n";
} catch (Exception $e) {
    echo "Column may already exist: " . $e->getMessage() . "\n";
}
