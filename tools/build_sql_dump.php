<?php
/**
 * Builds sql/holidays_full.sql from seed data (schema + all INSERT rows).
 * Run once locally: php tools/build_sql_dump.php
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/seed_holidays.php';

$schema = file_get_contents(dirname(__DIR__) . '/sql/schema.sql');
$out = dirname(__DIR__) . '/sql/holidays_full.sql';

function sql_quote(?string $value): string
{
    if ($value === null) {
        return 'NULL';
    }
    return "'" . str_replace(["\\", "'"], ["\\\\", "''"], $value) . "'";
}

$lines = [];
$lines[] = '-- Cuti MY full database dump';
$lines[] = '-- Import this file in phpMyAdmin (Select DB → Import).';
$lines[] = '-- Contains table structure + 2024-2026 holiday rows.';
$lines[] = 'SET NAMES utf8mb4;';
$lines[] = 'SET FOREIGN_KEY_CHECKS = 0;';
$lines[] = '';
$lines[] = 'DROP TABLE IF EXISTS holidays;';
$lines[] = trim($schema);
$lines[] = '';

$rows = cuti_my_get_seed_rows();
foreach ($rows as $row) {
    $lines[] = sprintf(
        'INSERT INTO holidays (holiday_date, year, name_en, name_zh, name_ms, type, states, description_en, description_zh, description_ms, is_birthday) VALUES (%s, %d, %s, %s, %s, %s, %s, %s, %s, %s, %d);',
        sql_quote($row['holiday_date']),
        (int) $row['year'],
        sql_quote($row['name_en']),
        sql_quote($row['name_zh']),
        sql_quote($row['name_ms']),
        sql_quote($row['type']),
        sql_quote($row['states']),
        sql_quote($row['description_en']),
        sql_quote($row['description_zh']),
        sql_quote($row['description_ms']),
        (int) $row['is_birthday']
    );
}

$lines[] = '';
$lines[] = 'SET FOREIGN_KEY_CHECKS = 1;';
$lines[] = '-- Total rows: ' . count($rows);

file_put_contents($out, implode(PHP_EOL, $lines) . PHP_EOL);
echo 'Wrote ' . $out . ' with ' . count($rows) . " rows\n";
