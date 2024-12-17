<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn('admin');
?>

<h1>Edit Rules test</h1>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['message_type']); ?>">
        <?= htmlspecialchars($_SESSION['message']); ?>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); // Clear the message after displaying ?>
<?php endif; ?>
<form method="POST" action="/rules/update">
<div class="form-group">
        <label for="rules_content">Content:</label>
        <textarea name="rules_content" id="rulesContent" class="form-control" rows="10"><?php echo htmlspecialchars($rulesContent); ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="/rules" class="btn btn-secondary">Cancel</a>
</form>
