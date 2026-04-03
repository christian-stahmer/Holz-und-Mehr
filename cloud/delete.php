<?php

$file = "uploads/" . $_GET['file'];

unlink($file);

header("Location: dashboard.php");

?>