<?php

class UserInformation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch user details by user ID
    public function getUserInformation($userId) {
        $sql = "SELECT name, email FROM users2 WHERE users2_id = :users2_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['users2_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
