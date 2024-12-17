<?php

class ContactModel {
    private $pdo;

    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
    }

    public function getContactContent() {
        $stmt = $this->pdo->query("SELECT content FROM contact LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC)['content'] ?? 'contact are not available at the moment.';
    }

    public function updateContactContent($newContent) {
        $stmt = $this->pdo->prepare("UPDATE contact SET content = :content WHERE id = 1");
        return $stmt->execute(['content' => $newContent]);
    }
}
