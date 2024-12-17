<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/about_us.php'; 
require_once __DIR__ . '/../../auth.php'; 

class AboutController {

    public function __construct() {
        $this->model = new AboutModel();
    }


    public function showPublic()
{
    $aboutModel = new AboutModel();

    $content = $aboutModel->getContent();
    require_once __DIR__ . '/../views/about_UserPage.php';
}

}
