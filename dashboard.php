<!-- WICHTIG für Handy -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
session_start(); if(!isset($_SESSION['u'])) header("Location: login.php");
 
 require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<h2>Dashboard (<?= $_SESSION['u']['role']?>)</h2>

<a href="orders.php">Aufträge</a> |
<a href="logout.php">Logout</a>
<?php
require __DIR__ . '/includes/footer.php'; 
?>