<?php include __DIR__ . '/header.php'; ?>
<?php
include __DIR__ . '/../../config.php';  

?>
<?php 
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../config.php';

checkIfLoggedIn();

if (isset($_SESSION['users2_id'])) {
    $userId = $_SESSION['users2_id'];

    $sql = "SELECT * FROM users2 WHERE users2_id = :user_id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Error: User not found.";
        exit;
    }

    if (!isset($_SESSION['role'])) {
        $_SESSION['role'] = $user['role'];
    }
} else {
    echo "Error: User ID not found in session.";
    exit;
}

?>

<h1>Explore hot Page</h1>
<p>Discover all hot posts below:</p>

<div class="posts-container">
    <?php if (!empty($posts)): ?>
        <?php
        require_once __DIR__ . '/../controllers/commentController.php'; 
        foreach ($posts as $post):
            $postId = $post['post_id'];
            $imagePath = htmlspecialchars($post['image_path']);
            $userName = htmlspecialchars($post['name']);
            $tag = htmlspecialchars($post['tag']);
            $description = nl2br(htmlspecialchars($post['description']));
            $createdAt = htmlspecialchars($post['created_at']);
            $totalLikes = $post['like_count'];
            $isMostLiked = !empty($post['is_most_liked']);
            $userLiked = false; 
           $isOnFire = !empty($post['is_on_fire']); 

            $commentController = new CommentController($pdo);  
            $comments = $commentController->getCommentsForPost($postId);
     
     ?>

        <!-- Render post -->
        <div id="post-<?php echo $postId; ?>" class="post-card">
            <img src="/uploads/<?php echo $imagePath; ?>" 
                 alt="Post Image" 
                 class="img-fluid" 
                 data-toggle="modal" 
                 data-target="#postModal-<?php echo $postId; ?>">
            
             <?php if ($isOnFire): ?>
        <div class="on-fire">
            <span class="badge">This post is on fire!</span>
        </div>
    <?php endif; ?>
            
            <?php if ($isMostLiked): ?>
                <p class="on-fire">🔥 This is the most liked post! 🔥</p>
            <?php endif; ?>
        </div>

        <!-- Modal for comments -->
        <div class="modal fade" id="postModal-<?php echo $postId; ?>" tabindex="-1" 
             aria-labelledby="postModalLabel-<?php echo $postId; ?>" 
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postModalLabel-<?php echo $postId; ?>">
                            <?php echo $tag; ?> by <?php echo $userName; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Post details -->
                        <div class="row">
                            <div class="col-md-6">
                                <img src="/uploads/<?php echo $imagePath; ?>" 
                                     alt="Post Image" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <p><strong>Posted by:</strong> <?php echo $userName; ?></p>
                                <p><strong>Tag:</strong> <?php echo $tag; ?></p>
                                <p><strong>Description:</strong> <?php echo $description; ?></p>
                                <p><strong>Posted on:</strong> <?php echo $createdAt; ?></p>
                                <p><strong>Likes:</strong> <span id="like-count-<?php echo $postId; ?>">
                                    <?php echo $totalLikes; ?>
                                </span></p>
                                <button class="btn btn-<?php echo $userLiked ? 'danger' : 'primary'; ?>" 
                                        onclick="toggleLike(<?php echo $postId; ?>)" 
                                        id="like-btn-<?php echo $postId; ?>">
                                    <?php echo $userLiked ? 'Unlike' : 'Like'; ?>
                                </button>
     
                                <?php
if (($post['user_id'] == $userId) || ($_SESSION['role'] === 'admin')) {
    echo '<!-- User can edit or delete this post -->';
    ?>
    <button class="btn btn-warning" onclick="window.location.href='/posts/edit?post_id=<?php echo $postId; ?>'">Edit</button>
    <button class="btn btn-danger" onclick="deletePost(<?php echo $postId; ?>)">Delete</button>    
    <?php
} else {
    echo '<!-- User cannot edit or delete this post -->';
}
?>
                            </div>
                            
                        </div>  

                        <!-- Comments section -->
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

                    <?php if (!empty($comment['comment_image_path'])): ?>
    <div class="comment-image-container">
        <img src="<?php echo htmlspecialchars($comment['comment_image_path']); ?>" 
             alt="Comment Image" class="img-thumbnail mt-2" style="max-width: 200px;">
    </div>
<?php endif; ?>

                    <?php if ($comment && ($comment['user_id'] == $userId || $_SESSION['role'] == 'admin')): ?>
                        <form action="/comments/delete" method="POST" style="display:inline;">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
</div>


                        <!-- Add comment form -->
      <form id="btnRefresh" class="comment-form" method="POST" action="/comments/submit" enctype="multipart/form-data">
    <div class="form-group">
        <textarea name="comment_text" class="form-control" placeholder="Write a comment..." required></textarea>
        <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
    </div>
    <div class="form-group">
        <label for="comment_image">Upload an image (optional):</label>
        <input type="file" name="comment_image" accept="image/*" class="form-control">
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


<script>
 
 

 function deletePost(postId) {
    if (!confirm('Are you sure you want to delete this post?')) {
        return; 
    }

    fetch(`/posts/delete?post_id=${postId}`, {
        method: 'GET',
        credentials: 'include', 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the deleted post from the UI
            const postElement = document.getElementById(`post-${postId}`);
            if (postElement) {
                postElement.remove(); 
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



function toggleLike(postId) {
    fetch(`/like/toggle?post_id=${postId}`, {
        method: 'GET',
        credentials: 'include',
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);

            likeBtn.textContent = data.liked ? 'Unlike' : 'Like';
            likeBtn.className = `btn btn-${data.liked ? 'danger' : 'primary'}`;
            likeCount.textContent = data.totalLikes;
        } else {
            alert(data.error || 'An error occurred.');
        }
    })
    .catch(err => console.error('Error:', err));
}







</script>
