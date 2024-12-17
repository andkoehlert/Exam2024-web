<?php
session_start();
ob_start();
require '../function.php'; 
// THis is for creating a user in the admin panel
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveUser'])) {

    $name_err = $email_err = $phone_err = $password_err = $role_err = "";
    $name = $email = $phone = $password = $role = $is_ban = "";

    if (empty(trim($_POST['name']))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST['name']);
    }

    // Validate email
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
                echo "Oops! Something went wrong while checking email. Please try again later.";
                print_r($pdo->errorInfo()); 
            }
            unset($stmt); 
        }
    }

    if (empty(trim($_POST['phone']))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $sql = "SELECT users2_id FROM users2 WHERE phone = :phone";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $param_phone = trim($_POST["phone"]);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $phone_err = "This phone number is already taken.";
                } else {
                    $phone = trim($_POST['phone']);
                }
            } else {
                echo "Oops! Something went wrong while checking phone. Please try again later.";
                print_r($pdo->errorInfo()); 
            }
            unset($stmt);
        }
    }

    // Validate password
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

    $is_ban = isset($_POST['is_ban']) ? 1 : 0; 

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

            // Set parameters
            $param_name = trim($_POST["name"]);
            $param_phone = trim($_POST["phone"]);
            $param_email = trim($_POST["email"]);
            $param_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); 
            $param_is_ban = $is_ban;
            $param_role = $role; 

           
            if ($stmt->execute()) {
                redirect('/admin/users.php', 'User created successfully');
            } else {
                redirect('/users-create', 'User not created');
            }
            unset($stmt); 
        }
    } else {
        $_SESSION['errors'] = [
            'name_err' => $name_err,
            'email_err' => $email_err,
            'phone_err' => $phone_err,
            'password_err' => $password_err,
            'role_err' => $role_err
        ];
        $_SESSION['inputs'] = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'role' => $_POST['role']
        ];
        redirect('/users-create', 'Please fill all fields correctly');
    }
}

if(isset($_POST['updateUser'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;
    $id = $_POST['id'];

    $userID = getById('users2', $id);
    if ($userID['status'] != 200) {
        redirect('/users-edit?id=' . $id, 'User not found');
    }

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password)) {
        $sql = "UPDATE users2 SET 
            name = :name,   
            email = :email, 
            phone = :phone, 
            password = :password, 
            role = :role, 
            is_ban = :is_ban 
            WHERE users2_id = :id";
   
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':is_ban', $is_ban, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            redirect('/admin/users.php', 'User admin successfully updated');
        } else {
            redirect('/admin/users-edit.php', 'User not updated');
        }
    }
}
?>
