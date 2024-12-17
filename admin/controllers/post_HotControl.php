<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/postHot.php'; 
require_once __DIR__ . '/../../config.php'; 

class PostControl {
  public function index() {
    $postModel = new Post();

    $posts = $postModel->getAllPostsByLikes(); 

    if (!$posts) {
        echo "No posts found.";
        return; 
    }

    include __DIR__ . '/../views/explore_HotPictures.php';
}
}


$controller = new PostControl();
$controller->index();
