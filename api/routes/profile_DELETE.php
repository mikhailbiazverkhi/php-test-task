<?php

Flight::route('DELETE /profile', function () {
    requireAuth();

    $pdo = Flight::get('pdo');
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        DELETE FROM users
        WHERE id = :id
    ");

    $stmt->execute(['id' => $userId]);

    session_unset();
    session_destroy();

    Flight::json(['status' => 'account deleted']);
});