<?php

Flight::route('PUT /profile', function () {
    requireAuth();

    $pdo = Flight::get('pdo');
    $data = Flight::request()->data;
    $userId = $_SESSION['user_id'];

    $fields = [];
    $params = ['id' => $userId];

    // name
    if (!empty($data['name'])) {
        $name = trim($data['name']);

        if (mb_strlen($name) > 200) {
            Flight::json(['error' => 'Name is too long'], 400);
            return;
        }

        $fields[] = 'name = :name';
        $params['name'] = $name;
    }

    // birth_date
    if (!empty($data['birth_date'])) {
        $birthDate = $data['birth_date'];

        $d = DateTime::createFromFormat('Y-m-d', $birthDate);
        if (!$d || $d->format('Y-m-d') !== $birthDate) {
            Flight::json(['error' => 'Invalid birth date format'], 400);
            return;
        }

        $fields[] = 'birth_date = :birth_date';
        $params['birth_date'] = $birthDate;

    }

    // password
    if (!empty($data['password'])) {
        $password = $data['password'];

        if (strlen($password) < 8) {
            Flight::json(['error' => 'Password too short'], 400);
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $fields[] = 'password = :password';
        $params['password'] = $hash;
    }

    if (empty($fields)) {
        Flight::json(['error' => 'No data to update'], 400);
        return;
    }

    $sql = "
        UPDATE users
        SET " . implode(', ', $fields) . "
        WHERE id = :id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    Flight::json(['status' => 'Profile updated']);
});