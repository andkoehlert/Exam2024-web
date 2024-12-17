<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/admin_home">
        <img src="/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">SoMe </span>
      </a>
    </div>


    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link  active"  href="/admin_home">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-home text-white text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">Homepage</span>
          </a>
        </li>
 <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manage services</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="/manage_pages">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-bullhorn text-dark text-lg"></i>

            </div>
            <span class="nav-link-text ms-1">Manage pages</span>
          </a>
        </li>
       
       
        <li class="nav-item">
          <a class="nav-link  "  href="/admin_home">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-bullhorn text-dark text-lg"></i>

            </div>
            <span class="nav-link-text ms-1">Tables</span>
          </a>
        </li>


        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manage services</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="/admin">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-bullhorn text-dark text-lg"></i>

            </div>
            <span class="nav-link-text ms-1">Manage services (wip)</span>
          </a>
        </li>
       
        
   
        <li class="nav-item">
          <a class="nav-link  " href="/admin/views/users.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-user-plus text-dark text-lg"></i>

            </div>
            <span class="nav-link-text ms-1">Manage users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  "  href="/admin/users-create.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-globe text-dark text-lg"></i>

            </div>
            <span class="nav-link-text ms-1">Create user</span>
          </a>
        </li>
   
       
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
    <li class="nav-item d-flex align-items-center">
    <?php if (isset($_SESSION['users2_id'])): // Check if user is logged in ?>
        <a href="/logout" class="btn bg-gradient-primary mt-3 w-100">
            Logout
        </a>
    <?php else: // User is not logged in ?>
        <a href="/login" class="btn bg-gradient-secondary mt-3 w-100">
            Login
        </a>
    <?php endif; ?>
</li>
    </div>
  </aside>