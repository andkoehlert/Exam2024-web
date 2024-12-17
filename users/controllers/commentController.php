<?php

require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/comments.php';

class CommentController {
    private $commentModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->commentModel = new Comments($this->pdo);  
    }

    public function getCommentsForPost($postId) {
        return $this->commentModel->getCommentsByPostId($postId);
    }

    public function submitComment($postId, $commentText, $commentImage) {
        if (!empty($postId)) {
            try {
                if (isset($commentImage['tmp_name']) && is_uploaded_file($commentImage['tmp_name'])) {
                    $uploadDir = __DIR__ . '/../../uploads/comments/';
                    $uniqueFilename = uniqid() . '_' . basename($commentImage['name']);
                    $uploadFile = $uploadDir . $uniqueFilename; 
                    
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
    
                    if (move_uploaded_file($commentImage['tmp_name'], $uploadFile)) {
                        $imagePath = '/uploads/comments/' . $uniqueFilename;
                    } else {
                        throw new Exception('Failed to upload image.');
                    }
                } else {
                    $imagePath = null; 
                }
    
                $this->commentModel->addComment($postId, $_SESSION['users2_id'], $commentText, $imagePath);
                
                header("Location: /explore");
                exit;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid comment data.";
        }
    }
    public function deleteComment($commentId) {
        if (!isset($_SESSION['users2_id'])) {
            return json_encode(['success' => false, 'error' => 'You must be logged in to delete comments.']);
        }
    
        $userId = $_SESSION['users2_id'];
        $isAdmin = $_SESSION['role'] === 'admin';  
    
        $query = "SELECT user_id, comment_image_path FROM comments WHERE comment_id = :comment_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['comment_id' => $commentId]);
        $comment = $stmt->fetch();
    
        if ($comment) {
            if ($comment['user_id'] == $userId || $isAdmin) {
                if (!empty($comment['icomment_image_path']) && file_exists(__DIR__ . '/../../' . $comment['image_path'])) {
                    unlink(__DIR__ . '/../../' . $comment['comment_image_path']);
                }

                $deleteSql = "DELETE FROM comments WHERE comment_id = :comment_id";
                $deleteStmt = $this->pdo->prepare($deleteSql);
                if ($deleteStmt->execute(['comment_id' => $commentId])) {
                    return json_encode(['success' => true]);
                } else {
                    return json_encode(['success' => false, 'error' => 'Failed to delete comment.']);
                }
            } else {
                return json_encode(['success' => false, 'error' => 'Unauthorized to delete this comment.']);
            }
        }
    
        return json_encode(['success' => false, 'error' => 'Comment not found.']);
    }
}
