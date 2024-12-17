<?php include __DIR__ . '/header.php'; ?>

<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn();
require_once __DIR__ . '/../../config.php';

$userId = $_SESSION['users2_id'];
?>


<div class="container-fluid py-4">

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                     <a class="" href="/user2_home_page">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Your post</p>
                    <h5 class="font-weight-bolder mb-0">10                      
                    </h5>
                    </a>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                                  <a class="" href="/user_settings">

                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Settings</p>
</a>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>
      <button class="btn btn-danger float-end" onclick="window.history.back()">Go Back</button>


    <div class="container mt-4">
        <h2>User Details</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" value="<?= htmlspecialchars($user['name']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" value="********" readonly>
                <small class="form-text text-muted">Click <a href="/user_update">here</a> to change your information.</small>
            </div>
        </form>
    </div>
</div>
