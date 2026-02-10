<?php

require_once __DIR__ . '/../services/UserService.php';

// GET /profile
Flight::route('GET /profile', function() {
    requireAuth();
    $userService = new UserService(Flight::get('pdo'));
    $user = $userService->getUserById($_SESSION['user_id']);

    if (!$user) {
        Flight::json(['error'=>'User not found'],404);
        return;
    }

    Flight::json(['user'=>$user]);
});

// PUT /profile
Flight::route('PUT /profile', function() {
    requireAuth();
    $data = Flight::request()->data;
    $userService = new UserService(Flight::get('pdo'));
    $fields = [];

    if (!empty($data['name'])) {
        $name = trim($data['name']);
        if (mb_strlen($name) > 200) {
            Flight::json(['error'=>'Name too long'],400);
            return;
        }
        $fields['name'] = $name;
    }

    if (!empty($data['birth_date'])) {
        $d = DateTime::createFromFormat('Y-m-d',$data['birth_date']);
        if (!$d || $d->format('Y-m-d') !== $data['birth_date']) {
            Flight::json(['error'=>'Invalid birth date format'],400);
            return;
        }
        $fields['birth_date'] = $data['birth_date'];
    }

    if (!empty($data['password'])) {
        if (strlen($data['password'])<8) {
            Flight::json(['error'=>'Password too short'],400);
            return;
        }
        $fields['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
    }

    if (empty($fields)) {
        Flight::json(['error'=>'No data to update'],400);
        return;
    }

    $userService->updateUser($_SESSION['user_id'],$fields);
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