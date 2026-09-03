<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Run this installer from the command line: php install_cli.php\n");
    exit(1);
}

require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/Installer.php';

$force = in_array('--force', $argv, true);

echo "Cuti MY command-line installer\n";
echo "------------------------------\n";

$steps = cuti_run_install($force);
$ok = cuti_install_succeeded($steps);

foreach ($steps as $step) {
    $mark = !empty($step['ok']) ? '[OK]' : '[FAIL]';
    echo $mark . ' ' . $step['label'] . ': ' . $step['detail'] . "\n";
}

if ($ok) {
    echo "\nInstallation complete.\n";
    exit(0);
}

echo "\nInstallation failed.\n";
echo "Update config/db.php, then run: php install_cli.php\n";
echo "If the app is already installed, use: php install_cli.php --force\n";
exit(1);
