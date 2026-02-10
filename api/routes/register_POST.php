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

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Flight::json(['error' => 'Invalid email format'], 400);
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
    if ($e->getCode() == 23000) { // integrity constraint violation
        Flight::json(['error' => 'Email already exists'], 409);
    } else {
        Flight::json(['error' => 'Server error'], 500);
    }
    return;
}

    Flight::json(['status' => 'user created']);
});