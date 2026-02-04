<?php
session_start();
$error = ""; // <<< WICHTIG
 require 'db.php';
require __DIR__ . '/includes/header.php'; 
 

if($_POST){
 $db=getDB();
 $s=$db->prepare("SELECT * FROM users WHERE username=?");
 $s->bindValue(1,$_POST['user']); $r=$s->execute()->fetchArray();
 if($r && password_verify($_POST['pass'],$r['password'])){
   $_SESSION['u']=$r;
   header("Location: dashboard.php"); exit;
 }
 else {
    
        $error = "❌ Benutzername oder Passwort falsch";
    
    }
}
?>
<style>
  .error {
    background: #ffdddd;
    color: #900;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #cc0000;
    border-radius: 5px;
}
</style>


<link rel="stylesheet" href="/assets/css/style.css">
<form method="post">
<h2>Login</h2>
<title>lOGIN</title>
<input name="user" placeholder="Benutzername">
<input name="pass" type="password" placeholder="Passwort">
<button>Login</button>
<?php if ($error): ?>
<div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
</form>
<?php
require __DIR__ . '/includes/footer.php'; 
?>