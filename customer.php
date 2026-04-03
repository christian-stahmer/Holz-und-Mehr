<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
require __DIR__ . '/includes/header.php';

// Serverseitige Limits
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Prüfen, ob eine Datei hochgeladen wurde
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

        // 1 GB Limit
        if ($_FILES['file']['size'] > 1024 * 1024 * 1024) {
            echo "<p style='color:red;'>Die Datei ist zu groß. Maximal 1 GB erlaubt.</p>";
        } else {
            // Upload-Ordner erstellen, falls nicht vorhanden
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $file = time() . '_' . basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $file);

            // DB-Verbindung
            require 'db.php';
            $db = getDB();

            $stmt = $db->prepare("
                INSERT INTO orders
                (name, email, description, amount, file, status, created_at)
                VALUES (:name, :email, :desc, :amount, :file, 'neu', :created)
            ");

            $stmt->bindValue(':name', $_POST['name'], SQLITE3_TEXT);
            $stmt->bindValue(':email', $_POST['email'], SQLITE3_TEXT);
            $stmt->bindValue(':desc', $_POST['desc'], SQLITE3_TEXT);
            $stmt->bindValue(':amount', (int)$_POST['amount'], SQLITE3_INTEGER);
            $stmt->bindValue(':file', $file, SQLITE3_TEXT);
            $stmt->bindValue(':created', date('c'), SQLITE3_TEXT);

            $stmt->execute();

            echo "<p style='color:green;'>Auftrag erfolgreich gesendet.</p>";
        }

    } else {
        echo "<p style='color:red;'>Es wurde keine Datei hochgeladen.</p>";
    }
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<form method="post" enctype="multipart/form-data" id="orderForm">
    <title>Auftrag</title>
    <h2>Auftrag</h2>
    <input name="name" placeholder="Name" required>
    <input name="email" type="email" placeholder="E-Mail" required>
    <textarea name="desc" placeholder="Auftragsbeschreibung"></textarea>
    <input name="amount" type="number" placeholder="Stückzahl">
    <label class="file-label">
        Bauplan hochladen
        <input type="file" name="file" id="fileInput">
    </label>
    <button>Senden</button>
</form>

<script>
// Clientseitige 1 GB-Prüfung
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const file = document.getElementById('fileInput').files[0];
    if (file && file.size > 1024 * 1024 * 1024) 
});
</script>

<?php
require __DIR__ . '/includes/footer.php'; 
?>
