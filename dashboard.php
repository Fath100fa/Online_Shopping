<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        nav {
            background-color: #2b832e;
            color: white;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav h3 {
            margin: 0;
            font-size: 1.8em;
        }

        section {
            margin: 50px auto;
            max-width: 600px;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 12px;
            border: 3px solid #b2ec99;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        h1 {
            color: #58b35b;
            margin-bottom: 15px;
        }

        h3 {
            color: #666;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            background-color: #58b35b;
            color: white;
            padding: 10px 20px;
            border: 2px solid #d3f0b7;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            margin: 10px 10px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: white;
            color: #58b35b;
            border-color: #58b35b;
            transform: translateY(-2px);
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
            margin-top: 50px;
        }

        footer i {
            margin: 0 8px;
            transition: transform 0.3s;
        }

        footer i:hover {
            transform: scale(1.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<nav>
    <h3><i class="fas fa-user-shield"></i> Admin Dashboard</h3>
</nav>

<section>
    <h1>Welcome, Admin</h1>
    <a href="edit_product.php" class="btn"><i class="fas fa-edit"></i> Edit</a>
    <a href="manage_products.php" class="btn"><i class="fas fa-trash"></i> manage products </a>
    <a href="history.php" class="btn"><i class="fas fa-chart-bar"></i> View Reports</a>
    <a href="manage_reviews.php" class="btn"><i class="fas fa-chart-bar"></i> manage_reviews</a>

    <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
</section>


</body>
</html>