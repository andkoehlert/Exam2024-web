<?php include __DIR__ . '/header.php'; ?>

<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn();
require_once __DIR__ . '/../../config.php';

$userId = $_SESSION['users2_id']; 
?>

?>
<div class="container">
    <h2>User Settings</h2>
    <?php if (!empty($updateMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($updateMessage) ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password (leave blank to keep current password):</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
