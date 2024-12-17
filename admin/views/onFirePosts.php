<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn('admin');
?>
<div class="container mt-5">
        <h1>🔥 Posts On Fire 🔥</h1>

        <?php if (!empty($posts)): ?>
          
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= htmlspecialchars($post['user_id']) ?></td>
            <td><?= htmlspecialchars($post['tag']) ?></td>
            <td><?= htmlspecialchars($post['description']) ?></td>
            <td><?= htmlspecialchars($post['created_at']) ?></td>
            <td>
                <!-- Display the image -->
                <?php if (!empty($post['image_path'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($post['image_path']); ?>" 
                         alt="Post Image" 
                         class="img-thumbnail" 
                         style="max-width: 100px; height: auto;">
                <?php else: ?>
                    <p>No image</p>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                </tbody>
            </table>
        <?php else: ?>
            <p>No posts are currently on fire.</p>
        <?php endif; ?>
    </div>

