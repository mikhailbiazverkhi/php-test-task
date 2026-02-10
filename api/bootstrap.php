<?php

session_start();

require_once __DIR__ . '/../flight/autoload.php';
require_once __DIR__ . '/../flight/Flight.php';

$pdo = new PDO(
    'mysql:host=localhost;dbname=php_test;charset=utf8mb4',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

Flight::set('pdo', $pdo);

// Authorization check
function requireAuth() {
    if (empty($_SESSION['user_id'])) {
        Flight::json(['error' => 'Unauthorized'], 401);
        exit;
    }
}