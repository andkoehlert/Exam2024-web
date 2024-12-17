<?php
require_once __DIR__ . '/../models/userSettings_update.php';
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../config.php';

class UserProfileController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function handleRequest() {
        // Ensure the user is logged in
        checkIfLoggedIn();

        // Get the logged-in user's ID
        if (!isset($_SESSION['users2_id'])) {
            die("Error: No user logged in.");
        }

        $userId = $_SESSION['users2_id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            die("User not found.");
        }

        $updateMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Validation
            if (empty($name) || empty($email)) {
                die("Name and email are required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email format.");
            }
            if (!empty($password) && $password !== $confirmPassword) {
                die("Passwords do not match.");
            }

            try {
                $this->userModel->updateUserProfile($userId, $name, $email);

                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $this->userModel->updateUserPassword($userId, $hashedPassword);
                }

                $updateMessage = 'Profile updated successfully!';
            } catch (Exception $e) {
                die("Failed to update profile: " . $e->getMessage());
            }
        }

        // Include the view
        include __DIR__ . '/../views/userSettings_update.php';
    }

}
$controller = new UserProfileController($pdo);
$controller->handleRequest();