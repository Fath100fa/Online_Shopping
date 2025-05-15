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
    <title>CompuVerse</title>
</head>
<body>

    <nav>
        <h3>CompuVerse</h3>

        <div class="nav-search">
            <input type="search" id="search" placeholder="Search for a product...">
        </div>

        <ul>
            <li><a href="profile.php">
                <?php
                    if (isset($_SESSION["username"])) {
                        echo $_SESSION["username"];
                    } else {
                        echo "Guest";
                    }
                ?>
            </a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="Login.php">Login</a></li>
            <li><a href="register.php">Sign up</a></li>
        </ul>
    </nav>

    <header>
        <h1>Welcome to CompuVerse</h1>
        <p>Your one-stop shop for all things tech!</p>
    </header>

    <section>

        <h2>Featured Products</h2>
        <div class="products">
            <?php
                if (empty($products) || !is_array($products)) {
                    echo '<p>No products available at the moment.</p>';
                } else {
                    foreach ($products as $product) {
                        echo '<div class="product" id="item' . htmlspecialchars($product['id']) . '">';
                        echo '<a href="details.php?id=' . urlencode($product['id']) . '">';
                        echo '<img src="img/' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
                        echo '</a>';
                        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($product['price']) . ' EGP</p>';
                        echo '<a href="details.php?id=' . urlencode($product['id']) . '"><button>View Details</button></a>';
                        echo '<button onclick="addToCart(\'item' . htmlspecialchars($product['id']) . '\')">Add to Cart</button>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
    
</body>
</html>
