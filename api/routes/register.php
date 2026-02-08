<?php

Flight::route('POST /register', function () {
    $pdo = Flight::get('pdo');
    $data = Flight::request()->data;

    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (!$name || !$email || !$password) {
        Flight::json(['error' => 'Missing required fields'], 400);
        return;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password)
        VALUES (:name, :email, :password)
    ");

    try {
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hash,
        ]);
    } catch (PDOException $e) {
        Flight::json(['error' => 'Email already exists'], 409);
        return;
    }

    Flight::json(['status' => 'user created']);
});