<?php
require __DIR__ . '/includes/footer.php'; 
require __DIR__ . '/includes/test.php';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="icon" type="image/png" href="logo/logo.png">

    <meta charset="UTF-8">
    <title>Auftragssystem – Start</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #1e1e1e;
            padding: 40px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }

        h1 {
            margin-bottom: 30px;
            font-size: 24px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            font-size: 16px;
            color: #fff;
            background: #2d89ef;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #1b5fa7;
        }

        .btn.secondary {
            background: #444;
        }

        .btn.secondary:hover {
            background: #666;
        }

        
    </style>
</head>
<body>

<div class="container">
    <h1>Willkommen im Auftragssystem von der Schülerfirma Holz und Mehr</h1>

    <a href="customer.php" class="btn">
        Auftrag erstellen
    </a>

    <a href="login.php" class="btn secondary">
        Mitarbeiter-Login
    </a>

   
</div>

</body>
</html>
