<?php
session_start(); // ✅ IMMER ZUERST



require __DIR__ . '/../../db.php';
$db = getDB();
?>

<?php require __DIR__ . '/../../includes/header.php'; ?>

<link rel="stylesheet" href="/../../assets/css/style.css">

<h1>Bestellungen</h1>

<?php
$sql = "
SELECT 
    o.id,
    o.quantity,
    o.customer_name,
    p.name AS product
FROM orders o
LEFT JOIN products p ON p.id = o.product_id
ORDER BY o.id DESC
";

$result = $db->query($sql);

while ($o = $result->fetchArray(SQLITE3_ASSOC)):
?>
    <p>
        <b><?= htmlspecialchars($o['product'] ?? 'Unbekannt') ?></b> –
        <?= htmlspecialchars($o['customer_name']) ?> –
        Menge: <?= (int)$o['quantity'] ?>
    </p>
<?php endwhile; ?>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
