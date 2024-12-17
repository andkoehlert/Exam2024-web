<?php
// This is for registering as user
ob_start();
require '../function.php';

$name_err = $email_err = $phone_err = $password_err = "";
$name = $email = $phone = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerUser'])) {

    // Validate name
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
                if ($stmt->rowCount() > 0) {
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
                if ($stmt->rowCount() > 0) {
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

    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($password_err)) {
        
        $sql = "INSERT INTO users2 (name, phone, email, password, is_ban, role) 
                VALUES (:name, :phone, :email, :password, 0, 'user')";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            $param_name = $name;
            $param_phone = $phone;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

            try {
                if ($stmt->execute()) {
                    redirect('/login', 'User registered successfully. Please log in.');
                } else {
                    echo "Oops! Something went wrong while creating the user. Please try again later.";
                    print_r($pdo->errorInfo());  
                }
            } catch (PDOException $e) {
                echo "Error executing query: " . $e->getMessage();
            }
            unset($stmt);
        } else {
            echo "Failed to prepare statement. Error: ";
            print_r($pdo->errorInfo());  
        }
    } else {
        $_SESSION['errors'] = [
            'name_err' => $name_err,
            'email_err' => $email_err,
            'phone_err' => $phone_err,
            'password_err' => $password_err
        ];
        $_SESSION['inputs'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        header("Location: /register2");
        exit();
    }
}
?>
