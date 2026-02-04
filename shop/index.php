<?php
    require __DIR__ . '/../includes/header.php'; ?>
    <?php
require 'db.php';
$db=getDB();
$products=$db->query("SELECT * FROM products WHERE active=1");
?>
<link rel="stylesheet" href="../assets/css/style.css">
<h1>Shop – Holz und Mehr</h1>
<?php while($p=$products->fetchArray(SQLITE3_ASSOC)): ?>
<form method="post" action="order.php">
<h3><?=htmlspecialchars($p['name'])?></h3>
<p><?=htmlspecialchars($p['description'])?></p>
<strong><?=number_format($p['price'],2)?> €</strong>
<input type="hidden" name="product_id" value="<?=$p['id']?>">
<input name="name" placeholder="Ihr Name" required>
<input name="email" type="email" required>
<input name="qty" type="number" value="1" min="1">
<button>Bestellen</button>
</form><hr>
<?php endwhile; ?>
<?php
    require __DIR__ . '/../includes/footer.php'; ?>
    

