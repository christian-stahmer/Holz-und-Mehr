<?php
// support.php
$to = "dev.holzundmehr@gmail.com";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { max-width: 400px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; }
        .btn-mail { display: inline-block; padding: 15px 25px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        #page-info { margin-top: 15px; font-size: 0.8em; color: #777; font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <h2>Fehler melden</h2>
    <p>Klicken Sie unten, um das E-Mail Programm zu öffnen.</p>
    
    <a href="#" id="mailLink" class="btn-mail">E-Mail Programm öffnen</a>
    
    <div id="page-info">Erkannte Seite: <span id="detectedPage">Lade...</span></div>
</div>

<script>
    // Die Adresse, von der der User kam (Referrer)
    const referrer = document.referrer || "Direkter Aufruf / Unbekannt";
    const emailRecipient = "<?php echo $to; ?>";
    const subject = "Fehler/bug auf der Seite [" + referrer + "]";
    
    // Den Link dynamisch bauen
    const mailtoUrl = "mailto:" + emailRecipient + "?subject=" + encodeURIComponent(subject);
    
    // HTML-Elemente aktualisieren
    const linkElement = document.getElementById('mailLink');
    linkElement.href = mailtoUrl;
    document.getElementById('detectedPage').textContent = referrer;
</script>

</body>
</html>