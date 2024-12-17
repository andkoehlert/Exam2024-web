<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn('admin');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $userId = $_POST['delete_id'];

    $isDeleted = deleteUserById($userId); 

    if ($isDeleted) {
        $_SESSION['status'] = "User deleted successfully.";
    } else {
        $_SESSION['status'] = "Failed to delete the user.";
    }
}
?>
<?php
$users = getALL('users2');
?>

<div class="div">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>
          User List
          <a href="/users-create" class="btn btn btn-primary float-end">Add user</a>
        </h4>
      </div>
      <div class="card-body">
      <?= alertMessage(); ?>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>role</th>
              <th>ban</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['users2_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo $user['is_ban'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="/users-edit?id=<?php echo $user['users2_id']; ?>" 
                        class="btn btn-primary">Edit</a>

                        <form method="POST" style="display:inline;">
    <input type="hidden" name="delete_id" value="<?php echo $user['users2_id']; ?>">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
</form>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


