<?php
session_start();
if(!isset($_SESSION['gf'])) die("Kein Zugriff");
require '../db.php';
$db=getDB();
$r=$db->query("SELECT o.*,p.name product FROM orders o JOIN products p ON p.id=o.product_id");
?>
<h1>Bestellungen</h1>
<?php while($o=$r->fetchArray(SQLITE3_ASSOC)): ?>
<p><?=$o['product']?> – <?=$o['customer_name']?> – <?=$o['quantity']?></p>
<?php endwhile; ?>