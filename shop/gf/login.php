<?php
session_start();
require '../../db.php';
$error='';
if($_POST){
$db=getDB();
$s=$db->prepare("SELECT * FROM users WHERE username=? AND role='GF'");
$s->bindValue(1,$_POST['user']);
$u=$s->execute()->fetchArray();
if($u && password_verify($_POST['pass'],$u['password'])){
$_SESSION['gf']=true;
header("Location: dashboard.php"); exit;
} else $error="Login fehlgeschlagen";
}
?>
<form method="post">
<input name="user" placeholder="Benutzer">
<input name="pass" type="password" placeholder="Passwort">
<button>Login</button>
<div style="color:red"><?=$error?></div>
</form>