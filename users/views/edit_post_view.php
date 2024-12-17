<?php include __DIR__ . '/header.php'; ?>
<?php
include __DIR__ . '/../../config.php';  
?>
<?php 
require_once __DIR__ . '/../../auth.php';


checkIfLoggedIn();
?>

<div class="container mt-5">
    <h2>Edit Post</h2>
    <form method="POST">
        <div class="form-group">
            <label for="tag">Tag:</label>
            <input type="text" name="tag" id="tag" class="form-control" value="<?php echo htmlspecialchars($post['tag']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required><?php echo htmlspecialchars($post['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
