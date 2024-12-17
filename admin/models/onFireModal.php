<?php
class PostModel {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getOnFirePosts() {
      $query = "SELECT user_id, tag, description, created_at, image_path 
                FROM posts 
                WHERE is_on_fire = 1";
      $stmt = $this->pdo->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}
