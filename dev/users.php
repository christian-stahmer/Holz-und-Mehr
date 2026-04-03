<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'DEV') {
    header("Location: index.php");
    exit;
}

require 'db.php';
require __DIR__ . '/../includes/header.php';

$db = getDB();

/* -------- Datei-Scanner -------- */
function scanPhpFiles($baseDir, $exclude = []) {
    $files = [];

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($it as $file) {
        $path = $file->getPathname();

        foreach ($exclude as $ex) {
            if (str_contains($path, DIRECTORY_SEPARATOR . $ex . DIRECTORY_SEPARATOR)) {
                continue 2;
            }
        }

        if ($file->getExtension() === 'php') {
            $files[] = realpath($path);
        }
    }
    return $files;
}

$projectRoot = realpath(__DIR__ . '/..');
$excludeDirs = [
    'assets', 'uploads', 'img', 'lang', 'logo', '.idea', 'vendor'
];

$files = scanPhpFiles($projectRoot, $excludeDirs);
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Audit-Logs nach Datei</title>
<link rel="stylesheet" href="/.../assets/css/style.css">
</head>
<body>
 
<h1>Audit-Logs nach Datei</h1>

<?php foreach ($files as $file): ?>
    <h3><?= htmlspecialchars(str_replace($projectRoot, '', $file)) ?></h3>

    <?php
    /* Dateigebundene Logs */
    $stmt = $db->prepare("
        SELECT created_at, user, action
        FROM audit
        WHERE file = :file
        ORDER BY created_at DESC
    ");
    $stmt->bindValue(':file', $file);
    $res = $stmt->execute();

    $hasLogs = false;
    ?>

    <ul>
    <?php while ($l = $res->fetchArray(SQLITE3_ASSOC)): ?>
        <?php $hasLogs = true; ?>
        <li>
            <?= htmlspecialchars($l['created_at']) ?> –
            <?= htmlspecialchars($l['user'] ?? 'SYSTEM') ?> –
            <?= htmlspecialchars($l['action']) ?>
        </li>
    <?php endwhile; ?>
    </ul>

    <?php if (!$hasLogs): ?>
        <?php
        /* Fallback: allgemeine Logs ohne Datei */
        $fallback = $db->query("
            SELECT created_at, user, action
            FROM audit
            WHERE file IS NULL
            ORDER BY created_at DESC
            LIMIT 3
        ");

        $hasFallback = false;
        ?>
        <?php if ($fallback): ?>
            <?php while ($f = $fallback->fetchArray(SQLITE3_ASSOC)): ?>
                <?php if (!$hasFallback): ?>
                    <em>Allgemeine Logs (nicht dateigebunden):</em>
                    <ul>
                <?php endif; ?>
                <?php $hasFallback = true; ?>
                <li>
                    <?= htmlspecialchars($f['created_at']) ?> –
                    <?= htmlspecialchars($f['user'] ?? 'SYSTEM') ?> –
                    <?= htmlspecialchars($f['action']) ?>
                </li>
            <?php endwhile; ?>

            <?php if ($hasFallback): ?>
                </ul>
            <?php else: ?>
                <em>Keine Logs</em>
            <?php endif; ?>
        <?php else: ?>
            <em>Keine Logs</em>
        <?php endif; ?>
    <?php endif; ?>

<?php endforeach; ?>

<a href="index.php">← Zurück</a>

</body>
</html>

<?php require __DIR__ . '/../includes/footer.php'; ?>
