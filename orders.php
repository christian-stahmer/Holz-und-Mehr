<a href="user_create.php">Benutzer anlegen</a><br><br>

<?php
session_start();
if (!isset($_SESSION['u'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';
require __DIR__ . '/lang.php';
require __DIR__ . '/includes/footer.php'; 

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $allowed = ['neu', 'in Arbeit', 'fertig'];

    if (in_array($_POST['status'], $allowed)) {
        $stmt = $db->prepare("
            UPDATE orders
            SET status = :status
            WHERE id = :id
        ");

        $stmt->bindValue(':status', $_POST['status'], SQLITE3_TEXT);
        $stmt->bindValue(':id', (int)$_POST['id'], SQLITE3_INTEGER);
        $stmt->execute();
    }
}

$result = $db->query("SELECT * FROM orders ORDER BY id DESC");
?>

<link rel="stylesheet" href="assets/css/style.css">

<h2><?=t('status')?></h2>

<?php while ($o = $result->fetchArray()): ?>
<form method="post">
    <b><?=htmlspecialchars($o['name'])?></b>

    <input type="hidden" name="id" value="<?=$o['id']?>">

    <select name="status">
        <option value="neu" <?=$o['status']=='neu'?'selected':''?>>neu</option>
        <option value="in Arbeit" <?=$o['status']=='in Arbeit'?'selected':''?>>in Arbeit</option>
        <option value="fertig" <?=$o['status']=='fertig'?'selected':''?>>fertig</option>
    </select>

    <button>Speichern</button>
</form>
<hr>
<?php endwhile; ?>

