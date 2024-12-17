<?php  include __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . '/../../auth.php';
checkIfLoggedIn('admin');
?>


<?php
$paraResult = checkParamId('id');

if(is_numeric(($paraResult))) {
$userId = $paraResult;

$user = getById('users2', $userId);

if($user['status'] == 200) {

  $userDeleteRes = deleteQuery('users2', $userId);

  if($userDeleteRes) {
    redirect('/users', 'User deleted successfully');
        } else {
            // Step 5: Handle if deletion fails
            redirect('/users', 'Failed to delete the user');
        }
    } else {
        // Step 6: Handle if user does not exist
        redirect('/users', $user['message']);
    }
} else {
    // Step 7: Handle invalid ID
    redirect('/users', $paraResult);
}

?>
