<?php
session_start(); // ✅ IMMER ALS ERSTES

require __DIR__ . '/../../db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :u AND role = 'GF'");
    $stmt->bindValue(':u', $_POST['user'], SQLITE3_TEXT);
    $u = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($u && password_verify($_POST['pass'], $u['password'])) {

        // ✅ SAUBERE SESSION
        $_SESSION['id'] = $u['id'];
        $_SESSION['username'] = $u['username'];
        $_SESSION['role'] = $u['role'];
        $_SESSION['gf'] = true;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Login fehlgeschlagen";
    }
}
?>

<?php require __DIR__ . '/../../includes/header.php'; ?>

<link rel="stylesheet" href="/assets/css/style.css">

<form method="post">
    <h2>GF Login</h2>

    <input name="user" placeholder="Benutzer" required>
    <input name="pass" type="password" placeholder="Passwort" required>

    <button>Login</button>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</form>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
