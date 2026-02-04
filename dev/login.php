<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();

    $s = $db->prepare("SELECT * FROM users WHERE username = ?");
    $s->bindValue(1, $_POST['user'], SQLITE3_TEXT);
    $r = $s->execute()->fetchArray(SQLITE3_ASSOC);

    if ($r && password_verify($_POST['pass'], $r['password'])) {
        $_SESSION['u'] = $r;
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Benutzername oder Passwort falsch";
    }
}
?>

<?php require __DIR__ . '/../includes/header.php'; ?>

<form method="post" class="login-box">
    <h2>Login</h2>

    <input name="user" placeholder="Benutzername" required>
    <input name="pass" type="password" placeholder="Passwort" required>

    <button type="submit">Login</button>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</form>

<?php require __DIR__ . '/../includes/footer.php'; ?>
