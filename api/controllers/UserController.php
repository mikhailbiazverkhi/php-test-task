<?php

require_once __DIR__ . '/../services/UserService.php';

// POST /register
Flight::route('POST /register', function() {
    $data = Flight::request()->data;

    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $birth_date = $data['birth_date'] ?? null;

    if (!$name || !$email || !$password || !$birth_date) {
        Flight::json(['error'=>'Missing required fields'],400);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Flight::json(['error'=>'Invalid email format'],400);
        return;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)) {
        Flight::json(['error'=>'Invalid birth date'],400);
        return;
    }

    $userService = new UserService(Flight::get('pdo'));

    try {
        $userService->createUser($name, $email, $password, $birth_date);
    } catch (PDOException $e) {
        if ($e->getCode()==23000) Flight::json(['error'=>'Email exists'],409);
        else Flight::json(['error'=>'Server error'],500);
        return;
    }

    Flight::json(['status'=>'user created']);
});

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
    requireAuth();
    session_unset();
    session_destroy();
    Flight::json(['status'=>'logged out']);
});

// GET /profile
Flight::route('GET /profile', function() {
    requireAuth();
    $userService = new UserService(Flight::get('pdo'));
    $user = $userService->getUserById($_SESSION['user_id']);

    if (!$user) Flight::json(['error'=>'User not found'],404);
    else Flight::json(['user'=>$user]);
});

// PUT /profile
Flight::route('PUT /profile', function() {
    requireAuth();
    $data = Flight::request()->data;

    $userService = new UserService(Flight::get('pdo'));
    $userService->updateUser($_SESSION['user_id'], [
        'name' => $data['name'] ?? null,
        'birth_date' => $data['birth_date'] ?? null,
        'password' => $data['password'] ?? null
    ]);

    Flight::json(['status'=>'Profile updated']);
});

// DELETE /profile
Flight::route('DELETE /profile', function() {
    requireAuth();
    $userService = new UserService(Flight::get('pdo'));
    $userService->deleteUser($_SESSION['user_id']);

    session_unset();
    session_destroy();

    Flight::json(['status'=>'account deleted']);
});