<?php
header('Content-Type: application/json');

$API_KEY = "GPi4a9aOdo6auB";

echo json_encode([
    "expected_key" => $API_KEY,
    "get_key" => $_GET['api_key'] ?? null,
]);
?>