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
</head>
<body>
    <form id="loginForm" action="login.php" method="post">
    <h1>Login</h1>
    
    <?php if (isset($error)) { echo "<p style='color: red'>$error</p>"; } ?>

    <input type="text" name="username" id="username" placeholder="Username or Email" required>
    <br>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span>
            <input type="checkbox" id="ShowPassword" onclick="showPassword()" >  Show Password
        </span>
    <br>
    <input type="submit" id="login" value="Login">
    <h4 >Don't have an account? <a href="register.php">Sign up</a> </h4>
    <h4 >Forgot your password? <a href="forgotpassword.php">Reset Password</a> </h4>

    </form>
    <script src="js/script.js"></script>
</body>
</html>