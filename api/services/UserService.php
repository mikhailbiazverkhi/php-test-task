<?php
class UserService {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT id, name, email, birth_date FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name,:email,:password)");
        $stmt->execute(['name'=>$name,'email'=>$email,'password'=>$hash]);
        return $this->pdo->lastInsertId();
    }

    public function updateUser($id, $fields) {
        $sets = [];
        $params = ['id'=>$id];
        foreach ($fields as $key=>$value) {
            $sets[] = "$key = :$key";
            $params[$key] = $value;
        }
        $sql = "UPDATE users SET ".implode(", ", $sets)." WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=:id");
        $stmt->execute(['id'=>$id]);
    }
}