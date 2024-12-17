<?php include __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/../../auth.php'; 
include __DIR__ . '/../../config.php';  
checkIfLoggedIn('admin');
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
          <div class="card">
            <a href="/about_edit">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <h5 class="font-weight-bolder mb-0">
                      Edit About page
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
          <div class="card">
          <a href="/rules_edit">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <h5 class="font-weight-bolder mb-0">
                      Edit rules page
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
          <div class="card">
          <a href="/contact_edit">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <h5 class="font-weight-bolder mb-0">
                      Edit contact page
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
    </div>