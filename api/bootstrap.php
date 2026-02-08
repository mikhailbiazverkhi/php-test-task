<?php

require_once __DIR__ . '/../flight/autoload.php';
require_once __DIR__ . '/../flight/Flight.php';

$config = require __DIR__ . '/../config/database.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    Flight::json(['error' => 'Database connection failed'], 500);
    exit;
}

//making PDO available in any route
Flight::set('pdo', $pdo);