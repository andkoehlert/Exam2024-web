<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/post.php'; 
require_once __DIR__ . '/../../config.php'; 

class PostControl {
    public function index() {
       
        $postModel = new Post();

        $userId = $user['users2_id']; 

        $posts = $postModel->getAllPosts(); 

        if (!$posts) {
            echo "No posts found.";
            return;  
        }

        include __DIR__ . '/../views/explore.php';
    }
    private function getUserData() {
        if (isset($_SESSION['users2_id'])) {
            $userId = $_SESSION['users2_id'];

            $sql = "SELECT * FROM users2 WHERE users2_id = :user_id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo "Error: User not found.";
                exit;
            }

            if (!isset($_SESSION['role'])) {
                $_SESSION['role'] = $user['role'];
            }

            return $user; 
        } else {
            echo "Error: User ID not found in session.";
            exit;
        }
    }
}

$controller = new PostControl();
$controller->index();
