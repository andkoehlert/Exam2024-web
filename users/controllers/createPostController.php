<?php

require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../models/createPost.php';

class PostController {
    private $CreatepostModel;
    private $timeLimit = '2 HOUR';
    private $postLimit = 6;
    private $maxFileSize = 5 * 1024 * 1024; 
    private $maxWidth = 1200;  
    private $maxHeight = 3000; 

    public function __construct($pdo) {
        $this->CreatepostModel = new CreatePost($pdo); 
    }

    public function createPost($userId, $tag, $description, $image) {
        $postCountData = $this->CreatepostModel->countRecentPostsByUser($userId, $this->timeLimit);
        if ($postCountData['post_count'] >= $this->postLimit) {
            return [
                'success' => false,
                'error' => "You can only create {$this->postLimit} posts per {$this->timeLimit}. Please try again later.",
            ];
        }

        $uploadDir = __DIR__ . '/../../uploads/';
        $fileName = uniqid() . "-" . basename($image["name"]);
        $filePath = $uploadDir . $fileName;

        error_log("Upload directory: " . $uploadDir);
        error_log("Target file path: " . $filePath);

        if (!is_dir($uploadDir)) {
            error_log("Error: Upload directory does not exist.");
            return ['success' => false, 'error' => 'Upload directory does not exist.'];
        }

        if (!is_writable($uploadDir)) {
            error_log("Error: Upload directory is not writable.");
            return ['success' => false, 'error' => 'Upload directory is not writable.'];
        }

        // Check the file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $image["type"];
        error_log("Uploaded file type: " . $fileType);

        if (!in_array($fileType, $allowedTypes)) {
            error_log("Error: Invalid file type - " . $fileType);
            return ['success' => false, 'error' => 'Invalid image type. Only JPEG, PNG, and GIF are allowed.'];
        }

        if ($image['size'] > $this->maxFileSize) {
            error_log("Error: File size exceeds the maximum limit of " . $this->maxFileSize . " bytes.");
            return ['success' => false, 'error' => 'File size is too large. The maximum allowed size is 5MB.'];
        }

        if ($image['error'] !== UPLOAD_ERR_OK) {
            error_log("Upload error code: " . $image['error']);
            return ['success' => false, 'error' => 'Error with file upload. Error code: ' . $image['error']];
        }

        list($width, $height) = getimagesize($image['tmp_name']);
        error_log("Uploaded image dimensions: {$width}x{$height}");

        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            error_log("Error: Image dimensions exceed the maximum allowed size. Max allowed: {$this->maxWidth}x{$this->maxHeight}.");
            return ['success' => false, 'error' => "Image dimensions are too large. The maximum allowed dimensions are {$this->maxWidth}x{$this->maxHeight}."];
        }

        error_log("Temporary file: " . $image["tmp_name"]);

        if (!move_uploaded_file($image["tmp_name"], $filePath)) {
            error_log("Error: Unable to move uploaded file to target directory.");
            return ['success' => false, 'error' => 'Error uploading the image.'];
        }

        error_log("File uploaded successfully: " . $filePath);

        $result = $this->CreatepostModel->createPost($userId, $fileName, $tag, $description);
        if ($result) {
            error_log("Post successfully created.");
            return ['success' => true, 'message' => 'Post successfully created!'];
        } else {
            error_log("Error: Failed to save the post.");
            return ['success' => false, 'error' => 'Error saving the post. Please try again.'];
        }
    }
}
