<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/edit_user.php'; 
require_once __DIR__ . '/../../auth.php'; 

class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function editUser($id) {
        $userModel = new UserModel($this->pdo);
        $user = $userModel->getUserById($id);

        if ($user) {
            include __DIR__ . '/../views/edit_user.php'; 
        } else {
            echo "User not found.";
        }
    }

    public function updateUser($data) {
        $userModel = new UserModel($this->pdo);

        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'];
        $is_ban = isset($data['is_ban']) ? 1 : 0;
        $success = $userModel->updateUser($id, $name, $email, $phone, $password, $role, $is_ban);

        if ($success) {
          $_SESSION['message'] = "User updated successfully.";
      } else {
          $_SESSION['message'] = "Failed to update user.";
      }
          header("Location: /users-edit?id=$id");
    }
    public function editUserWithPosts($userId) {
        $userModel = new UserModel($this->pdo);
    
        // Fetch user details
        $user = $userModel->getUserById($userId);
        if (!$user) {
            die("User not found.");
        }
    
        // Fetch user posts
        $userPosts = $userModel->getUserPosts($userId);
    
        include __DIR__ . '/../views/edit_user.php'; 
    }
    public function toggleOnFire($postId) {
        session_start();
        if ($_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Unauthorized.";
            exit;
        }

        try {
            $sql = "UPDATE posts SET is_on_fire = NOT is_on_fire WHERE post_id = :post_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['post_id' => $postId]);
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
                include __DIR__ . '/../views/edit_user.php';

    }

}

// Use the global $pdo initialized in config.php
$controller = new UserController($pdo);


