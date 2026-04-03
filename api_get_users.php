<?php
header('Content-Type: application/json');

$API_KEY = "GPi4a9aOdo6auB";

$clientKey = $_GET['api_key'] ?? '';

if ($clientKey !== $API_KEY) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$db = new SQLite3('database.sqlite');

$result = $db->query("SELECT id, username FROM users");

$users = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $users[] = $row;
}

echo json_encode($users);
?>