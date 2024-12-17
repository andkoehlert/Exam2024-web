<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn('admin');
?>

<h1>Edit About This Site</h1>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['message_type']); ?>">
        <?= htmlspecialchars($_SESSION['message']); ?>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); // Clear the message after displaying ?>
<?php endif; ?>

<form action="/update" method="POST">
    <div class="form-group">
        <label for="aboutContent">Content:</label>
        <textarea name="about_content" id="aboutContent" class="form-control" rows="10"><?php echo htmlspecialchars($aboutContent); ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="/about_edit" class="btn btn-secondary">Cancel</a>
</form>

