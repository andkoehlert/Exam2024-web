<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../../config.php'; 

require_once __DIR__ . '/../models/like.php';
class LikeController {
  private $likeModel;
  private $userId;

  public function __construct($pdo, $userId) {
      $this->likeModel = new Like($pdo);
      $this->userId = $userId;
  }

  
  public function toggleLike($postId) {
      $response = ['success' => false];
      error_log("toggleLike() called for post ID: " . $postId);

      if ($postId > 0 && $this->userId) {
          try {
              error_log("Checking if user {$this->userId} liked post {$postId}");
              $alreadyLiked = $this->likeModel->hasUserLiked($postId, $this->userId);
              error_log("Already liked: " . ($alreadyLiked ? 'Yes' : 'No'));

              if ($alreadyLiked) {
                  $this->likeModel->unlikePost($postId, $this->userId);
              } else {
                  $this->likeModel->likePost($postId, $this->userId);
              }

              $totalLikes = $this->likeModel->getLikeCount($postId);
              error_log("Total likes for post {$postId}: {$totalLikes}");

              $response = [
                  'success' => true,
                  'liked' => !$alreadyLiked,
                  'totalLikes' => $totalLikes,
              ];
          } catch (Exception $e) {
              $response['error'] = 'Error: ' . $e->getMessage();
          }
      }

      // Return the response as JSON
      header('Content-Type: application/json');
      echo json_encode($response);
  }
  
}
