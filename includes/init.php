<?php

declare(strict_types=1);

date_default_timezone_set('Asia/Kuala_Lumpur');
ini_set('display_errors', '0');
error_reporting(E_ALL);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
