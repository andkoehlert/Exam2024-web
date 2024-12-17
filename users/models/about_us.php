<?php

class AboutModel {
    private $pdo;

    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
    }

 
    public function getContent()
{
    $stmt = $this->pdo->query("SELECT content FROM about LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC)['content'] ?? 'Content not available.';
}

}
