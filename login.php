<?php
session_start();
require __DIR__ . '/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();
    $user = trim($_POST['user']);
    $pass = $_POST['pass'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :u");
    $stmt->bindValue(':u', $user, SQLITE3_TEXT);
    $res = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($res && password_verify($pass, $res['password'])) {
        $_SESSION['user_id'] = $res['id'];
        $_SESSION['username'] = $res['username'];
        $_SESSION['role'] = strtoupper(trim($res['role']));
        header("Location: orders.php");
        exit;
    } else {
        $error = "❌ Benutzername oder Passwort falsch";
    }
}
require __DIR__ . '/includes/header.php';
?>

<link rel="stylesheet" href="/assets/css/style.css">

<form method="post">
    <input name="user" placeholder="Benutzername" required>
    <input name="pass" type="password" placeholder="Passwort" required>
    <button>Login</button>
    <br>
    <br>
    <br>
    
    <a href="/" class="btn">zur Startseite</a>
</form>
<br>
<br>



<?php if ($error): ?>
<div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
