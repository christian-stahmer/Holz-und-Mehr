<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/db.php';
$db = getDB();
require __DIR__ . '/includes/header.php';

$success = '';
$error = '';

// POST Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- BENUTZER LÖSCHEN ---
    if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];

        // Sicherheitsabfrage: username UND role prüfen
        $check = $db->prepare("SELECT username, role FROM users WHERE id = :id");
        $check->bindValue(':id', $id, SQLITE3_INTEGER);
        $res = $check->execute()->fetchArray(SQLITE3_ASSOC);

        if ($res) {
            $isDev = (strpos($res['username'], '(dev)') !== false);
            $isOrga = ($res['role'] === 'ORGANIZATION');

            if (!$isDev && !$isOrga) {
                $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
                $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
                
                if ($stmt->execute()) {
                    $success = "✅ Benutzer erfolgreich gelöscht!";
                    
                    // NEU: Wenn man sich selbst gelöscht hat -> Abmelden
                    if (isset($_SESSION['user_id']) && $id === (int)$_SESSION['user_id']) {
                        session_destroy();
                        header("Location: login.php?msg=self_deleted");
                        exit;
                    }
                } else {
                    $error = "Fehler beim Löschen: " . $db->lastErrorMsg();
                }
            } else {
                $error = "Entwickler oder ORGANIZATION-Accounts dürfen nicht gelöscht werden!";
            }
        }
    } 

    // --- BENUTZER ERSTELLEN ---
    if (isset($_POST['username'], $_POST['password'], $_POST['role']) && !isset($_POST['delete_id'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role = trim($_POST['role']);
        $allowedRoles = ['GF', 'Verwaltung', 'Mitarbeiter'];

        if ($username === '' || $password === '' || !in_array($role, $allowedRoles)) {
            $error = "Bitte alle Felder korrekt ausfüllen!";
        } else {
            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:u, :p, :r)");
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

<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <form method="post" class="card">
            <input name="username" placeholder="Benutzername" required>
            <input name="password" type="password" placeholder="Passwort" required>
            <select name="role" required>
                <option value="GF">GF</option>
                <option value="Verwaltung">Verwaltung</option>
                <option value="Mitarbeiter">Mitarbeiter</option>
                <option value="ORGANIZATION" disabled>ORGANIZATION (nur intern)</option>
                <option value="dev" disabled>dev (nur intern)</option>
            </select>
            <button class="btn-green">Benutzer erstellen</button>
            <br><br>
            <a href="orders.php" class="back-link">← Zurück</a>
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

                <?php 
                // Button ausblenden bei (dev) ODER Rolle ORGANIZATION
                $isProtected =($u['role'] === 'dev' || $u['role'] === 'ORGANIZATION');
                if (!$isProtected): 
                ?>
                    <button type="submit" name="delete_id" value="<?= $u['id'] ?>" class="btn-red" onclick="return confirm('Wirklich löschen?');">
                        Löschen
                    </button>
                <?php endif; ?>
            </form>
        <?php endwhile; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>