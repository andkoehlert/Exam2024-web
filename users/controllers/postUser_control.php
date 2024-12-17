<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/user_post.php'; 
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../../auth.php'; 

class PostUserControl {
    private $pdo;
    private $userId;

    public function __construct($pdo) {
        $this->pdo = $pdo;

        if (!isset($_SESSION['users2_id'])) {
            echo "User not logged in.";
            exit; 
        }

        $this->userId = $_SESSION['users2_id']; 
    }

    public function userPost() {
        $postUserModel = new UserPost($this->pdo);
        $postsUser = $postUserModel->getUserPosts($this->userId);  
    
      
    
        include __DIR__ . '/../views/user_home_page.php';  
    }
}

$controller = new PostUserControl($pdo);
$controller->userPost();
?>
