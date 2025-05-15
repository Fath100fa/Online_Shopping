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
    <h1><i class="fas fa-laptop"></i> <!--php--></h1>
    <img src="<!--php-->" alt="<!--php-->" />
    <p><strong><i class="fas fa-tag"></i> Price:</strong> <!--php--></p>
    <p>
      <strong><i class="fas fa-microchip"></i> Specs:</strong> <!--php-->
    </p>

    <h2><i class="fas fa-star"></i> Rate this Laptop</h2>
    <div class="rating" id="rating">
      <span data-value="1">&#9733;</span>
      <span data-value="2">&#9733;</span>
      <span data-value="3">&#9733;</span>
      <span data-value="4">&#9733;</span>
      <span data-value="5">&#9733;</span>
    </div>
    
    </div>
  </div>

<script src="js/script.js"></script>
</body>
</html>