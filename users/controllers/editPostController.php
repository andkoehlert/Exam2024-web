<?php

require_once __DIR__ . '/../../config.php';

require_once __DIR__ . '/../models/postModel.php';

class PostController {
    private $postModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->postModel = new PostModel($pdo);
    }

    public function editPostForm($postId) {

        if (!isset($_SESSION['users2_id'])) {
            die("You must be logged in to edit a post.");
        }
        $userId = $_SESSION['users2_id'];

        $post = $this->postModel->getPostById($postId, $userId);
        if (!$post) {
            die("Post not found or you don't have permission to edit this post.");
        }

        include __DIR__ . '/../views/edit_post_view.php';
    }

    public function updatePost($postId) {
        session_start();
        if (!isset($_SESSION['users2_id'])) {
            die("You must be logged in to update a post.");
        }
        $userId = $_SESSION['users2_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tag = trim($_POST['tag']);
            $description = trim($_POST['description']);

            if ($this->postModel->updatePost($postId, $userId, $tag, $description)) {
                $_SESSION['status'] = "Post updated successfully!";
                header("Location: /explore");  // Redirect to the explore page
                exit;
            } else {
                echo "Error updating the post.";
            }
        }
    }
}
?>
