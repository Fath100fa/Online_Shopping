<?php
session_start();
include "conn.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// جلب بيانات الطلبات مع حساب السعر الكلي لكل طلب
$orders_sql = "
SELECT o.id, o.user_id, o.order_date, u.username, 
       SUM(oi.quantity * p.price) AS total_price
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
GROUP BY o.id, o.user_id, o.order_date, u.username
ORDER BY o.order_date DESC
LIMIT 50
";
$result = $conn->query($orders_sql);
$orders = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// بيانات للمبيعات آخر 7 أيام (اليوم والتاريخ والإجمالي)
$sales_sql = "
SELECT DATE(o.order_date) as sale_date, 
       SUM(oi.quantity * p.price) AS total_sales
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.order_date >= CURDATE() - INTERVAL 7 DAY
GROUP BY sale_date
ORDER BY sale_date ASC
";
$sales_result = $conn->query($sales_sql);
$sales_data = [];
if ($sales_result) {
    while ($row = $sales_result->fetch_assoc()) {
        $sales_data[$row['sale_date']] = floatval($row['total_sales']);
    }
}

// جهز البيانات لChart.js
$dates = [];
$sales = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dates[] = $date;
    $sales[] = isset($sales_data[$date]) ? $sales_data[$date] : 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sales Report</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
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
    max-width: 1000px;
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
    margin-bottom: 40px;
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
canvas {
    max-width: 700px;
    margin: 0 auto 40px auto;
    display: block;
}
</style>
</head>
<body>

<nav>
    <h3><i class="fas fa-chart-line"></i> Sales Report</h3>
</nav>

<div class="container">
    <h1>Orders History</h1>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Order Date</th>
                <th>Total Price (EGP)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($orders)): ?>
                <tr><td colspan="4">No orders found.</td></tr>
            <?php else: ?>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= number_format($order['total_price'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <h1>Sales in Last 7 Days</h1>
    <canvas id="salesChart"></canvas>
</div>

<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
            label: 'Total Sales (EGP)',
            data: <?= json_encode($sales) ?>,
            backgroundColor: 'rgba(88, 179, 91, 0.2)',
            borderColor: '#58b35b',
            borderWidth: 3,
            fill: true,
            tension: 0.3,
            pointRadius: 5,
            pointBackgroundColor: '#2b832e'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});
</script>

</body>
</html>
