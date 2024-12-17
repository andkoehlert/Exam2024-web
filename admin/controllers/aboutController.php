<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/aboutModal.php'; 
require_once __DIR__ . '/../../auth.php'; 

class AboutController {
    private $model;

    public function __construct() {
        $this->model = new AboutModel();
    }

    public function index() {
        $aboutContent = $this->model->getAboutContent();
        
        require_once __DIR__ . '/../views/about_page.php';
    }

    public function edit() {
        checkIfLoggedIn('admin');

        $aboutContent = $this->model->getAboutContent();

        require_once __DIR__ . '/../views/about_edit.php';
    }

    public function update() {
        checkIfLoggedIn('admin');

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$newContent = htmlspecialchars($_POST['about_content'] ?? '', ENT_QUOTES, 'UTF-8');

        if ($this->model->updateAboutContent($newContent)) {
            $_SESSION['message'] = "About content updated successfully.";
            $_SESSION['message_type'] = "success";
            header('Location: /about_edit'); 
            exit;
        } else {
            $_SESSION['message'] = "Error updating about content.";
            $_SESSION['message_type'] = "error";
            header('Location: /about_edit'); 
            exit;
        }
    }
}
    public function showPublic()
{
    $aboutModel = new AboutModel();

    $content = $aboutModel->getContent();
    require_once __DIR__ . '/../../users/views/about_UserPage.php';
}

}
