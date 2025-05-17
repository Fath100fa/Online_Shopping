<?php
session_start();
include "conn.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$product) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - CompuVerse</title>
    <link rel="stylesheet" href="css/Details.css">
    <link rel="stylesheet" href="css/main.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav>
    <h3><i class="fas fa-laptop-code"></i> CompuVerse</h3>
    <ul>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION["username"] ?? "Guest"; ?></a></li>
        <li><a href="Login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <li><a href="register.php"><i class="fas fa-user-plus"></i> Sign up</a></li>
    </ul>
</nav>

<main class="product-details">
    <div class="left">
        <img src="img/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
    </div>
    <div class="right">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($product['price']); ?> EGP</p>
        <p><strong>Rating:</strong> <?php echo htmlspecialchars($product['rating']); ?> / 5</p>
        <h3><i class="fas fa-info-circle"></i> Specifications</h3>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        
    </div>
</main>


<footer>
    <p><i class="far fa-copyright"></i> 2023 CompuVerse. All rights reserved.</p>
</footer>

</body>
</html>
