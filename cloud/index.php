<?php
session_start();

$db = new PDO("sqlite:" . __DIR__ . "/../database.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['login'])){

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row && password_verify($pass, $row['password'])){
        $_SESSION['user'] = $row['username'];
        header("Location: dashboard.php");
        exit;
    }else{
        $error = "Login falsch";
    }
}
?>


<html>
<head>
<title>Cloud Login</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login">
<h2>☁️ Cloud Login</h2>

<?php if(isset($error)) echo $error; ?>

<form method="post">
<input type="text" name="user" placeholder="Username"><br>
<input type="password" name="pass" placeholder="Passwort"><br>
<button name="login">Login</button>
</form>

</div>

</body>
</html>