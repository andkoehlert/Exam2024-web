<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../config.php';
checkIfLoggedIn('admin');
?>

<div class="div">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>
          <?php 
          if (isset($_GET['id']) && is_numeric($_GET['id'])) {
              echo "Edit User";
          } else {
              echo "User Overview";  
          }
          ?>
          <button class="btn btn-danger float-end" onclick="window.history.back()">Go Back</button>
        </h4>
      </div>
      <div class="card-body">
      <?= alertMessage(); ?>
        <?php 
          if (isset($_GET['id']) && is_numeric($_GET['id'])) {
              $paramResult = checkParamId('id');
              
              if (!is_numeric($paramResult)) {
                  echo '<h4>' . htmlspecialchars($paramResult) . '</h4>';
                  return false;
              }

              // Fetch user by ID
              $user = getById('users2', $paramResult);
              if ($user['status'] == 200) {
                  $userData = $user['data'];
        ?> 



              <form method="POST" action="/admin/views/code.php">
              <input type="hidden" name="id" value="<?= htmlspecialchars($userData['users2_id']); ?>">

                <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" value="<?= htmlspecialchars($userData['name']); ?>" required class="form-control">             
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" value="<?= htmlspecialchars($userData['email']); ?>" required class="form-control">             
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" id="" value="<?= htmlspecialchars($userData['password']); ?>" required class="form-control">             
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="">Phone No.</label>
                        <input type="text" name="phone" id="" value="<?= htmlspecialchars($userData['phone']); ?>" required class="form-control">             
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="mb-3">
                        <label for="">Select role</label>
                        <select name="role" id="" required class="form-select">
                          <option value="admin" <?= ($userData['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                          <option value="user" <?= ($userData['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                        </select>          
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="mb-3">
                        <label for="">Is ban</label>
                        <br/>
                        <input type="checkbox" name="is_ban" style="width:30px;height:30px;" <?= ($userData['is_ban'] == 1) ? 'checked' : ''; ?>>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="md-3 text-end">
                        <button type="submit" name="updateUser" class="btn btn-primary">Update</button>
                      </div>
                    </div>
                </div>
              </form>

        <?php 
              } else {
                  echo '<h4>' . htmlspecialchars($user['message']) . '</h4>';
                  return false;
              }
              
          } else {
              // If 'id' is not set, show a list of users or an overview
              echo "<p>No specific user selected. Here's the overview of users:</p>";
              
              // Fetch all users
              $users = getALL('users2');

              if (!empty($users)) {
                  echo '<table class="table table-bordered table-striped">';
                  echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Action</th></tr></thead>';
                  echo '<tbody>';
                  foreach ($users as $user) {
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($user['users2_id']) . '</td>';
                      echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                      echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                      echo '<td>' . htmlspecialchars($user['phone']) . '</td>';
                      echo '<td>' . htmlspecialchars($user['role']) . '</td>';
                      echo '<td><a href="/admin/views/users-edit?id=' . $user['users2_id'] . '" class="btn btn-primary">Edit</a></td>';
                      echo '</tr>';
                  }
                  echo '</tbody></table>';
              } else {
                  echo '<p>No users found.</p>';
              }
          }
        ?>

      </div>
    </div>
  </div>
</div>

