<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>FAQ – Auftragssystem</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/logo/favicon.jpg">

    <link rel="stylesheet" href="/assets/css/style.css">

    <script>
        function toggleFAQ(id) {
            const el = document.getElementById(id);
            el.style.display = el.style.display === "block" ? "none" : "block";
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Häufig gestellte Fragen (FAQ)</h1>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ('a1')">
            Wie kann ich einen Auftrag erstellen?
        </div>
        <div class="faq-answer" id="a1">
            Über den Button „Auftrag erstellen“ auf der Startseite können Sie das Formular ausfüllen und absenden.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ('a2')">
            Welche Dateien kann ich hochladen?
        </div>
        <div class="faq-answer" id="a2">
            Es können Baupläne und Zeichnungen als PDF, JPG oder PNG hochgeladen werden.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ('a3')">
            Wie erfahre ich, wenn mein Auftrag fertig ist?
        </div>
        <div class="faq-answer" id="a3">
            Sobald der Status Ihres Auftrags auf „fertig“ gesetzt wird, erhalten Sie  eine E-Mail.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ('a4')">
            Wer kann meine Daten einsehen?
        </div>
        <div class="faq-answer" id="a4">
            Ihre Daten sind nur für autorisierte Mitarbeiter der Schülerfirma Holz und Mehr einsehbar.
        </div>
    </div>

    <a href="/index.php" class="btn">← Zurück zur Startseite</a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
