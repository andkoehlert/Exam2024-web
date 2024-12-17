<?php
ob_start(); 

include __DIR__ . '/../users/views/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: /admin_home"); 
    exit; 
}

require_once __DIR__ . '/../config.php'; 

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate reCAPTCHA token
    $recaptchaToken = $_POST['recaptcha_token'] ?? ''; // Get the reCAPTCHA token
    $secretKey = '6LdmCpsqAAAAAHbgyMNDM2LU5r8GV4SKeA4HnDtj'; 
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    // Send POST request to Google's API
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaToken,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $responseKeys = json_decode($response, true);

    if (!isset($responseKeys['success']) || !$responseKeys['success'] || $responseKeys['score'] < 0.5) {
        $_SESSION['status'] = "reCAPTCHA verification failed. Please try again.";
    } else {
        // Check if email is empty
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Check if password is empty
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if (empty($email_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT users2_id, email, password, role FROM users2 WHERE email = :email"; // Include role

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

                // Set parameters
                $param_email = trim($_POST["email"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        if ($row = $stmt->fetch()) {
                            $id = $row["users2_id"];
                            $email = $row["email"];
                            $hashed_password = $row["password"];
                            $role = $row["role"]; // Fetch the role

                            if (password_verify($password, $hashed_password)) {
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["users2_id"] = $id;
                                $_SESSION["email"] = $email;
                                $_SESSION["role"] = $role; 

                                if ($role === 'admin') {
                                    header("Location: /admin_home");
                                } else {
                                    header("Location: /explore");
                                }
                                exit; 
                            } else {
                                $_SESSION['status'] = "Invalid email or password.";
                            }
                        }
                    } else {
                        $_SESSION['status'] = "Invalid email or password.";
                    }
                } else {
                    $_SESSION['status'] = "Oops! Something went wrong. Please try again later.";
                }

                unset($stmt);
            }
        }
    }

    unset($pdo);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
    <!-- Include the reCAPTCHA v3 script -->
  <script src="https://www.google.com/recaptcha/enterprise.js?render=6LdmCpsqAAAAAGmXlYDpL48wxYpxTVB5oYseGO1N"></script>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php alertMessage(); ?>

        <form action="" method="post" id="login-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <input type="hidden" name="recaptcha_token" id="recaptcha-token">

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="/register2">Sign up now</a>.</p>
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting immediately

            // Get the reCAPTCHA token
            grecaptcha.ready(function() {
                grecaptcha.execute('6LdmCpsqAAAAAGmXlYDpL48wxYpxTVB5oYseGO1N', {action: 'submit'}).then(function(token) {
                    // Insert the reCAPTCHA token into the hidden input field
                    document.getElementById('recaptcha-token').value = token;

                    // Submit the form after token is inserted
                    document.getElementById('login-form').submit();
                });
            });
        });
    </script>
</body>
</html>
