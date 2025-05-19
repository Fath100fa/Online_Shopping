<?php
session_start();
include 'conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND is_admin = 1");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();


    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin'] = $user['id'];
        header("Location: dashboard.php"); 
        exit;
    } else {
        echo "<script>alert('بيانات خاطئة أو مش أدمن'); window.location.href='AdminLogin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <form id="loginForm" action="AdminLogin.php" method="post">
        <h1 style="color:rgb(33, 126, 36);"><i class="fas fa-sign-in-alt"></i> admin page</h1>

        <div class="input-container">
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="username" id="username" placeholder="Username or Email" required>
        </div>

        <div class="password-container">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword" onclick="showPassword()"></i>
        </div>

        <input type="submit" id="login" value="Login">
    </form>

    <script src="js/script.js"></script>
</body>
</html>
