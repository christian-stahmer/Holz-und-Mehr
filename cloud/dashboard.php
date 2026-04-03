<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: index.php");
exit;
}
?>

<html>
<head>
<title>Cloud</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1>☁️ Meine Cloud</h1>

<a href="logout.php">Logout</a>

<h3>Datei hochladen</h3>

<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<button>Upload</button>
</form>

<h3>Dateien</h3>

<?php

$files = scandir("uploads");

foreach($files as $file){

if($file != "." && $file != ".."){

echo "

<div class='file'>

📄 $file

<a href='download.php?file=$file'>Download</a>

<a href='delete.php?file=$file'>Delete</a>

</div>

";

}

}

?>

</body>
</html>