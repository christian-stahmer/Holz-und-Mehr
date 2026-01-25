<?php
$lang = $_GET['lang'] ?? 'de';

$file = __DIR__ . '/lang/' . $lang . '.php';

if (!file_exists($file)) {
    $file = __DIR__ . '/lang/de.php';
}

$T = require $file;

function t(string $key): string {
    global $T;
    return $T[$key] ?? $key;
}
