<?php

require_once __DIR__ . '/../services/UserService.php';

// POST /login
Flight::route('POST /login', function() {
    $data = Flight::request()->data;
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        Flight::json(['error'=>'Email and password required'],400);
        return;
    }

    $userService = new UserService(Flight::get('pdo'));
    $user = $userService->getUserByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        Flight::json(['error'=>'Invalid credentials'],401);
        return;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];

    Flight::json(['status'=>'login success']);
});

// POST /logout
Flight::route('POST /logout', function() {
    session_unset();
    session_destroy();
    Flight::json(['status'=>'logged out']);
});

// POST /register
Flight::route('POST /register', function() {
    $data = Flight::request()->data;
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (!$name || !$email || !$password) {
        Flight::json(['error'=>'Missing required fields'],400);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Flight::json(['error'=>'Invalid email format'],400);
        return;
    }

    $userService = new UserService(Flight::get('pdo'));

    try {
        $userService->createUser($name,$email,$password);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            Flight::json(['error'=>'Email already exists'],409);
        } else {
            Flight::json(['error'=>'Server error'],500);
        }
        return;
    }

    Flight::json(['status'=>'user created']);
});