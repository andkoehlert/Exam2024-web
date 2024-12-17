<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../models/activeUserPostModal.php';
require_once __DIR__ . '/../../auth.php'; 

class ActiveUserPostsController {
    private $pdo;
    private $model;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new ActiveUserPostsModel($this->pdo); 
    }

    public function displayActiveUserPosts() {
        $activeUserPosts = $this->model->getActiveUserPosts(); 
        $adminUsers = $this->model->getAdminUsers();
        $totalPostCount = $this->model->getTotalPostCount(); 
        $deletedPostsLog = $this->model->getDeletedPostsLog();
        $todayPostCount = $this->model->getTodayPostCount(); 
        $createdPostsLog = $this->model->getCreatedPostsLog(); 

        include __DIR__ . '/../views/adminhome.php';
    }
    
}
