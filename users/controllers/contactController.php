<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/contact_us.php'; 
require_once __DIR__ . '/../../auth.php'; 

class ContactController {

    public function __construct() {
        $this->model = new ContactModel();
    }


    public function showPublic()
{
    $contactModel = new ContactModel();

    $content = $contactModel->getContent();
    require_once __DIR__ . '/../views/contact_Userpage.php';
}

}
