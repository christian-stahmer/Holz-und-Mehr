<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
session_start();


require __DIR__ . '/db.php';
$db = getDB();
require __DIR__ . '/includes/header.php';

$success = '';
$error = '';

// POST Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Benutzer löschen
    if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];

        // Sicherheitsabfrage: GF nicht löschen
        $check = $db->prepare("SELECT role FROM users WHERE id = :id");
        $check->bindValue(':id', $id, SQLITE3_INTEGER);
        $user = $check->execute()->fetchArray(SQLITE3_ASSOC);

        if ($user && $user['role'] !== 'GF') {
            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            if ($stmt->execute()) {
                $success = "✅ Benutzer erfolgreich gelöscht!";
            } else {
                $error = "Fehler beim Löschen: " . $db->lastErrorMsg();
            }
        } else {
            $error = "GF kann nicht gelöscht werden!";
        }
    }

    // Benutzer erstellen
    if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {

        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role = trim($_POST['role']);
        $allowedRoles = ['GF', 'Verwaltung', 'Mitarbeiter'];

        if ($username === '' || $password === '' || !in_array($role, $allowedRoles)) {
            $error = "Bitte alle Felder korrekt ausfüllen!";
        } else {
            $stmt = $db->prepare("INSERT INTO users (username,password,role) VALUES (:u,:p,:r)");
            $stmt->bindValue(':u', $username, SQLITE3_TEXT);
            $stmt->bindValue(':p', password_hash($password, PASSWORD_DEFAULT), SQLITE3_TEXT);
            $stmt->bindValue(':r', $role, SQLITE3_TEXT);

            if ($stmt->execute()) {
                $success = "✅ Benutzer '$username' erfolgreich erstellt!";
            } else {
                $error = "Fehler: Benutzer existiert evtl. bereits.";
            }
        }
    }
}

// Alle Benutzer laden
$users = $db->query("SELECT * FROM users ORDER BY id ASC");
?>


<link rel="stylesheet" href="/assets/css/style.css">
<div class="dashboard-wrapper">

    <div class="left-area">
        <h2>Benutzerverwaltung</h2>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Benutzer erstellen -->
        <form method="post" class="card">
            <input name="username" placeholder="Benutzername" required>
            <input name="password" type="password" placeholder="Passwort" required>
            <select name="role" required>
                <option value="GF">GF</option>
                <option value="Verwaltung">Verwaltung</option>
                <option value="Mitarbeiter">Mitarbeiter</option>
            </select>
            <button class="btn-green">Benutzer erstellen</button>
        </form>
    </div>

    <div class="right-area">
        <h3>Bestehende Benutzer</h3>

        <?php while ($u = $users->fetchArray(SQLITE3_ASSOC)): ?>
        <form method="post" class="user-row">
            <span>
                <?= htmlspecialchars($u['username']) ?> 
                (<?= htmlspecialchars($u['role']) ?>)
            </span>

            <?php if ($u['role'] !== 'GF'): ?>
                <button type="submit"
                        name="delete_id"
                        value="<?= $u['id'] ?>"
                        class="btn-red"
                        onclick="return confirm('Benutzer wirklich löschen?');">
                    Löschen
                </button>
            <?php endif; ?>
        </form>
        <?php endwhile; ?>

    </div>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
