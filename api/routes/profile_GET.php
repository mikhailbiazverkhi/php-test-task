
<?php

Flight::route('GET /profile', function () {
    requireAuth();

    $pdo = Flight::get('pdo');
    $userId = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("
        SELECT id, name, email, birth_date
        FROM users
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch();

    if (!$user) {
        Flight::json(['error' => 'User not found'], 404);
        return;
    }

    Flight::json(['user' => $user]);
});