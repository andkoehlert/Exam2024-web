<?php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserById($userId) {
        $sql = "SELECT name, email FROM users2 WHERE users2_id = :users2_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['users2_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserProfile($userId, $name, $email) {
        $sql = "UPDATE users2 SET name = :name, email = :email WHERE users2_id = :users2_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'users2_id' => $userId,
        ]);
    }

    public function updateUserPassword($userId, $hashedPassword) {
        $sql = "UPDATE users2 SET password = :password WHERE users2_id = :users2_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'password' => $hashedPassword,
            'users2_id' => $userId,
        ]);
    }
}
