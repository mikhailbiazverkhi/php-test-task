<?php

Flight::route('POST /login', function () {
    $pdo = Flight::get('pdo');
    $data = Flight::request()->data;

    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        Flight::json(['error' => 'Email and password are required'], 400);
        return;
    }

    $stmt = $pdo->prepare("
        SELECT id, name, email, password
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        Flight::json(['error' => 'Invalid credentials'], 401);
        return;
    }

    // do not return the password
    unset($user['password']);

    Flight::json([
        'status' => 'login success',
        'user' => $user
    ]);
});