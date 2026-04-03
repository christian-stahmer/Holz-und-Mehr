<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
// support.php

// Empfänger-Mail
$to = "dev.holzundmehr@gmail.com";

// Name der aktuellen Seite (kann dynamisch aus GET-Parameter oder Session kommen)
$pageName = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : "Unbekannte Seite";

// Prüfen, ob Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    if ($userEmail && !empty($message)) {
        $subject = "Support [" . $pageName . "]";
        $headers = "From: " . $userEmail . "\r\n" .
                   "Reply-To: " . $userEmail . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $success = "Ihre Nachricht wurde erfolgreich gesendet!";
        } else {
            $error = "Fehler beim Senden der Nachricht.";
        }
    } else {
        $error = "Bitte gültige E-Mail und Nachricht eingeben.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Support</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 50px; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background-color: #007BFF; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Support</h2>
        <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <label for="email">Ihre E-Mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="message">Nachricht:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">Senden</button>
        </form>
    </div>
</body>
</html>