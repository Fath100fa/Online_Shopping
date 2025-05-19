<?php
session_start();
include "conn.php";
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM products");
if (!$result) {
    die("Query Error: " . $conn->error);
}
$products = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Products</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        table {
            width: 90%;
            margin: 50px auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 15px;
        }
        th {
            background-color: #2b832e;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a.edit-btn {
            padding: 6px 12px;
            background-color: #58b35b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.edit-btn:hover {
            background-color: #3a8e3e;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit Products</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
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
            <td><img src="img/<?= htmlspecialchars($product['image_url']) ?>" width="60"></td>
            <td><a href="edit_single_product.php?id=<?= urlencode($product['id']) ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
