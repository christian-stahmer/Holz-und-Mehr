<?php
$db = new SQLite3('database.sqlite');

$db->exec("CREATE TABLE IF NOT EXISTS users (
 id INTEGER PRIMARY KEY AUTOINCREMENT,
 username TEXT UNIQUE,
 password TEXT,
 role TEXT,
 must_change INTEGER
)");

$db->exec("CREATE TABLE IF NOT EXISTS orders (
 id INTEGER PRIMARY KEY AUTOINCREMENT,
 name TEXT,
 email TEXT,
 description TEXT,
 amount INTEGER,
 file TEXT,
 status TEXT,
 created_at TEXT
)");

$hash = password_hash('admin123', PASSWORD_DEFAULT);
$db->exec("INSERT OR IGNORE INTO users (username,password,role,must_change)
VALUES ('admin','$hash','GF',1)");

echo 'Datenbank initialisiert';
?>