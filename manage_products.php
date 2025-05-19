<?php
session_start();
include "conn.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// إضافة منتج جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $insert_sql = "INSERT INTO products (name, price, image_url) VALUES ('$name', $price, '$image_url')";
    if (!$conn->query($insert_sql)) {
        $error = "Error adding product: " . $conn->error;
    } else {
        header("Location: manage_products.php");
        exit;
    }
}

// حذف منتج
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM products WHERE id = $delete_id";
    if (!$conn->query($delete_sql)) {
        $error = "Error deleting product: " . $conn->error;
    } else {
        header("Location: manage_products.php");
        exit;
    }
}

$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Products</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    color: #333;
    padding: 20px;
}
nav {
    background-color: #2b832e;
    color: white;
    padding: 15px 25px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
nav h3 {
    margin: 0;
    font-size: 1.8em;
}
.container {
    max-width: 900px;
    margin: 0 auto;
    background: #f9f9f9;
    padding: 30px;
    border-radius: 12px;
    border: 3px solid #b2ec99;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
h1 {
    color: #58b35b;
    margin-bottom: 20px;
    text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
th {
    background-color: #58b35b;
    color: white;
}
.delete-btn {
    background-color: #e04e4e;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    text-decoration: none;
}
.delete-btn:hover {
    background-color: #b93a3a;
}
form.add-product {
    max-width: 400px;
    margin: 0 auto;
    background: #e8f5e9;
    padding: 20px;
    border-radius: 10px;
    border: 2px solid #58b35b;
}
form.add-product h2 {
    text-align: center;
    margin-bottom: 15px;
    color: #2b832e;
}
form.add-product label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}
form.add-product input[type="text"],
form.add-product input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
}
form.add-product button {
    width: 100%;
    background-color: #58b35b;
    color: white;
    padding: 12px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
form.add-product button:hover {
    background-color: #2b832e;
}
.error {
    color: red;
    text-align: center;
    margin-bottom: 15px;
}
</style>
</head>
<body>

<nav>
    <h3><i class="fas fa-user-shield"></i> Admin Dashboard</h3>
</nav>

<div class="container">

    <h1>Manage Products</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price (EGP)</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><img src="img/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:50px; height:auto;"></td>
                <td><a href="?delete_id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fas fa-trash"></i> Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form class="add-product" method="POST" action="">
        <h2>Add New Product</h2>
        <input type="hidden" name="action" value="add" />
        <label for="name">Product Name</label>
        <input required type="text" id="name" name="name" placeholder="Product Name" />
        <label for="price">Price (EGP)</label>
        <input required type="number" step="0.01" min="0" id="price" name="price" placeholder="Price" />
        <label for="image_url">Image Filename</label>
        <input required type="text" id="image_url" name="image_url" placeholder="example.jpg" />
        <button type="submit">Add Product</button>
    </form>

</div>

</body>
</html>
