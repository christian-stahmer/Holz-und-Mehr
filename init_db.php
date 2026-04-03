<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');

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
    status TEXT DEFAULT 'neu',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");
$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    price INTEGER,
    description TEXT
)");

$hash = password_hash('J()göm)u(sNLMf~RcÖsYPM&qLä#CXp,v', PASSWORD_DEFAULT);
$db->exec("INSERT OR IGNORE INTO users (username,password,role,must_change)
VALUES ('Christian(dev)','$hash','GF',1)");
$hash = password_hash('"zHädNbkfem6~~tZfÖfg(@ÖwZU9!AqsZ@vRyC3AU7bF"', PASSWORD_DEFAULT);
$db->exec("INSERT OR IGNORE INTO users (username,password,role,must_change)
VALUES ('lm','$hash','GF',1)");

echo 'Datenbank initialisiert';
?>
