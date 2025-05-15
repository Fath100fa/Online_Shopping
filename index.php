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
        <h3><i class="fas fa-laptop"></i> CompuVerse</h3>

        <div class="nav-search">
            <input type="search" id="search" placeholder="Search for a product...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="Login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li><a href="register.php"><i class="fas fa-user-plus"></i> Sign up</a></li>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        </ul>
    </nav>

    <header>
        <h1>Welcome to CompuVerse</h1>
        <p><i class="fas fa-tags"></i> Your one-stop shop for all things tech!</p>
    </header>

    <section>

        <h2><i class="fas fa-star"></i> Featured Products</h2>
        <!--Product 1-->
        <div class="products">
            <div class="product" id="item1111">
                <a href="details.php">
                    <img src="img/Asus_Tuf.jpg" alt="Asus TUF Gaming A15">
                </a>
                <h3>Asus TUF Gaming A15</h3>
                <p><i class="fas fa-tags"></i> 30,000 EGP</p>

                <!--Nassar aded this-->
                <a href="AsusDetails.html">
                    <button class="details-button"><i class="fas fa-info-circle"></i> Details</button>
                </a>
                

                <button onclick="addToCart('item1111')"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>

            <!--Product 2-->
            <div class="product" id="item1112">
               
                <a href="LenovoLegion5ProDetails.html">
                    <img src="img/lenovo.webp" alt="Lenovo Legion 5 Pro">
                </a>
               

                <h3>Lenovo Legion 5 Pro</h3>
                <p><i class="fas fa-tags"></i> 55,000 EGP</p>

                 <!--Nassar aded this-->
                 <a href="LenovoLegion5ProDetails.html">
                    <button class="details-button"><i class="fas fa-info-circle"></i> Details</button>
                </a>
                
                <button onclick="addToCart('item1112')"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                <!--end of it-->


            </div>
        </div>
    </section>

    <footer>
        <p><i class="far fa-copyright"></i> 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
    
</body>
</html>
