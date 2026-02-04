<?php
require 'db.php';
$db=getDB();
$s=$db->prepare("INSERT INTO orders (product_id,customer_name,customer_email,quantity,created_at)
VALUES (?,?,?,?,?)");
$s->bindValue(1,$_POST['product_id']);
$s->bindValue(2,$_POST['name']);
$s->bindValue(3,$_POST['email']);
$s->bindValue(4,$_POST['qty']);
$s->bindValue(5,date('c'));
$s->execute();
echo "Bestellung erfolgreich.";
?>