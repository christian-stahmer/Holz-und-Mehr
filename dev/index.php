<?php
session_start();
if (!isset($_SESSION['dev'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>DEV Dashboard</title>
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>DEV-Dashboard</h1>

<ul>
    <li><a href="users.php">Benutzerverwaltung</a></li>
    <li><a href="audit.php">Audit-Logs</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
</body>
</html>
<?php
    require __DIR__ . '/../includes/footer.php'; ?>
    <?php
    require __DIR__ . '/../includes/header.php'; ?>

