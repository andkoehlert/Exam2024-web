<?php include __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/../../auth.php'; 
include __DIR__ . '/../../config.php';  
checkIfLoggedIn('admin');
?>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); // Clear the message after displaying ?>
<?php endif; ?>
<div class="div">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <?= isset($user) ? "Edit User" : "User Overview" ?>
                    <button class="btn btn-danger float-end" onclick="window.history.back()">Go Back</button>
                </h4>
            </div>
            <div class="card-body">
                <?= alertMessage(); ?>
                
                <?php if (isset($user)): ?>
                    <form method="POST" action="/users/update">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['users2_id']); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required class="form-control">
                                </div>
                            </div>
                          <div class="col-md-6">
    <div class="mb-3">
        <label for="">Password</label>
        <input type="password" name="password" value="<?= isset($user['password']) && $user['password'] ? '******' : ''; ?>" required class="form-control">
        <small class="form-text text-muted">Leave empty to keep the current password.</small>
    </div>
</div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Phone No.</label>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="">Select Role</label>
                                    <select name="role" required class="form-select">
                                        <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="user" <?= ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="">Is Ban</label><br/>
                                    <input type="checkbox" name="is_ban" style="width:30px;height:30px;" <?= ($user['is_ban'] == 1) ? 'checked' : ''; ?>>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" name="updateUser" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                
                <!-- User Overview Table -->
                <?php elseif (isset($users)): ?>
                    <p>Here’s the overview of users:</p>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['users2_id']); ?></td>
                                    <td><?= htmlspecialchars($user['name']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td><?= htmlspecialchars($user['phone']); ?></td>
                                    <td><?= htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <a href="/users-edit?id=<?= $user['users2_id']; ?>" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No user data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
   
    <h1>User Posts</h1>
   <div class="posts-container">
    <?php if (!empty($userPosts)): ?>
        <?php foreach ($userPosts as $post):
            $postId = $post['post_id'];
            $imagePath = htmlspecialchars($post['image_path']);
            $isOnFire = $post['is_on_fire'];  // Check if the post is on fire
            $userName = htmlspecialchars($user['name']);
            $tag = htmlspecialchars($post['tag']);
            $description = nl2br(htmlspecialchars($post['description']));
            $createdAt = htmlspecialchars($post['created_at']);
            $totalLikes = $post['like_count'];
            $userLiked = false; // Adjust logic to check if the user liked this post
            
            // Fetch comments for this post
            require_once __DIR__ . '/../../users/controllers/commentController.php';
            $commentController = new CommentController($pdo);
            $comments = $commentController->getCommentsForPost($postId);
        ?>

        <div id="post-<?php echo $postId; ?>" class="post-card">
            <img src="/uploads/<?php echo $imagePath; ?>" 
                 alt="Post Image" 
                 class="img-fluid" 
                 data-toggle="modal" 
                 data-target="#postUserModal-<?php echo $postId; ?>">

            <!-- Display "On Fire" label if the post is marked -->
        <!-- Display "On Fire" label if the post is marked -->
<?php if ($isOnFire): ?>
    <div class="on-fire-label">
        <span class="badge bg-danger">This post is on fire!</span>
    </div>
<?php endif; ?>

<!-- Toggle On Fire Button for Admins -->
<?php if ($_SESSION['role'] === 'admin'): ?>
    <form method="POST" action="/users/toggleOnFire" class="mt-2">
        <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
        <button type="submit" class="btn btn-warning">
            <?php echo $isOnFire ? 'Remove "On Fire"' : 'Mark as "On Fire"'; ?>
        </button>
    </form>
<?php endif; ?>


           
        </div>

        <!-- Modal for Post Details -->
        <div class="modal fade" id="postUserModal-<?php echo $postId; ?>" tabindex="-1" 
             aria-labelledby="postUserModalLabel-<?php echo $postId; ?>" 
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?php echo $tag; ?> by <?php echo $userName; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="/uploads/<?php echo $imagePath; ?>" 
                                     alt="Post Image" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <p><strong>Description:</strong> <?php echo $description; ?></p>
                                <p><strong>Posted on:</strong> <?php echo $createdAt; ?></p>
                                <p><strong>Likes:</strong> <?php echo $totalLikes; ?></p>
                                <?php if ($post['user_id'] == $userId || $_SESSION['role'] == 'admin'): ?>
                                    <button class="btn btn-warning" onclick="window.location.href='/posts/edit?post_id=<?php echo $postId; ?>'">Edit</button>
                                    <button class="btn btn-danger" onclick="deletePost(<?php echo $postId; ?>)">Delete</button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="comments-section">
                            <h5>Comments:</h5>
                            <?php if (!empty($comments)): ?>
                                <ul class="list-group" id="comments-list-<?php echo $postId; ?>">
                                    <?php foreach ($comments as $comment): ?>
                                        <li class="list-group-item" id="comment-<?php echo $comment['comment_id']; ?>">
                                            <strong><?php echo htmlspecialchars($comment['name']); ?>:</strong>
                                            <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?>
                                            <span class="text-muted">
                                                (<?php echo htmlspecialchars($comment['created_at']); ?>)
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No comments yet. Be the first to comment!</p>
                            <?php endif; ?>
                        </div>

                        <form method="POST" action="/comments/submit">
                            <div class="form-group">
                                <textarea name="comment_text" class="form-control" placeholder="Write a comment..." required></textarea>
                                <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>

<!-- Script to delete a post -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-on-fire-btn').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const isOnFire = this.getAttribute('data-is-on-fire') === '1';

            // Send AJAX request
            fetch('/users/toggleOnFire', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}`,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI based on the new status
                    const newStatus = data.is_on_fire;
                    this.setAttribute('data-is-on-fire', newStatus ? '1' : '0');
                    this.textContent = newStatus ? 'Remove "On Fire"' : 'Mark as "On Fire"';

                    // Update or add the "on fire" label
                    const fireLabel = this.closest('.post-card').querySelector('.on-fire-label');
                    if (fireLabel) {
                        fireLabel.style.display = newStatus ? 'block' : 'none';
                    } else if (newStatus) {
                        // Add the label if it doesn't exist and the post is on fire
                        const newLabel = document.createElement('div');
                        newLabel.className = 'on-fire-label';
                        newLabel.innerHTML = '<span class="badge bg-danger">This post is on fire!</span>';
                        this.closest('.post-card').prepend(newLabel);
                    }
                } else {
                    alert(data.error || 'Failed to update post status.');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('An error occurred while toggling the post status.');
            });
        });
    });
});

function deletePost(postId) {
    if (!confirm('Are you sure you want to delete this post?')) {
        return; // User canceled the action
    }

    fetch('/posts/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `post_id=${postId}`, // Send postId in the body
        credentials: 'include', // Include session cookies for authorization
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const postElement = document.getElementById(`post-${postId}`);
            if (postElement) {
                postElement.remove(); // Remove the post from the DOM
            }
            location.reload();
        } else {
            alert(data.error || 'An error occurred while deleting the post.');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An unexpected error occurred.');
    });
}
</script>

