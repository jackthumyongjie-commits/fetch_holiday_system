<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/init.php';
require_once dirname(__DIR__) . '/includes/seed_holidays.php';

function cuti_install_lock_path(): string
{
    return dirname(__DIR__) . '/config/install.lock';
}

function cuti_schema_sql(): string
{
    return (string) file_get_contents(dirname(__DIR__) . '/sql/schema.sql');
}

/**
 * @return array<int, array{id: string, label: string, ok: bool, detail: string}>
 */
function cuti_run_install(bool $force = false): array
{
    $steps = [];
    $lockFile = cuti_install_lock_path();

    $phpOk = PHP_VERSION_ID >= 80000;
    $steps[] = [
        'id' => 'php',
        'label' => 'PHP version',
        'ok' => $phpOk,
        'detail' => $phpOk
            ? 'PHP ' . PHP_VERSION . ' is supported.'
            : 'PHP 8.0 or newer is required. This server is running PHP ' . PHP_VERSION . '.',
    ];

    $pdoOk = class_exists('PDO') && in_array('mysql', PDO::getAvailableDrivers(), true);
    $steps[] = [
        'id' => 'pdo',
        'label' => 'PDO MySQL',
        'ok' => $pdoOk,
        'detail' => $pdoOk
            ? 'PDO with the MySQL driver is available.'
            : 'PDO MySQL is not available. Enable pdo_mysql in php.ini.',
    ];

    if (!$phpOk || !$pdoOk) {
        $steps[] = [
            'id' => 'connect',
            'label' => 'Database connection',
            'ok' => false,
            'detail' => 'Skipped because server requirements failed.',
        ];
        return $steps;
    }

    require_once dirname(__DIR__) . '/config/db.php';
    $config = cuti_db_config();

    try {
        $pdo = cuti_db();
        $steps[] = [
            'id' => 'connect',
            'label' => 'Database connection',
            'ok' => true,
            'detail' => 'Connected to database "' . $config['dbname'] . '" on ' . $config['host'] . '.',
        ];
    } catch (Throwable $e) {
        $steps[] = [
            'id' => 'connect',
            'label' => 'Database connection',
            'ok' => false,
            'detail' => 'Could not connect. Check host, database name, username and password in config/db.php.',
        ];
        return $steps;
    }

    if (is_file($lockFile) && !$force) {
        $count = 0;
        try {
            $count = (int) $pdo->query('SELECT COUNT(*) FROM holidays')->fetchColumn();
        } catch (Throwable $e) {
            $count = 0;
        }
        $steps[] = [
            'id' => 'lock',
            'label' => 'Installation lock',
            'ok' => true,
            'detail' => 'Cuti MY is already installed (' . $count . ' holiday records). Duplicate inserts are blocked. Delete config/install.lock to run a full install again.',
        ];
        $steps[] = [
            'id' => 'table',
            'label' => 'Create holidays table',
            'ok' => true,
            'detail' => 'Skipped because the application is already installed.',
        ];
        $steps[] = [
            'id' => 'seed',
            'label' => 'Insert holiday data',
            'ok' => true,
            'detail' => 'Skipped because the application is already installed.',
        ];
        return $steps;
    }

    try {
        $pdo->exec(cuti_schema_sql());
        $steps[] = [
            'id' => 'table',
            'label' => 'Create holidays table',
            'ok' => true,
            'detail' => 'The holidays table is ready.',
        ];
    } catch (Throwable $e) {
        $steps[] = [
            'id' => 'table',
            'label' => 'Create holidays table',
            'ok' => false,
            'detail' => 'The holidays table could not be created. Check database permissions.',
        ];
        return $steps;
    }

    $sql = 'INSERT IGNORE INTO holidays
        (holiday_date, year, name_en, name_zh, name_ms, type, states,
         description_en, description_zh, description_ms, is_birthday)
        VALUES
        (:holiday_date, :year, :name_en, :name_zh, :name_ms, :type, :states,
         :description_en, :description_zh, :description_ms, :is_birthday)';

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare($sql);
        $inserted = 0;
        $skipped = 0;

        foreach (cuti_my_get_seed_rows() as $row) {
            $stmt->execute([
                'holiday_date' => $row['holiday_date'],
                'year' => $row['year'],
                'name_en' => $row['name_en'],
                'name_zh' => $row['name_zh'],
                'name_ms' => $row['name_ms'],
                'type' => $row['type'],
                'states' => $row['states'],
                'description_en' => $row['description_en'],
                'description_zh' => $row['description_zh'],
                'description_ms' => $row['description_ms'],
                'is_birthday' => $row['is_birthday'],
            ]);
            if ($stmt->rowCount() > 0) {
                $inserted++;
            } else {
                $skipped++;
            }
        }

        $pdo->commit();
        @file_put_contents($lockFile, date('c') . PHP_EOL);

        $steps[] = [
            'id' => 'seed',
            'label' => 'Insert holiday data',
            'ok' => true,
            'detail' => $inserted . ' new records inserted, ' . $skipped . ' existing records skipped.',
        ];
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $steps[] = [
            'id' => 'seed',
            'label' => 'Insert holiday data',
            'ok' => false,
            'detail' => 'Holiday data could not be inserted. The installer made no partial changes.',
        ];
    }

    return $steps;
}

function cuti_install_succeeded(array $steps): bool
{
    foreach ($steps as $step) {
        if (empty($step['ok'])) {
            return false;
        }
    }
    return $steps !== [];
}
