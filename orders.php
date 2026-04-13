<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require __DIR__ . '/db.php';
$db = getDB();
require __DIR__ . '/includes/header.php';

/* POST: löschen oder Status ändern */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Auftrag löschen */
    if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];
        $stmt = $db->prepare("DELETE FROM orders WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    /* Status ändern */
    if (isset($_POST['status'], $_POST['id'])) {
        $allowed = ['neu', 'in Arbeit', 'fertig'];
        $status = $_POST['status'];
        $id = (int)$_POST['id'];

        if (in_array($status, $allowed, true)) {
            $stmt = $db->prepare("
                UPDATE orders SET status = :status WHERE id = :id
            ");
            $stmt->bindValue(':status', $status, SQLITE3_TEXT);
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $stmt->execute();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

/* Alle Bestellungen */
$result = $db->query("SELECT * FROM orders ORDER BY id DESC");
?>

<link rel="stylesheet" href="/assets/css/style.css">

<style>
    .butons
    {
        position: fixed;
        top: 10px;
    }
    .besellen
    {
        position: fixed;
        top: 250px;
        left:10px;
    
    }
</style>
<h2 class="besellen">Alle Bestellungen</h2>

<div class="butons" style="margin-bottom:15px;">
    <a href="user_create.php"><button>👤 Benutzer erstellen</button></a>
    <a href="/change_password.php"><button>🔑 Passwort ändern</button></a>
</div>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>Nummer</th>
        <th>Name</th>
        <th>E-Mail</th>
        <th>Produkt</th>
        <th>Menge</th>
        <th>beschreibung</th>
        <th>file</th>
        <th>Status</th>
        <th>Erstellt</th>
        <th>Aktionen</th>
    </tr>

<?php while ($o = $result->fetchArray(SQLITE3_ASSOC)): ?>
<tr>
    <td><?= $o['id'] ?></td>
    <td><?= htmlspecialchars($o['name']) ?></td>
    <td><?= htmlspecialchars($o['email'] ?? '-') ?></td>
    <td><?= htmlspecialchars($o['product'] ?? '-') ?></td>
    <td><?= htmlspecialchars($o['amount'] ?? '-') ?></td>
    <td><?= htmlspecialchars($o['description'] ?? '-') ?></td>
    <td><?php if (!empty($o['file'])): ?>
    <a href="uploads/<?= urlencode($o['file']) ?>" download>
        <?= htmlspecialchars($o['file']) ?>
    </a>
<?php else: ?>
    -
<?php endif; ?>
</td>

    
    <td>
        <form method="post">
            <input type="hidden" name="id" value="<?= $o['id'] ?>">
            <select name="status">
                <option value="neu" <?= $o['status']==='neu'?'selected':'' ?>>neu</option>
                <option value="in Arbeit" <?= $o['status']==='in Arbeit'?'selected':'' ?>>in Arbeit</option>
                <option value="fertig" <?= $o['status']==='fertig'?'selected':'' ?>>fertig</option>
            </select>
            <button>💾</button>
        </form>
    </td>
    <td><?= $o['created_at'] ?? '-' ?></td>
    <td>
        <form method="post" onsubmit="return confirm('Auftrag wirklich löschen?');">
            <button name="delete_id" value="<?= $o['id'] ?>">🗑 Löschen</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>

</table>

<?php require __DIR__ . '/includes/footer.php'; ?>
