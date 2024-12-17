<?php
class CreatePost {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function countRecentPostsByUser($userId, $timeLimit) {
        $sql = "
            SELECT COUNT(*) AS post_count, MAX(created_at) AS last_post_time
            FROM posts
            WHERE user_id = :user_id AND created_at >= (NOW() - INTERVAL $timeLimit)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($userId, $imagePath, $tag, $description) {
        
        $tag = htmlspecialchars($tag, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        
        $sql = "INSERT INTO posts (user_id, image_path, tag, description) VALUES (:user_id, :image_path, :tag, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'image_path' => $imagePath,
            'tag' => $tag,
            'description' => $description,
        ]);
    }
}
?>
