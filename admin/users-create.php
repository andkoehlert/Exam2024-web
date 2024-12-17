<?php
require_once __DIR__ . '/../auth.php';
checkIfLoggedIn('admin');
?>
<?php include('views/header.php') ?>



<div class="div">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>
          Add user
          <button class="btn btn btn-danger float-end" onclick="window.history.back()">Go Back</button>
        </h4>
      </div>
      <div class="card-body">
        <?= alertMessage(); ?>
        <form action="/admin/code.php" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="<?= isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : ''; ?>">
                <?php if (!empty($name_err)) : ?>
                    <div class="text-danger"><?= htmlspecialchars($name_err, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= isset($phone) ? htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') : ''; ?>">
                <?php if (!empty($phone_err)) : ?>
                    <div class="text-danger"><?= htmlspecialchars($phone_err, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?= isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : ''; ?>">
                <?php if (!empty($email_err)) : ?>
                    <div class="text-danger"><?= htmlspecialchars($email_err, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
                <?php if (!empty($password_err)) : ?>
                    <div class="text-danger"><?= htmlspecialchars($password_err, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-3">
              <div class="col-md-3">
                <label for="role">Select role</label>
                <select name="role" class="form-select">
                  <option value="admin" <?= isset($role) && $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                  <option value="user" <?= isset($role) && $role === 'user' ? 'selected' : ''; ?>>User</option>
                </select>
                <?php if (!empty($role_err)) : ?>
                    <div class="text-danger"><?= htmlspecialchars($role_err, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label for="is_ban">Is ban</label>
                <br/>
                <input type="checkbox" name="is_ban" style="width:30px;height:30px;" <?= isset($is_ban) && $is_ban == 1 ? 'checked' : ''; ?>>
              </div>
            </div>

            <div class="col-md-6">
              <div class="md-3 text-end">
                <button type="submit" name="saveUser" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include('views/footer.php') ?>