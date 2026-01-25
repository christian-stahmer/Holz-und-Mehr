<?php
session_start(); require 'db.php';
require __DIR__ . '/includes/footer.php'; 
 require __DIR__ . '/includes/header.php';

if($_POST){
 $db=getDB();
 $s=$db->prepare("SELECT * FROM users WHERE username=?");
 $s->bindValue(1,$_POST['user']); $r=$s->execute()->fetchArray();
 if($r && password_verify($_POST['pass'],$r['password'])){
   $_SESSION['u']=$r;
   header("Location: dashboard.php"); exit;
 }
}
?>
<link rel="stylesheet" href="assets/css/style.css">
<form method="post">
<h2>Login</h2>
<input name="user" placeholder="Benutzername">
<input name="pass" type="password" placeholder="Passwort">
<button>Login</button>
</form>
