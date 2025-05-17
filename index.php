<?php
    session_start();
    include "conn.php";
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $result = $conn->query("SELECT * FROM products");
    if ($result === false) {
        die("Error: " . $conn->error);
    }
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>CompuVerse</title>
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
        <h1><i class="fas fa-store"></i> Welcome to CompuVerse</h1>
        <p><i class="fas fa-microchip"></i> Your one-stop shop for all things tech!</p>
    </header>

    <section>

        <h2><i class="fas fa-star"></i> Featured Products</h2>
        <div class="products">
            <?php
                if (empty($products) || !is_array($products)) {
                    echo '<p><i class="fas fa-exclamation-circle"></i> No products available at the moment.</p>';
                } else {
                    foreach ($products as $product) {
                        echo '<div class="product" id="item' . htmlspecialchars($product['id']) . '">';
                        echo '<a href="details.php?id=' . urlencode($product['id']) . '">';
                        echo '<img src="img/' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . ' " loading="lazy" >';
                        echo '</a>';
                        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                        echo '<p><i class="fas fa-tag"></i> ' . htmlspecialchars($product['price']) . ' EGP</p>';
                        echo '<a href="details.php?id=' . urlencode($product['id']) . '"><button><i class="fas fa-info-circle"></i> View Details</button></a>';
                        echo '<button onclick="addToCart(\'item' . htmlspecialchars($product['id']) . '\')"><i class="fas fa-cart-plus"></i> Add to Cart</button>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <footer>
        <p><i class="far fa-copyright"></i> 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
    
</body>
</html>
