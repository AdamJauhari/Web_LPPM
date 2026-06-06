<?php
$pdo = new PDO('sqlite:database/database.sqlite');
$r = $pdo->query('SELECT id, name, email, role, password FROM users');
$rows = $r->fetchAll(PDO::FETCH_ASSOC);
echo "Total users: " . count($rows) . "\n";
foreach ($rows as $row) {
    echo "ID={$row['id']} | Name={$row['name']} | Email={$row['email']} | Role={$row['role']}\n";
}
