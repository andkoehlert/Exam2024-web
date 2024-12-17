<?php

class ActiveUserPostsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getActiveUserPosts() {
        $stmt = $this->pdo->prepare("SELECT * FROM active_user_posts");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    public function getAdminUsers() {
      $stmt = $this->pdo->prepare("SELECT * FROM admin_users");      
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }
  public function getTotalPostCount() {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total_count FROM posts");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total_count'];
}
public function getDeletedPostsLog() {
  $stmt = $this->pdo->prepare("SELECT * FROM deleted_posts_log ORDER BY deleted_at DESC");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getTodayPostCount() {
  $stmt = $this->pdo->prepare("
      SELECT COUNT(*) AS today_count 
      FROM posts 
      WHERE DATE(created_at) = CURDATE()
  ");
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['today_count'];
}
public function getCreatedPostsLog() {
  $stmt = $this->pdo->prepare("SELECT * FROM created_posts_log WHERE created_at >= NOW() - INTERVAL 7 DAY ORDER BY created_at DESC LIMIT 20");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
