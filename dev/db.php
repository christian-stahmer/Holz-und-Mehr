<?php
function getDB() {
    $db = new SQLite3(__DIR__ . '/data/dev.db');

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            password TEXT,
            role TEXT
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS audit (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            action TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $exists = $db->querySingle("SELECT COUNT(*) FROM users WHERE role = 'dev'");
    if ($exists == 0) {
        $db->exec("
            INSERT INTO users (username, password, role)
            VALUES (
                'dev',
                '" . password_hash('dev123', PASSWORD_DEFAULT) . "',
                'dev'
            )
        ");
    }

    return $db;
}
