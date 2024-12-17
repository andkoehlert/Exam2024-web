<?php
// models/PostModel.php

class PostModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPostById($postId, $userId) {
        $sql = "SELECT * FROM posts 
                WHERE post_id = :post_id 
                AND (user_id = :user_id OR :is_admin = 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':is_admin', $_SESSION['role'] === 'admin' ? 1 : 0, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
public function updatePost($postId, $userId, $tag, $description) {
    $sql = "UPDATE posts 
            SET tag = :tag, description = :description 
            WHERE post_id = :post_id 
            AND (user_id = :user_id OR :is_admin = 1)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':is_admin', $_SESSION['role'] === 'admin' ? 1 : 0, PDO::PARAM_INT);
    return $stmt->execute();
}

}
?>
