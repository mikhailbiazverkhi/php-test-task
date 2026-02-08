<?php

require_once __DIR__ . '/../flight/autoload.php';
require_once __DIR__ . '/../flight/Flight.php';

// JSON по умолчанию
Flight::set('flight.log_errors', true);

// DB будет позже
// Flight::set('db', $pdo);