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
            <li><a href="index.html">Home</a></li>
            <li><a href="Login.html">Login</a></li>
            <li><a href="register.html">Sign up</a></li>
        </ul>
    </nav>

    <header>
        <h1>Welcome to CompuVerse</h1>
        <p>Your one-stop shop for all things tech!</p>
    </header>

    <section>

        <h2>Featured Products</h2>
        <!--Product 1-->
        <div class="products">
            <div class="product" id="item1111">
                <a href="AsusDetails.html">
                    <img src="img/Asus_Tuf.jpg" alt="Asus TUF Gaming A15">
                </a>
                <h3>Asus TUF Gaming A15</h3>
                <p>30,000 EGP</p>

                <!--Nassar aded this-->
                <a href="AsusDetails.html">
                    <button class="details-button">Details</button>
                </a>
                

                <button onclick="addToCart('item1111')">Add to Cart</button>
            </div>

            <!--Product 2-->
            <div class="product" id="item1112">
               
                <a href="LenovoLegion5ProDetails.html">
                    <img src="img/lenovo.webp" alt="Lenovo Legion 5 Pro">
                </a>
               

                <h3>Lenovo Legion 5 Pro</h3>
                <p>55,000 EGP</p>

                 <!--Nassar aded this-->
                 <a href="LenovoLegion5ProDetails.html">
                    <button class="details-button">Details</button>
                </a>
                
                <button onclick="addToCart('item1112')">Add to Cart</button>
                <!--end of it-->


            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 CompuVerse. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
    
</body>
</html>
