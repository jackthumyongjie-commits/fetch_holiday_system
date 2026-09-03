<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/Installer.php';

$force = PHP_SAPI === 'cli' && in_array('--force', $argv ?? [], true);
$run = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' || PHP_SAPI === 'cli';
$steps = $run ? cuti_run_install($force) : [];
$success = $run && cuti_install_succeeded($steps);
$config = [];

try {
    require_once __DIR__ . '/config/db.php';
    $config = cuti_db_config();
} catch (Throwable $e) {
    $config = ['host' => '', 'dbname' => '', 'username' => ''];
}

$already = false;
if (is_file(cuti_install_lock_path())) {
    try {
        require_once __DIR__ . '/config/db.php';
        $count = (int) cuti_db()->query('SELECT COUNT(*) FROM holidays')->fetchColumn();
        $already = $count > 0;
    } catch (Throwable $e) {
        $already = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Install Cuti MY</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="is-install">
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="brand-text">Cuti MY</span>
            </a>
            <nav class="site-nav" aria-label="Installation">
                <a href="index.php">Home</a>
                <a href="manual.php">User Manual</a>
            </nav>
        </div>
    </header>

    <main class="install-main">
        <section class="install-panel">
            <p class="eyebrow">Setup</p>
            <h1>Install Cuti MY</h1>
            <p class="lede">This installer checks PHP, connects to MySQL, creates the holidays table, and loads 2024–2026 holiday data.</p>

            <ol class="install-notes">
                <li>Create an empty MySQL database in cPanel or phpMyAdmin.</li>
                <li>Edit <code>config/db.php</code> with your host, database name, username and password.</li>
                <li>Click Install below.</li>
            </ol>

            <p class="db-preview">
                Database: <strong><?= e((string) ($config['dbname'] ?? '')) ?></strong>
                on <strong><?= e((string) ($config['host'] ?? '')) ?></strong>
                as <strong><?= e((string) ($config['username'] ?? '')) ?></strong>
            </p>

            <?php if (!$run): ?>
                <form method="post" action="install.php">
                    <?php if ($already): ?>
                        <p class="banner banner-info" role="status">Cuti MY is already installed and holiday data was found. You can open the homepage.</p>
                    <?php endif; ?>
                    <button class="btn btn-primary" type="submit" <?= $already ? 'disabled' : '' ?>>
                        <?= $already ? 'Already installed' : 'Install now' ?>
                    </button>
                    <?php if ($already): ?>
                        <p class="hint">To reinstall, delete <code>config/install.lock</code> and run this page again. Existing holiday rows will not be duplicated.</p>
                    <?php else: ?>
                        <p class="hint">If you uploaded <code>install.lock</code> from another computer but this database is empty, click Install now to load holiday data.</p>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <ul class="install-steps" aria-label="Installation status">
                    <?php foreach ($steps as $step): ?>
                        <li class="<?= !empty($step['ok']) ? 'is-ok' : 'is-fail' ?>">
                            <strong><?= e($step['label']) ?></strong>
                            <span><?= e($step['detail']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($success): ?>
                    <p class="banner banner-ok" role="status">Installation complete. You can open the homepage.</p>
                    <a class="btn btn-primary" href="index.php">Open Cuti MY</a>
                <?php else: ?>
                    <p class="banner banner-error" role="alert">Installation did not finish. Fix the failed step and try again.</p>
                    <a class="btn btn-ghost" href="install.php">Back</a>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </main>

    <?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
