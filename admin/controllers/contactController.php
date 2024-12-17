<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/contactModal.php'; 
require_once __DIR__ . '/../../auth.php'; 

class ContactController {
    private $model;

    public function __construct() {
        $this->model = new ContactModel();
    }

    public function showPublic()
    {
        $contactModel = new ContactModel();
    
        $content = $contactModel->getContent();
        require_once __DIR__ . '/../../users/views/contact_UserPage.php';
    }

    public function edit() {
        checkIfLoggedIn('admin');

        $contactContent = $this->model->getContactContent();

        require_once __DIR__ . '/../views/contact_edit.php';
    }

    public function update() {
        checkIfLoggedIn('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$newContent = htmlspecialchars($_POST['contact_content'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($this->model->updateContactContent($newContent)) {
        $_SESSION['message'] = "Contact content updated successfully.";
        $_SESSION['message_type'] = "success";
        header('Location: /contact_edit'); 
        exit;
    } else {
        $_SESSION['message'] = "Error updating contact content.";
        $_SESSION['message_type'] = "error";
        header('Location: /contact_edit'); 
        exit;
    }
}
    }

   
}
