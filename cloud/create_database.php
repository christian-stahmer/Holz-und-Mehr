<?php

$file = __DIR__ . "/../database.sqlite";

if(file_exists($file)){
    echo "DB gefunden: " . $file;
}else{
    echo "DB NICHT gefunden";
}

?>