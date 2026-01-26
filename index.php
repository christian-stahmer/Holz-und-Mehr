<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Auftragssystem – Start</title>

    <!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <?php
require __DIR__ . '/includes/header.php';
?>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #252424;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 15px;
        }

        .container {
            background: #272727;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 0 15px rgba(19, 18, 18, 0.5);
        }

        h1 {
            margin-bottom: 25px;
            font-size: 22px;
            line-height: 1.4;
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
            border-radius: 6px;
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

        /* Handy-Optimierung */
        @media (max-width: 480px) {
            h1 {
                font-size: 18px;
            }
            .btn {
                font-size: 15px;
                padding: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Willkommen im Auftragssystem<br>der Schülerfirma Holz und Mehr</h1>

    <a href="customer.php" class="btn">Auftrag erstellen</a>
    <a href="login.php" class="btn secondary">Mitarbeiter-Login</a>
</div>

<?php
require __DIR__ . '/includes/footer.php';
?>

</body>
</html>
