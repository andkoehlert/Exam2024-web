<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/postHot.php'; // Include the Post model
require_once __DIR__ . '/../../config.php'; // Ensure this points to the correct path

class PostControl {
  public function index() {
    // Create an instance of the Post model
    $postModel = new Post();

    // Fetch all posts ordered by most likes
    $posts = $postModel->getAllPostsByLikes(); // This will return the posts ordered by like count

    // Check if there are posts
    if (!$posts) {
        echo "No posts found.";
        return;  // Stop execution if no posts are found
    }

    // Pass posts data to the view
    include __DIR__ . '/../views/explore_HotPictures.php';
}
}


// Create an instance of the controller and call the method
$controller = new PostControl();
$controller->index();
