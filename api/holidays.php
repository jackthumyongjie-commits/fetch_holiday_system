<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/init.php';
require_once dirname(__DIR__) . '/includes/HolidayService.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Only GET requests are allowed.',
        'holidays' => [],
        'stats' => ['total' => 0, 'federal' => 0, 'state' => 0, 'next' => null],
    ]);
    exit;
}

try {
    require_once dirname(__DIR__) . '/includes/Installer.php';
    cuti_ensure_seeded();

    $service = new HolidayService();
    $result = $service->getHolidays([
        'year' => $_GET['year'] ?? 'all',
        'month' => $_GET['month'] ?? 'all',
        'type' => $_GET['type'] ?? 'all',
        'keyword' => $_GET['keyword'] ?? '',
    ]);

    echo json_encode([
        'success' => true,
        'holidays' => $result['holidays'],
        'stats' => $result['stats'],
        'years' => $result['years'],
        'total_all' => $result['total_all'],
    ], JSON_UNESCAPED_UNICODE);
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'holidays' => [],
        'stats' => ['total' => 0, 'federal' => 0, 'state' => 0, 'next' => null],
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode([
        'success' => false,
        'error' => 'The holiday database is unavailable. Please check the installation.',
        'holidays' => [],
        'stats' => ['total' => 0, 'federal' => 0, 'state' => 0, 'next' => null],
    ], JSON_UNESCAPED_UNICODE);
} catch (RuntimeException $e) {
    http_response_code(503);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'holidays' => [],
        'stats' => ['total' => 0, 'federal' => 0, 'state' => 0, 'next' => null],
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Unable to load holidays right now. Please try again later.',
        'holidays' => [],
        'stats' => ['total' => 0, 'federal' => 0, 'state' => 0, 'next' => null],
    ], JSON_UNESCAPED_UNICODE);
}
