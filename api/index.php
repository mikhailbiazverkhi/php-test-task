<?php
require_once __DIR__ . '/bootstrap.php';

// Health check
Flight::route('GET /', function() {
    Flight::json(['status'=>'API working']);
});

// controllers
foreach (glob(__DIR__ . '/controllers/*.php') as $file) {
    require_once $file;
}

Flight::start();