<?php
/*header("Location:index2.php");
exit;*/
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Auftragssystem – Start</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="logo/favicon.ico">

    <!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="/assets/css/style.css">
</head>
<style>
.test {

            background: #000000;
            width: 100%;
            max-width: 320px; /* 👈 wichtig für „mittig“-Look */
            padding: 15px;
            margin: 10px 0;
            font-size: 16px;
            color: #fff;
            
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

</style>
<body>

<?php require __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <h1>Willkommen im Auftragssystem<br>der Schülerfirma Holz und Mehr</h1>

    <a href="customer.php" class="btn">Auftrag erstellen</a>
    <a href="infos.php" class="btn">Infos</a>
    <a href="" class="test">SHOP kommt noch</a>
    <a href="login.php" class="btn secondary">Mitarbeiter-Login</a>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
