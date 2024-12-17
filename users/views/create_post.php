<?php
 include __DIR__ . '/header.php';

require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn();
require_once __DIR__ . '/../../config.php';

$userId = $_SESSION['users2_id']; 


// Display status messages
if (isset($_SESSION['status'])) {
    echo "<div class='alert alert-info'>{$_SESSION['status']}</div>";
    unset($_SESSION['status']);
}
?>

<div class="container mt-5">
    <h2>Create a New Post</h2>
    <form action="/posts/submit" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tag">Tag:</label>
            <input type="text" name="tag" id="tag" class="form-control" placeholder="Enter a tag">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>
