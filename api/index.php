<?php
require_once 'bootstrap.php';

Flight::route('GET /index.php', function () {
    Flight::json(['status' => 'API working']);
});

Flight::start();