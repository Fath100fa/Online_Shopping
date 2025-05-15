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
  <meta charset="UTF-8" />
  <title>details</title>
  <link rel="stylesheet" href="css/Details.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <h1>ASUS TUF Gaming A15</h1>
    <img src="img/Asus_Tuf.jpg" alt="ASUS A15" />
    <p><strong>Price:</strong> 30,000 EGP</p>
    <p>
      <strong>Specs:</strong> Ryzen 7 4800H, RTX 2050 (2GB), 16GB RAM, 512GB SSD + 1TB HDD,
      15.6" Display, Windows 11.
    </p>

    <h2><i class="fas fa-star"></i> Rate this Laptop</h2>
    <div class="rating" id="rating">
      <span data-value="1">&#9733;</span>
      <span data-value="2">&#9733;</span>
      <span data-value="3">&#9733;</span>
      <span data-value="4">&#9733;</span>
      <span data-value="5">&#9733;</span>
    </div>
    
    <button onclick="window.history.back()"><i class="fas fa-arrow-left"></i> Back</button>
    <button onclick="addToCart('asus-a15')"><i class="fas fa-cart-plus"></i> Add to Cart</button>
    </div>
  </div>

<script src="js/script.js"></script>
</body>
</html>