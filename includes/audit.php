<?php
function audit_log(string $action) {
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once __DIR__ . '/../dev/db.php';
    $db = getDB();

    $stmt = $db->prepare("
        INSERT INTO audit (user, action, file)
        VALUES (:u, :a, :f)
    ");

    $stmt->bindValue(':u', $_SESSION['username'] ?? 'SYSTEM');
    $stmt->bindValue(':a', $action);
    $stmt->bindValue(':f', realpath(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file']));
    $stmt->execute();
}
