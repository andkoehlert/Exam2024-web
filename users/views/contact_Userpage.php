<?php include __DIR__ . '/header.php'; ?>
<?php
include __DIR__ . '/../../config.php'; 
?>
<?php 
require_once __DIR__ . '/../../auth.php';


checkIfLoggedIn();
?>

<body>
    <h1>Contact information</h1>
    <p><?php echo htmlspecialchars($content); ?></p>
</body>
</html>
