<?php

require_once __DIR__ . '/bootstrap.php';

// Connect the controllers
require_once __DIR__ . '/controllers/UserController.php';

// Health check
Flight::route('GET /', function() {
    Flight::json(['status' => 'API working']);
});

Flight::start();