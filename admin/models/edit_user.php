<?php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

  public function getUserPosts($userId) {
        $sql = "
            SELECT posts.*, 
            COUNT(likes.post_id) AS like_count
            FROM posts
            LEFT JOIN likes ON posts.post_id = likes.post_id
            WHERE posts.user_id = :user_id
            GROUP BY posts.post_id
            ORDER BY posts.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users2 WHERE users2_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users2";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function updateUser($id, $name, $email, $phone, $password, $role, $is_ban) {
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);  // Hash the new password
    } else {
        $password = null;
    }

    $sql = "UPDATE users2 SET 
            name = :name, 
            email = :email, 
            phone = :phone, 
            password = COALESCE(:password, password),  -- Use existing password if not provided
            role = :role, 
            is_ban = :is_ban 
            WHERE users2_id = :id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':is_ban', $is_ban, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
   

}
