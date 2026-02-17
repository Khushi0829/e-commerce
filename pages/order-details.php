<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/../includes/header.php';


 if (!isset($_SESSION['user_id'])){
     include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
    }


$order_id = (int) $_GET['id'];
$user_id = $_SESSION['user_id'];

// Security check
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "Order not found!";
    exit;
}

// Order items
$stmt = $conn->prepare("
    SELECT products.name, order_items.price, order_items.quantity 
    FROM order_items 
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

     <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    

<div class="container my-5">
    <h2>Order #<?= $order['id'] ?></h2>
    <p>Status: <strong><?= $order['order_status'] ?></strong></p>
    <p>Total: ₹<?= $order['total_amount'] ?></p>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td>₹<?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₹<?= $item['price'] * $item['quantity'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
</div>

<?php include "../includes/footer.php" ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>

    <script src="../assets/js/script.js"></script>

</body>
</html>
