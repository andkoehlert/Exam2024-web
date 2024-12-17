<?php

class AboutModel {
    private $pdo;

    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
    }

    public function getAboutContent() {
        $sql = "SELECT content FROM about LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function updateAboutContent($content) {
        $sql = "UPDATE about SET content = :content WHERE id = 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['content' => $content]);
    }
    
}
