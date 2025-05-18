<?php
session_start();
include "conn.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$cart_products = [];
$total = 0;
$ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
$result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['id']];
        $row['subtotal'] = $row['qty'] * $row['price'];
        $cart_products[] = $row;
        $total += $row['subtotal'];
    }
}

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    if (!isset($_SESSION['username'])) {
        $error = "You must be logged in to checkout.";
    } else {
        $username = $_SESSION['username'];
        $user_q = $conn->query("SELECT id FROM users WHERE username='" . $conn->real_escape_string($username) . "' LIMIT 1");
        if ($user_q && $user_q->num_rows > 0) {
            $user = $user_q->fetch_assoc();
            $user_id = $user['id'];

            $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, total_amount) VALUES (?, NOW(), ?)");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("id", $user_id, $total);
            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;

                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                if (!$item_stmt) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }
                foreach ($cart_products as $item) {
                    $item_stmt->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
                    $item_stmt->execute();
                }
                $item_stmt->close();

                $_SESSION['cart'] = [];
                $success = true;
            } else {
                $error = "Failed to place order. Please try again.";
            }
            $stmt->close();
        } else {
            $error = "User not found.";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Checkout - CompuVerse</title>
</head>
<body>
    <nav>
        <h3><i class="fas fa-laptop-code"></i> CompuVerse</h3>
        <div class="nav-search">
            <input type="search" id="search" placeholder="Search">
            <i class="fas fa-search" style="position: relative; right: 25px;"></i>
        </div>
        <ul>
            <li><a href="profile.php">
                <i class="fas fa-user"></i>
                <?php
                    if (isset($_SESSION["username"])) {
                        echo $_SESSION["username"];
                    } else {
                        echo "Guest";
                    }
                ?>
            </a></li>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <?php
                if (isset($_SESSION["username"])) {
                    echo '<li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>';
                    echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                }
            ?>
            <?php
                if (!isset($_SESSION["username"])) {
                    echo '<li><a href="Login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
                    echo '<li><a href="register.php"><i class="fas fa-user-plus"></i> Sign up</a></li>';
                }
            ?>
        </ul>
    </nav>

    <header>
        <h1><i class="fas fa-credit-card"></i> Checkout</h1>
        <p><i class="fas fa-microchip"></i> Confirm your order and complete your purchase!</p>
    </header>

    <section>
        <h2><i class="fas fa-cart-arrow-down"></i> Order Summary</h2>
        <?php if ($success): ?>
            <div style="color:green; font-size:1.2em; margin-bottom:20px;">
                <i class="fas fa-check-circle"></i> Thank you! Your order has been placed.
            </div>
            <a href="index.php" style="color:#58b35b;">Back to Home</a>
        <?php else: ?>
            <?php if ($error): ?>
                <div style="color:red; margin-bottom:15px;">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div>
                <?php foreach ($cart_products as $item): ?>
                    <div class="cart-item-row">
                        <div class="cart-item-name">
                            <img src="img/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width:40px;vertical-align:middle;border-radius:4px;margin-right:10px;">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </div>
                        <div class="cart-item-price">
                            <?php echo htmlspecialchars($item['price']); ?> EGP
                        </div>
                        <div class="cart-qty">
                            x <?php echo $item['qty']; ?>
                        </div>
                        <div class="cart-item-price">
                            <i class="fas fa-money-bill-wave"></i> <?php echo $item['subtotal']; ?> EGP
                        </div>
                    </div>
                <?php endforeach; ?>
                <div style="text-align:right;font-size:1.2em;margin-top:15px;">
                    <strong>Total: <?php echo $total; ?> EGP</strong>
                </div>
                <form method="POST" style="text-align:right; margin-top:20px;">
                    <button id="checkout-confirm" name="checkout" type="submit" style="background:#58b35b; color:#fff; border:none; border-radius:6px; padding:10px 22px; font-size:16px; cursor:pointer;">
                        <i class="fas fa-check"></i> Confirm & Place Order
                    </button>
                </form>
                <div style="text-align:right; margin-top:10px;">
                    <a href="cart.php" style="color:#007bff;">Back to Cart</a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <p><i class="far fa-copyright"></i> 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>