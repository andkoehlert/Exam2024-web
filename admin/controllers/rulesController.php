<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/rulesModel.php'; 
require_once __DIR__ . '/../../auth.php'; 

class RulesController {
    private $model;

    public function __construct() {
        $this->model = new RulesModel();
    }

    public function index() {
        $rulesContent = $this->model->getRulesContent();
        
        require_once __DIR__ . '/../views/rules_page.php';
    }

    public function edit() {
        checkIfLoggedIn('admin');

        $rulesContent = $this->model->getRulesContent();

        // Load the edit view
        require_once __DIR__ . '/../views/rules_edit.php';
    }

    public function update() {
        checkIfLoggedIn('admin');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$newContent = htmlspecialchars($_POST['rules_content'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($this->model->updateRulesContent($newContent)) {
        $_SESSION['message'] = "Rules content updated successfully.";
        $_SESSION['message_type'] = "success";
        header('Location: /rules_edit'); // Redirect to the same page
        exit;
    } else {
        $_SESSION['message'] = "Error updating rules content.";
        $_SESSION['message_type'] = "error";
        header('Location: /rules_edit'); // Redirect to the same page
        exit;
    }
}
    }

   
}
