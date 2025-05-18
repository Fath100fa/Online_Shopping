<?php
session_start();
include "conn.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

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
            <p>
                <?php
                $order_sql = "SELECT * FROM orders WHERE user_id = ?";
                $order_stmt = $conn->prepare($order_sql);
                $order_stmt->bind_param("i", $user['id']);
                $order_stmt->execute();
                $order_result = $order_stmt->get_result();

                if ($order_result->num_rows > 0) {
                    while ($order = $order_result->fetch_assoc()) {
                        echo "<div class='order-block'>";
                        echo "<p>Order ID: " . htmlspecialchars($order['id']) . " - Total: $" . htmlspecialchars($order['total_amount']) . "</p>";

                        // Fetch order items for this order
                        $item_sql = "SELECT oi.*, p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?";
                        $item_stmt = $conn->prepare($item_sql);
                        $item_stmt->bind_param("i", $order['id']);
                        $item_stmt->execute();
                        $item_result = $item_stmt->get_result();

                        if ($item_result->num_rows > 0) {
                            echo "<ul>";
                            while ($item = $item_result->fetch_assoc()) {
                                echo "<li>" . htmlspecialchars($item['product_name']) . " (Qty: " . htmlspecialchars($item['quantity']) . ")</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No items found for this order.</p>";
                        }
                        $item_stmt->close();

                        echo "</div>";
                    }
                } else {
                    echo "<p>No orders found.</p>";
                }

                $order_stmt->close();
                ?>

            </p>
        </div>
        
        <div class="profile-section">
            <h2><i class="fas fa-cog"></i> Account Settings</h2>
            <button class="profile-button">
                <i class="fas fa-key"></i><a href="forgotpassword.php" id="profpass"> Change Password</a></button>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
