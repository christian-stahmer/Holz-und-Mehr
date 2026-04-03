<?php
function getDB() {
    $path = __DIR__ . '/database.sqlite';

    if (!file_exists($path)) {
        die("Datenbank-Datei existiert nicht: $path");
    }

    $db = new SQLite3($path);

    // Tabellen prüfen
    $tables = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if (!$tables) die("Tabelle 'users' existiert nicht in der DB!");

    $tables = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='orders'");
    if (!$tables) die("Tabelle 'orders' existiert nicht in der DB!");

    return $db;
}
?>
