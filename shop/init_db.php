<?php
$db = new SQLite3(__DIR__ . '/data.sqlite');

/* USERS */
$db->exec("
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    role TEXT
);
");

/* PRODUCTS */
$db->exec("
CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    description TEXT,
    price REAL,
    active INTEGER DEFAULT 1
);
");

/* ORDERS */
$db->exec("
CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    customer_name TEXT,
    customer_email TEXT,
    quantity INTEGER,
    created_at TEXT
);
");

/* STANDARD GF USER */
$pw = password_hash("gf123", PASSWORD_DEFAULT);
$db->exec("
INSERT OR IGNORE INTO users (username,password,role)
VALUES ('gf','$pw','GF');
");

echo "✅ Datenbank erfolgreich erstellt!";
