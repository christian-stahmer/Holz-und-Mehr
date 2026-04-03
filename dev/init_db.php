<?php
/**
 * init_db.php
 * Initialisiert die SQLite-Datenbank für das Projekt
 * ACHTUNG: Nur einmal ausführen!
 */

$dbFile = __DIR__ . '/data/dev.db'; // ggf. Pfad anpassen
$firstRun = !file_exists($dbFile);

/* Ordner anlegen, falls nicht vorhanden */
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

try {
    $db = new SQLite3($dbFile);
    $db->exec('PRAGMA foreign_keys = ON');

    /* USERS */
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    /* AUDIT */
    $db->exec("
        CREATE TABLE IF NOT EXISTS audit (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            user TEXT,
            action TEXT NOT NULL,
            file TEXT
        )
    ");

    /* DEV-USER beim ersten Start */
    if ($firstRun) {
        $stmt = $db->prepare("
            INSERT INTO users (username, password, role)
            VALUES (:u, :p, :r)
        ");
        $stmt->bindValue(':u', 'dev');
        $stmt->bindValue(':p', password_hash('dev123', PASSWORD_DEFAULT));
        $stmt->bindValue(':r', 'DEV');
        $stmt->execute();

        $db->exec("
            INSERT INTO audit (user, action, file)
            VALUES ('SYSTEM', 'Initiale Datenbank erstellt', 'init_db.php')
        ");
    }

    echo "<h2>✅ Datenbank erfolgreich initialisiert</h2>";

    if ($firstRun) {
        echo "<p><strong>DEV-Login:</strong> dev / dev123</p>";
        echo "<p style='color:red'><strong>⚠ Passwort nach dem ersten Login ändern!</strong></p>";
    }

} catch (Exception $e) {
    die("❌ Fehler beim Erstellen der DB: " . htmlspecialchars($e->getMessage()));
}
