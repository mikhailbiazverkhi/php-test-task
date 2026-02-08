<?php

Flight::route('POST /register', function () {

    $data = Flight::request()->data;

    $name  = trim($data->name ?? '');
    $email = trim($data->email ?? '');
    $pass  = trim($data->password ?? '');

    // простая валидация
    if ($name === '' || $email === '' || $pass === '') {
        Flight::json([
            'error' => 'Missing required fields'
        ], 400);
        return;
    }

    Flight::json([
        'status' => 'user created',
        'user' => [
            'name' => $name,
            'email' => $email
        ]
    ]);
});