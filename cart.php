<?php
session_start();
include "conn.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav>
        <h3><i class="fas fa-laptop-code"></i> CompuVerse</h3>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="Login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li><a href="Register.php"><i class="fas fa-user-plus"></i> Register</a></li>
        </ul>
    </nav>

    <h1><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>
    
    <div class="product">
        <h3><!--will be fetched from php--></h3>
        <p><!--will be fetched from php--></p>
    </div>
    <div class="product">
    <h2><i class="fas fa-money-bill-wave"></i> Total: $<span id="total-price">0.00</span><!--will be fetched from php--></h2>
    <button id="checkout-button"><i class="fas fa-credit-card"></i> Checkout</button>

</body>
</html>