<?php
require_once __DIR__ . '/../../function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveUser'])) {

    $name_err = $email_err = $phone_err = $password_err = $role_err = "";
    $name = $email = $phone = $password = $role = $is_ban = "";

    


    if (empty(trim($_POST['name']))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST['name']);
    }

    if (empty(trim($_POST['email']))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $sql = "SELECT users2_id FROM users2 WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) { 
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST['email']);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt); 
        }
    }

    if (empty(trim($_POST['phone']))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST['phone']);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }

    // Validate role
    if (empty($_POST['role'])) {
        $role_err = "Please select a role.";
    } else {
        $role = $_POST['role'];
    }

    $is_ban = isset($_POST['is_ban']) ? 1 : 0; // 1 if checked, 0 if not

    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($role_err)) {
        
        $sql = "INSERT INTO users2 (name, phone, email, password, is_ban, role) 
                VALUES (:name, :phone, :email, :password, :is_ban, :role)";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":is_ban", $param_is_ban, PDO::PARAM_INT); 
            $stmt->bindParam(":role", $param_role, PDO::PARAM_STR); 

            $param_name = trim($_POST["name"]);
            $param_phone = trim($_POST["phone"]);
            $param_email = trim($_POST["email"]);
            $param_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); // Hash the password
            $param_is_ban = $is_ban;
            $param_role = $role; 

            if ($stmt->execute()) {
                redirect('/admin/views/users-create.php', 'User created successfully');
            } else {
                redirect('/admin/views/users-create.php', 'User not created');
            }
            unset($stmt); 
        }
    } else {
        redirect('/admin/views/users-create.php', 'Please fill all fields correctly');
    }
}




?>
