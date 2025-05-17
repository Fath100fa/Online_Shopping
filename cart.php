<?php
    session_start();
    include "conn.php";
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Handle Add to Cart (from index.php)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
        $pid = intval($_POST['product_id']);
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]++;
        } else {
            $_SESSION['cart'][$pid] = 1;
        }
        header("Location: cart.php");
        exit;
    }

    // Handle quantity update
    if (isset($_POST['update_qty'], $_POST['pid'])) {
        $pid = intval($_POST['pid']);
        $qty = max(1, intval($_POST['update_qty']));
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] = $qty;
        }
        header("Location: cart.php");
        exit;
    }

    // Handle remove item
    if (isset($_POST['remove_pid'])) {
        $pid = intval($_POST['remove_pid']);
        unset($_SESSION['cart'][$pid]);
        header("Location: cart.php");
        exit;
    }

    // Handle clear cart
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        header("Location: cart.php");
        exit;
    }

    // Fetch products in cart
    $cart_products = [];
    $total = 0;
    if (!empty($_SESSION['cart'])) {
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
    <title>Cart - CompuVerse</title>
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
        <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
        <p><i class="fas fa-microchip"></i> Review your selected tech products!</p>
    </header>

    <section>
        <h2><i class="fas fa-cart-arrow-down"></i> Cart Items</h2>
        <?php if (empty($cart_products)): ?>
            <p><i class="fas fa-exclamation-circle"></i> Your cart is empty.</p>
        <?php else: ?>
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
                        <form method="POST" style="display:inline;" class="cart-qty-controls">
                            <input type="hidden" name="pid" value="<?php echo $item['id']; ?>">
                            <button class="qty-btn" type="submit" name="update_qty" value="<?php echo max(1, $item['qty']-1); ?>"><i class="fas fa-minus"></i></button>
                            <span class="cart-qty"><?php echo $item['qty']; ?></span>
                            <button class="qty-btn" type="submit" name="update_qty" value="<?php echo $item['qty']+1; ?>"><i class="fas fa-plus"></i></button>
                        </form>
                        <div class="cart-item-price">
                            <i class="fas fa-money-bill-wave"></i> <?php echo $item['subtotal']; ?> EGP
                        </div>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="remove_pid" value="<?php echo $item['id']; ?>">
                            <button class="qty-btn" style="background:#dc3545;" title="Remove"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <div style="text-align:right;font-size:1.2em;margin-top:15px;">
                    <strong>Total: <?php echo $total; ?> EGP</strong>
                </div>
                <form method="POST" style="text-align:right; display:inline;">
                    <button id="clear-cart-button" name="clear_cart" type="submit"><i class="fas fa-trash-alt"></i> Clear Cart</button>
                </form>
                <form action="checkout.php" method="GET" style="text-align:right; display:inline;">
                    <button id="checkout-button" type="submit" style="background:#58b35b; color:#fff; border:none; border-radius:6px; padding:8px 18px; font-size:15px; margin-top:10px; margin-left:10px; cursor:pointer; transition:background 0.2s;">
                        <i class="fas fa-credit-card"></i> Checkout
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <p><i class="far fa-copyright"></i> 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>