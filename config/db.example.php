<?php
/**
 * Cuti MY – database configuration (example)
 *
 * Copy this file to db.php and fill in your credentials:
 *   copy config/db.example.php config/db.php
 */

$host = 'localhost';
$dbname = 'cuti_my';
$username = 'root';
$password = '';

$GLOBALS['CUTI_DB'] = [
    'host' => $host,
    'dbname' => $dbname,
    'username' => $username,
    'password' => $password,
];

/**
 * Returns a shared PDO connection.
 */
function cuti_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = cuti_db_config();
    $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4';

    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function cuti_db_config(): array
{
    return $GLOBALS['CUTI_DB'];
}
