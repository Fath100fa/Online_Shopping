<?php
session_start();
include "conn.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Product ID is required");
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM products WHERE id = $id");
if (!$result || $result->num_rows == 0) {
    die("Product not found");
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);

    $update_sql = "UPDATE products SET name='$name', price=$price WHERE id=$id";
    if ($conn->query($update_sql)) {
        header("Location: edit_product.php");
        exit;
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Edit Product</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet" />
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

    label {
        display: block;
        margin: 15px 0 5px 0;
        font-weight: bold;
        text-align: left;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 2px solid #d3f0b7;
        border-radius: 6px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus {
        border-color: #58b35b;
        outline: none;
    }

    button {
        margin-top: 25px;
        background-color: #58b35b;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: white;
        color: #58b35b;
        border: 2px solid #58b35b;
        transform: translateY(-2px);
    }

    a.back-link {
        display: inline-block;
        margin-top: 20px;
        color: #58b35b;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    a.back-link:hover {
        color: #2b832e;
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
    <h1>Edit Product #<?= htmlspecialchars($product['id']) ?></h1>

    <form method="POST">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required />

        <label for="price">Price (EGP):</label>
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required />

        <button type="submit"><i class="fas fa-save"></i> Save</button>
    </form>

    <a href="edit_product.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Products</a>
</section>

</body>
</html>
