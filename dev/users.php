<?php
session_start();
if (!isset($_SESSION['dev'])) die("Kein Zugriff");

require 'db.php';
$db = getDB();

/* User anlegen */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $stmt = $db->prepare("
        INSERT INTO users (username, password, role)
        VALUES (:u, :p, :r)
    ");
    $stmt->bindValue(':u', $username);
    $stmt->bindValue(':p', $password);
    $stmt->bindValue(':r', $role);
    $stmt->execute();

    $db->exec("INSERT INTO audit (action)
               VALUES ('User erstellt: $username ($role)')");
}

/* User laden */
$users = $db->query("SELECT username, role FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Benutzerverwaltung</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Benutzerverwaltung</h1>

<h2>Neuen Benutzer erstellen</h2>
<form method="post">
    <input name="username" placeholder="Benutzername" required>
    <input type="password" name="password" placeholder="Passwort" required>
    <select name="role">
        <option value="mitarbeiter">Mitarbeiter</option>
        <option value="admin">Admin</option>
        <option value="dev">Dev</option>
    </select>
    <button>Benutzer erstellen</button>
</form>

<h2>Bestehende Benutzer</h2>
<ul>
<?php while ($u = $users->fetchArray(SQLITE3_ASSOC)): ?>
    <li><?= htmlspecialchars($u['username']) ?> (<?= $u['role'] ?>)</li>
<?php endwhile; ?>
</ul>

<a href="index.php">← Zurück</a>

</body>
</html>
<?php
    require __DIR__ . '/../includes/footer.php'; ?>
    <?php
    require __DIR__ . '/../includes/header.php'; ?>

