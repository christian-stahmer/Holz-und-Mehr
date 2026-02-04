<?php
    require __DIR__ . '/../includes/header.php'; ?>
<?php

session_start();
if (!isset($_SESSION['dev'])) die("Kein Zugriff");

require 'db.php';
$db = getDB();
$logs = $db->query("SELECT * FROM audit ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Audit-Logs</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Audit-Logs</h1>

<ul>
<?php while ($l = $logs->fetchArray(SQLITE3_ASSOC)): ?>
    <li><?= $l['created_at'] ?> – <?= htmlspecialchars($l['action']) ?></li>
<?php endwhile; ?>
</ul>

<a href="index.php">← Zurück</a>
</body>
</html>
<?php
    require __DIR__ . '/../includes/footer.php'; ?>

