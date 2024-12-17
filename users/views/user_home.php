<?php 
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn();
require_once __DIR__ . '/../../config.php';

checkIfLoggedIn();

if (isset($_SESSION['users2_id'])) {
    $profileUserId = $_SESSION['users2_id'];
} else {
    echo "Error: No user logged in.";
    exit;
}

include __DIR__ . '/header.php'; 
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
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
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
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
</div>
<?php

