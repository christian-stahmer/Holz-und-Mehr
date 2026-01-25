<?php

 require __DIR__ . '/includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $file = time() . '_' . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $file);

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

    echo "<p>Auftrag erfolgreich gesendet.</p>";
}
?>

<link rel="stylesheet" href="assets/css/style.css">
<form method="post" enctype="multipart/form-data">
<h2>Auftrag</h2>
<input name="name" placeholder="Name" required>
<input name="email" type="email" placeholder="E-Mail" required>
<textarea name="desc" placeholder="Auftragsbeschreibung"></textarea>
<input name="amount" type="number" placeholder="Stückzahl">
<input type="file" name="file">
<button>Senden</button>
</form>
<?php
require __DIR__ . '/includes/footer.php'; 
?>