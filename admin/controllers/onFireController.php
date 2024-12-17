<?php
require_once __DIR__ . '/../models/onFireModal.php';
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../../auth.php';   

class PostController {
  private $postModel;

  public function __construct($pdo) {
      $this->postModel = new PostModel($pdo);
  }

  public function showOnFirePosts() {
      $posts = $this->postModel->getOnFirePosts();

      include __DIR__ . '/../views/onFirePosts.php';
  }
}
