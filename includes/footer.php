
<footer class="footer">
    
    <a href="/recht/impressum.php">Impressum</a> ·
    <a href="/recht/datenschutz.php">Datenschutz</a> ·
    <a href="/recht/agb.php">AGB</a> ·
    <a href="/danke/">Danksagung</a> ·
    <a href="/faq.php/">Fragen   </a>·
    <a href="#" id="supportBtn">Fehler melden</a>
    <br>
    © <?= date('Y') ?> Holz und Mehr
</footer>

   <!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

<style>
    .footer {
        left: 0;
    position: fixed;
    bottom: 15px;
    width: 100%;
    text-align: center;
    font-size: 13px;
    color: #aaa;
}
.footer a {
    color: #4da3ff;
    text-decoration: none;
}
.footer a:hover {
    text-decoration: underline;
}

</style>


<script>
    document.getElementById('supportBtn').addEventListener('click', function(e) {
        // Verhindert, dass der Browser einfach nur nach oben springt
        e.preventDefault();

        // 1. Die EXAKTE aktuelle URL der Seite abgreifen
        const currentPageUrl = window.location.href;

        // 2. Konfiguration der E-Mail
        const emailTo = "dev.holzundmehr@gmail.com";
        const subject = "Fehler/bug auf der Seite [" + currentPageUrl + "]";
        const bodyText = "dein Problem:\n\n";

        // 3. Den Mailto-Link generieren (mit korrekter Codierung für Leerzeichen/Sonderzeichen)
        const mailtoLink = "mailto:" + emailTo 
            + "?subject=" + encodeURIComponent(subject) 
            + "&body=" + encodeURIComponent(bodyText);

        // 4. E-Mail Programm öffnen
        window.location.href = mailtoLink;
    });
</script>