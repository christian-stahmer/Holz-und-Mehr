<?php
function getDB() {
    static $db = null;

    if ($db === null) {
        $db = new SQLite3(__DIR__ . '/data/dev.db');
        $db->exec('PRAGMA foreign_keys = ON');
    }

    return $db;
}
