<?php

class Like {
    private $pdo;

    public function __construct() {
        require __DIR__ . '/../../config.php'; 
        $this->pdo = $pdo;
    }


    public function hasUserLiked($postId, $userId) {
        $query = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function likePost($postId, $userId) {
        $query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
    }

    public function unlikePost($postId, $userId) {
        $query = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
    }

    public function getLikeCount($postId) {
        $query = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchColumn();
    }
    
}
