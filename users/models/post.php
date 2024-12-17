<?php
class Post {
    private $pdo;

    public function __construct() {
        require __DIR__ . '/../../config.php'; 
        $this->pdo = $pdo;
    }

    public function getAllPosts() {
        $sql = "
           SELECT posts.*, 
           users2.name,
           COUNT(likes.post_id) AS like_count,
           CASE WHEN posts.post_id = (
               SELECT post_id 
               FROM likes 
               GROUP BY post_id 
               ORDER BY COUNT(post_id) DESC 
               LIMIT 1
           ) THEN 'This post is on fire' ELSE '' END AS is_most_liked,
           posts.is_on_fire 
    FROM posts
    LEFT JOIN users2 ON posts.user_id = users2.users2_id
    LEFT JOIN likes ON posts.post_id = likes.post_id
    GROUP BY posts.post_id, users2.name, posts.is_on_fire -- Add posts.is_on_fire to GROUP BY
    ORDER BY posts.created_at DESC";
        
        $stmt = $this->pdo->query($sql);

        if (!$stmt) {
            // Debugging: Inspect SQL errors
            var_dump($this->pdo->errorInfo());
            exit;
        }

         $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
}
