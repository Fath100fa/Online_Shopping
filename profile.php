<?php
session_start();
include "conn.php";

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Get user information
$username = $_SESSION["username"];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav>
        <h3><i class="fas fa-laptop-code"></i> CompuVerse</h3>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="user-profile-container">
        <h1><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($username."'s Profile"); ?> </h1>
        
        <div class="profile-section">
            <p><i class="fas fa-user"></i> <strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        
        <div class="profile-section">
            <h2><i class="fas fa-shopping-bag"></i> Order History</h2>
            <p><i class="fas fa-info-circle"></i> Order history will be displayed here.</p>
        </div>
        
        <div class="profile-section">
            <h2><i class="fas fa-cog"></i> Account Settings</h2>
            <button class="profile-button">
                <i class="fas fa-key"></i><a href="forgotpassword.php" id="profpass"> Change Password</a></button>
            <button class="profile-button">
                <i class="fas fa-user-edit"></i> Edit Profile
</button>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
