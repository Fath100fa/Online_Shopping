<?php
session_start();
include "conn.php";

$step = 1; // Default to step 1 (email input)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Email verification
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        
        // Check if the email exists
        $check_sql = "SELECT * FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            // Email exists, store it in session and proceed to step 2
            $_SESSION["reset_email"] = $email;
            $step = 2;
        } else {
            $error = "Email not found in our records";
        }
    }
    
    // Step 2: Password reset
    if (isset($_POST["new_password"]) && isset($_SESSION["reset_email"])) {
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        
        // Validate password match
        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match";
            $step = 2;
        } else {
            // Update the password
            $email = $_SESSION["reset_email"];
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            
            $update_sql = "UPDATE users SET password_hash = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $password_hash, $email);
            
            if ($update_stmt->execute()) {
                // Password updated successfully
                unset($_SESSION["reset_email"]);
                $success = "Password updated successfully";
                $step = 3;
            } else {
                $error = "Failed to update password: " . $conn->error;
                $step = 2;
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <form id="resetPasswordForm" action="forgotpassword.php" method="post">
        <h1><i class="fas fa-key"></i> Reset Password</h1>
        
        <?php if (isset($error)) { echo "<p style='color: red'><i class='fas fa-exclamation-circle'></i> $error</p>"; } ?>
        <?php if (isset($success)) { echo "<p style='color: green'><i class='fas fa-check-circle'></i> $success</p>"; } ?>
        
        <?php if ($step == 1): ?>
            <!-- Step 1: Enter email -->
            <h4><i class="fas fa-envelope"></i> Enter your email to reset your password</h4>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <br>
            <input id="login" type="submit" value="Continue">
            <h4><i class="fas fa-sign-in-alt"></i> Remember your password? <a href="login.php">Login</a></h4>
  
        <?php elseif ($step == 2): ?>
            <!-- Step 2: Enter new password -->
            <h4><i class="fas fa-lock"></i> Enter your new password</h4>
            <div class="password-container">
                <input type="password" name="new_password" id="password" placeholder="New Password" required>
                <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <br>
            <div class="password-container">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password" required>
                <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword"></i>
            </div>
            <br>
            <input id="login" type="submit" value="Reset Password">
            
        <?php elseif ($step == 3): ?>
            <!-- Step 3: Success message -->
            <input type="button" id="login" value="Go to Login" onclick="window.location.href='login.php'">
        <?php endif; ?>
        
    </form>
    
    <script src="js/script.js"></script>
</body>
</html> 