<?php
require __DIR__ . '/includes/header.php';
?>
<?php
session_start();
require 'db.php';

 

if (!isset($_SESSION['u']) || $_SESSION['u']['role'] !== 'GF') {
    die('Kein Zugriff');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();

    $stmt = $db->prepare("
        INSERT INTO users (username, password, role)
        VALUES (:u, :p, :r)
    ");

    $stmt->bindValue(':u', $_POST['username'], SQLITE3_TEXT);
    $stmt->bindValue(':p', password_hash($_POST['password'], PASSWORD_DEFAULT), SQLITE3_TEXT);
    $stmt->bindValue(':r', $_POST['role'], SQLITE3_TEXT);

    $stmt->execute();

    echo "Benutzer erstellt";
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<h2>Neuen Benutzer anlegen</h2>
<form method="post">
    <input name="username" placeholder="Benutzername" required>
    <input name="password" type="password" placeholder="Passwort" required>

    <select name="role">
        <option value="GF">GF</option>
        <option value="Verwaltung">Verwaltung</option>
        <option value="Mitarbeiter">Mitarbeiter</option>
    </select>

    <button>Erstellen</button>
</form>
<?php
require __DIR__ . '/includes/footer.php'; 
?>