<?php
class Post {
    private $pdo;

    public function __construct() {
        require __DIR__ . '/../../config.php'; // Load DB connection
        $this->pdo = $pdo;
    }

    public function getAllPostsByLikes() {
      $sql = "
          SELECT posts.*, 
                 users2.name,
                 COUNT(likes.post_id) AS like_count,
                 CASE 
                     WHEN posts.post_id = (
                         SELECT post_id 
                         FROM likes 
                         GROUP BY post_id 
                         ORDER BY COUNT(post_id) DESC 
                         LIMIT 1
                     ) THEN 'This post is on fire' 
                     ELSE '' 
                 END AS is_most_liked,
                  posts.is_on_fire 
          FROM posts
          LEFT JOIN users2 ON posts.user_id = users2.users2_id
          LEFT JOIN likes ON posts.post_id = likes.post_id
          GROUP BY posts.post_id, users2.name
          ORDER BY like_count DESC";  // Order by like count in descending order
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch and return all posts as an associative array
  }
        public function getUserPosts() {
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
                       ) THEN 'This post is on fire' ELSE '' END AS is_most_liked
                FROM posts
                LEFT JOIN users2 ON posts.user_id = users2.users2_id
                LEFT JOIN likes ON posts.post_id = likes.post_id
                GROUP BY posts.post_id, users2.name
                ORDER BY posts.created_at DESC";
                $stmt = $this->pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch and return all posts as an associative array
            }
        
  
}
