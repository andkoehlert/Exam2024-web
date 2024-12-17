<?php include __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/../../auth.php'; 
include __DIR__ . '/../../config.php'; 
checkIfLoggedIn('admin');
?>


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                   <h5 class="font-weight-bolder mb-0">
                    <p class="">Total Posts: <?= htmlspecialchars($totalPostCount); ?></p>
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
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                      <h5 class="font-weight-bolder mb-0">
                     
                      <p class="">Posts Today: <?= htmlspecialchars($todayPostCount); ?></p>
                      </h5>
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
    
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <h5 class="font-weight-bolder mb-0">
                      <a href="/posts/on-fire">🔥 See fire posts 🔥</a>
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
            <div class="row">
    <div class="col-lg-12">
        <div class="d-flex flex-column h-100">
            <!-- Loop through active user posts -->
            <?php if (!empty($activeUserPosts)): ?>
                <h4>Active Users in the Last 30 Days</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Posts Count</th>
                            <th>Last Post Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activeUserPosts as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['posts_count']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_post_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No active users in the last 30 days.</p>
            <?php endif; ?>
        </div>
    </div>
   
</div>

            </div>
          </div>
        </div>
        <div class="col-lg-5">
            <a href="/posts/on-fire">
          <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/curved-images/curved-10.jpg');">
              <span class="mask bg-gradient-dark"></span>
              <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                <h5 class="text-white font-weight-bolder mb-4 pt-2">🔥 Posts On Fire 🔥</h5>
                
<p class="text-white mb-4 pt-2">Check out all the posts highligtet by admins</p>
              </div>
            </div>
          </div>
        </div>
        </a>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-body p-3">
              
              </div>
              <h2>Deleted Posts Log</h2>
<table class="table mb-4">

  <div class="card-body p-3">
    <tbody>
        <?php foreach ($deletedPostsLog as $log): ?>
            <tr>
            
                <td><strong>Log ID: </strong><?= htmlspecialchars($log['log_id']); ?></td>
                <td><strong>Post ID: </strong> <?= htmlspecialchars($log['post_id']); ?></td>
                <td><strong>User ID: </strong><?= htmlspecialchars($log['user_id']); ?></td>
                <td><strong>Deleted ID: </strong> <?= htmlspecialchars($log['deleted_at']); ?></td>
             
              </tr>
        <?php endforeach; ?>
    </tbody>
   
    </div>
</table>

              </div>
            </div>
          </div> 

          <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-body p-3">
              
              </div>
              <h2>Created Posts Log</h2>
<table class="table mb-4">

  <div class="card-body p-3">
    <tbody>
        <?php foreach ($createdPostsLog as $log): ?>
            <tr>
            
                <td><strong>Log ID: </strong><?= htmlspecialchars($log['log_id']); ?></td>
                <td><strong>Post ID: </strong> <?= htmlspecialchars($log['post_id']); ?></td>
                <td><strong>User ID: </strong><?= htmlspecialchars($log['user_id']); ?></td>
                <td><strong>Created ID: </strong> <?= htmlspecialchars($log['created_at']); ?></td>
             
              </tr>
        <?php endforeach; ?>
    </tbody>
   
    </div>
</table>

        </div>
        <div class="col-lg-12">
        <h2>Admin Users</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adminUsers as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['users2_id']); ?></td>
                    <td><?= htmlspecialchars($admin['name']); ?></td>
                    <td><?= htmlspecialchars($admin['role']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>
   
                

      </div>
    </div>
  </div>
</div>


