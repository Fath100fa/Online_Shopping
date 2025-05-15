<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav>
        <h3>CompuVerse</h3>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="Login.php">Login</a></li>
            <li><a href="Register.php">Register</a></li>
        </ul>
    </nav>

    <h1>Shopping Cart</h1>
    
    <div class="product">
        <h3><!--will be fetched from php--></h3>
        <p><!--will be fetched from php--></p>
    </div>
    <div class="product">
    <h2>Total: $<span id="total-price">0.00</span><!--will be fetched from php--></h2>
    <button id="checkout-button">Checkout</button>

</body>
</html>