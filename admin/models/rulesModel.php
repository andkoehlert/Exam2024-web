<?php

class RulesModel {
    private $pdo;

    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
    }

    public function getRulesContent() {
        $stmt = $this->pdo->query("SELECT content FROM rules LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC)['content'] ?? 'Rules are not available at the moment.';
    }

    public function updateRulesContent($newContent) {
        $stmt = $this->pdo->prepare("UPDATE rules SET content = :content WHERE id = 1");
        return $stmt->execute(['content' => $newContent]);
    }
}
