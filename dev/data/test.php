<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


echo '<pre>';
print_r($_SESSION);
echo '</pre>';
if (!is_array($_SESSION['u'])) {
    // Session existiert nicht korrekt → Login
    header("Location: /dev/login.php");
  #  exit;
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>DEV Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require __DIR__ . '/../includes/header.php'; ?>

<h1>DEV-Dashboard</h1>

<p>Angemeldet als: <strong><?= htmlspecialchars($user['username']) ?></strong></p>

<ul>
    <li><a href="users.php">Benutzerverwaltung</a></li>
    <li><a href="audit.php">Audit-Logs</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
