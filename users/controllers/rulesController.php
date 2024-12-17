<?php
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/rules.php'; 
require_once __DIR__ . '/../../auth.php'; 

class RulesController {

    public function __construct() {
        $this->model = new RulesModel();
    }


    public function showPublic()
{
    $RulesModel = new RulesModel();

    $content = $RulesModel->getContent();
    require_once __DIR__ . '/../views/rules_UserPage.php';
}

}
