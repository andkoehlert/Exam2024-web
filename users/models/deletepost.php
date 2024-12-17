<?php
class DeletePost {
    private $pdo;

    public function __construct($pdo) {
        require __DIR__ . '/../../config.php'; 
        $this->pdo = $pdo;
    }

    public function deletePost($postId, $userId, $isAdmin) {
        if ($isAdmin) {
            $sql = "DELETE FROM posts WHERE post_id = :post_id";
            $params = ['post_id' => $postId]; 
        } else {
            $sql = "DELETE FROM posts WHERE post_id = :post_id AND user_id = :user_id";
            $params = ['post_id' => $postId, 'user_id' => $userId];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }
}
?>