<?php include __DIR__ . '/../users/views/header.php'; ?>


<?php 
$name_err = $_SESSION['errors']['name_err'] ?? '';
$email_err = $_SESSION['errors']['email_err'] ?? '';
$phone_err = $_SESSION['errors']['phone_err'] ?? '';
$password_err = $_SESSION['errors']['password_err'] ?? '';

$name = $_SESSION['inputs']['name'] ?? '';
$email = $_SESSION['inputs']['email'] ?? '';
$phone = $_SESSION['inputs']['phone'] ?? '';

unset($_SESSION['errors']);
unset($_SESSION['inputs']);
?>



<div class="div">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>
          Register User
          <button class="btn btn-danger float-end" onclick="window.history.back()">Go Back</button>
        </h4>
      </div>
      <div class="card-body">
        <?= alertMessage(); ?>
        <form action="/users/code.php" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">             
                <span class="text-danger"><?= $name_err ?></span> <!-- Error message -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">             
                <span class="text-danger"><?= $phone_err ?></span> <!-- Error message -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">             
                <span class="text-danger"><?= $email_err ?></span> <!-- Error message -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?= $password_err ?></span> <!-- Error message -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="md-3 text-end">
                <button type="submit" name="registerUser" class="btn btn-primary">Register</button>
              </div>
            </div>
          </div>   
        </form>
      </div>
    </div>
  </div>
</div>
