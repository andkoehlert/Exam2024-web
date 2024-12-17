<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/user_settings.php';
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../../auth.php'; 

class UserController {
    private $UserInformation;

    public function __construct($pdo) {
        $this->UserInformation = new UserInformation($pdo);
    }

    public function dashboard() {
        checkIfLoggedIn(); 

        if (!isset($_SESSION['users2_id'])) {
            echo "Error: No user logged in.";
            return; 
        }

        $profileUserId = $_SESSION['users2_id'];
        $user = $this->UserInformation->getUserInformation($profileUserId);

        if (!$user) {
            echo "User not found.";
            return; 
        }

        include __DIR__ . '/../views/user_settings.php';
    }
}

$controller = new UserController($pdo);
$controller->dashboard();
