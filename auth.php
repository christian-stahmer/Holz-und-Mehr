<link rel="stylesheet" href="/assets/css/style.css">
<?php
session_start();

/**
 * Erlaubt bestimmte Rollen
 * Beispiel: requireRole(['mitarbeiter', 'admin', 'dev']);
 */

function requireRole(array $roles) {
    if (
        !isset($_SESSION['user_id']) ||
        !isset($_SESSION['role']) ||
        !in_array($_SESSION['role'], $roles, true)
    ) {
        header("Location: login.php");
        exit;
    }
}
