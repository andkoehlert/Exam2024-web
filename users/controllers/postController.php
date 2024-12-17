<?php
require_once __DIR__ . '/../models/deletepost.php';

require_once __DIR__ . '/../../config.php'; 

class PostController {
    private $deletePostModel;

    public function __construct($pdo) {
        $this->deletePostModel = new DeletePost($pdo);
    }

    public function deletePost($postId) {
        checkIfLoggedIn(); 

        $userId = $_SESSION['users2_id'];
        $userRole = $_SESSION['role'];

        $isAdmin = ($userRole === 'admin');

        try {
            $result = $this->deletePostModel->deletePost($postId, $userId, $isAdmin);

            if ($result) {
                return json_encode([
                    "success" => true,
                    "message" => "Post deleted successfully."
                ]);
            } else {
                return json_encode([
                    "success" => false,
                    "error" => "Failed to delete the post. You may not have the required permissions."
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                "success" => false,
                "error" => "An error occurred while trying to delete the post: " . $e->getMessage()
            ]);
        }
    }
}
?>
