<?php
session_start();
if(!isset($_SESSION['gf'])) exit;
require '../db.php';
if($_POST){
$db=getDB();
$s=$db->prepare("INSERT INTO products (name,description,price,active) VALUES (?,?,?,1)");
$s->bindValue(1,$_POST['name']);
$s->bindValue(2,$_POST['desc']);
$s->bindValue(3,$_POST['price']);
$s->execute();
}
?>
<form method="post">
<input name="name" placeholder="Name">
<textarea name="desc"></textarea>
<input name="price" type="number" step="0.01">
<button>Speichern</button>
</form>