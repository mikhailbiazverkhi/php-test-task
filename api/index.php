<?php

require_once __DIR__ . '/bootstrap.php';

// health check
Flight::route('GET /', function () {
    Flight::json(['status' => 'API working']);
});

// routes
foreach (glob(__DIR__ . '/routes/*.php') as $file) {
    require_once $file;
}

Flight::start();