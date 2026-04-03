<?php

$file = "uploads/" . $_GET['file'];

header('Content-Disposition: attachment; filename="'.basename($file).'"');
readfile($file);

?>