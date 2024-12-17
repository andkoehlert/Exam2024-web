<?php

class Comments {
    private $pdo;

    public function __construct($pdo) {
        require __DIR__ . '/../../config.php'; 
        $this->pdo = $pdo;
    }

public function getCommentsByPostId($postId) {
    $sql = "SELECT comments.comment_id, comments.comment_text, comments.created_at, comments.user_id, users2.name, comments.comment_image_path
            FROM comments
            JOIN users2 ON comments.user_id = users2.users2_id
            WHERE comments.post_id = :post_id
            ORDER BY comments.created_at DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

 public function addComment($postId, $userId, $commentText, $imagePath = null) {
        $sql = "INSERT INTO comments (post_id, user_id, comment_text, comment_image_path) VALUES (:post_id, :user_id, :comment_text, :comment_image_path)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId,
            'comment_text' => $commentText,
            'comment_image_path' => $imagePath
        ]);
    }
    
    public function deleteComment($commentId) {
        try {
            $isAdmin = $_SESSION['role'] === 'admin';
            $userId = $_SESSION['users2_id']; 
    
            $sql = "DELETE FROM comments 
                    WHERE comment_id = :comment_id 
                    AND (user_id = :user_id OR :is_admin = 1)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':is_admin', $isAdmin ? 1 : 0, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Failed to delete comment.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}


?>
