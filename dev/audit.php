<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'DEV') {
    header("Location: index.php");
    exit;
}

require 'db.php';
require __DIR__ . '/../includes/header.php';

$db = getDB();

/* Scanner */
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
$excludeDirs = ['assets','uploads','img','lang','logo','.idea'];

$files = scanPhpFiles($projectRoot, $excludeDirs);
?>

<h1>Audit-Logs nach Datei</h1>

<?php foreach ($files as $file): ?>
    <h3><?= htmlspecialchars(str_replace($projectRoot, '', $file)) ?></h3>

    <?php
    $stmt = $db->prepare("
        SELECT created_at, user, action
        FROM audit
        WHERE file = :file
        ORDER BY created_at DESC
    ");
    $stmt->bindValue(':file', $file);
    $logs = $stmt->execute();
    ?>

    <ul>
    <?php
    $hasLogs = false;
    while ($l = $logs->fetchArray(SQLITE3_ASSOC)):
        $hasLogs = true;
    ?>
        <li>
            <?= htmlspecialchars($l['created_at']) ?> –
            <?= htmlspecialchars($l['user']) ?> –
            <?= htmlspecialchars($l['action']) ?>
        </li>
    <?php endwhile; ?>

    <?php if (!$hasLogs): ?>
        <li><em>Keine Logs</em></li>
    <?php endif; ?>
    </ul>
<?php endforeach; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
