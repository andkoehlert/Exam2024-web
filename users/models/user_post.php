<?php
class UserPost {
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
}
