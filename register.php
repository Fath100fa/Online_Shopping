<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $date_of_birth = $_POST["date"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Validate password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if username or email already exists
        $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert the new user
            $insert_sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $username, $email, $password_hash);
            
            if ($insert_stmt->execute()) {
                $_SESSION["username"] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
</head>
<body>
    <form id="SignupForm" action="register.php" method="post">
        <h1><i class="fas fa-user-plus"></i> Sign up</h1>
        
        <?php if (isset($error)) { echo "<p style='color: red'><i class='fas fa-exclamation-circle'></i> $error</p>"; } ?>
        
<div class="input-container">
    <i class="fas fa-user input-icon"></i>
    <input type="text" name="username" id="username" placeholder="Username" required>
</div>

<div class="input-container">
    <i class="fas fa-envelope input-icon"></i>
    <input type="email" name="email" id="email" placeholder="Email" required>
</div>

<div class="input-container">
    <i class="fas fa-calendar-alt input-icon"></i>
    <input type="date" name="date" id="date" placeholder="Date of Birth" required>
</div>

<div class="password-container">
    <i class="fas fa-lock input-icon"></i>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword" onclick="showPassword()"></i>
</div>

<div class="password-container">
    <i class="fas fa-lock input-icon"></i>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
    <i class="fa-solid fa-eye-slash toggle-password" id="toggleConfirmPassword" onclick="showPassword1()"></i>
</div>

<input type="submit" id="register" value="Register">
<h4><i class="fas fa-sign-in-alt"></i> Already have an account? <a href="login.php">Login</a> </h4>

<script src="js/script.js"></script>
    </form>
</body>


</html>