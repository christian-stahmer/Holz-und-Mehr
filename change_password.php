<?php
// Fehleranzeigen aktivieren (nur für Entwicklung)
 //ini_set('display_errors', 1);
 //error_reporting(E_ALL);

// Session starten ganz oben
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// DB einbinden
require __DIR__ . '/db.php';
$db = getDB();

/* Benutzer laden */
$stmt = $db->prepare("SELECT id, password FROM users WHERE id = :id");
$stmt->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
$user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (!password_verify($old, $user['password'])) {
        $error = "❌ Altes Passwort ist falsch.";
    } elseif ($new !== $confirm) {
        $error = "❌ Passwörter stimmen nicht überein.";
    } elseif (strlen($new) < 6) {
        $error = "❌ Passwort muss mindestens 6 Zeichen haben.";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE users SET password = :p WHERE id = :id");
        $stmt->bindValue(':p', $hash, SQLITE3_TEXT);
        $stmt->bindValue(':id', $user['id'], SQLITE3_INTEGER);
        $stmt->execute();

        $message = "✅ Passwort erfolgreich geändert.";
    }
}

// Header einbinden **nachdem keine Änderungen mehr an Session oder Headern gemacht werden**
require __DIR__ . '/includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Passwort ändern</title>
<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="center-box">

    <h2>Passwort ändern</h2>

    <?php if($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if($message): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="password" name="old_password" placeholder="Altes Passwort" required>
        <input type="password" name="new_password" placeholder="Neues Passwort" required>
        <input type="password" name="confirm_password" placeholder="Neues Passwort wiederholen" required>

        <button type="submit" class="btn-green">Passwort ändern</button>
    </form>

    <a href="orders.php" class="back-link">← Zurück</a>

</div>
</body>
</html>
<?php
require __DIR__ . '/includes/footer.php'; 
?>
