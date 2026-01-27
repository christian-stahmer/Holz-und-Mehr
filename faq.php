<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>FAQ – Auftragssystem</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/logo/favicon.ico">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #121212;
            color: #ffffff;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .faq-item {
            margin-bottom: 20px;
        }

        .faq-question {
            font-weight: bold;
            cursor: pointer;
            padding: 15px;
            background: #2a2a2a;
            border-radius: 6px;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background: #191919;
            border-left: 3px solid #2d89ef;
            margin-top: 5px;
            border-radius: 0 0 6px 6px;
        }

        .back {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #2d89ef;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>

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

    <a href="/index.php" class="back">← Zurück zur Startseite</a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
