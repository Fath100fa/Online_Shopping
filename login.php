<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password_hash"])) {
            $_SESSION["username"] = $row["username"];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <form id="loginForm" action="login.php" method="post">
    <h1><i class="fas fa-sign-in-alt"></i> Login</h1>
    
    <?php if (isset($error)) { echo "<p style='color: red'><i class='fas fa-exclamation-circle'></i> $error</p>"; } ?>

    <input type="text" name="username" id="username" placeholder="Username or Email" required>
    <i class="fas fa-user" style="position: relative; left: -95%; top: -50px;"></i>
    <br>
    <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password"  required>
        <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword" onclick="showPassword()"></i>
    </div>
    <i class="fas fa-lock" style="position: relative; left: -95%; top: -50px;"></i>
    <br>
    <input type="submit" id="login" value="Login">
    <h4><i class="fas fa-user-plus"></i> Don't have an account? <a href="register.php">Sign up</a> </h4>
    <h4><i class="fas fa-key"></i> Forgot your password? <a href="forgotpassword.php">Reset Password</a> </h4>

    </form>
    <script src="js/script.js"></script>
</body>
</html>