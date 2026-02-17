<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; 
$order_id = $_GET['id'] ?? 0;

/* ==============================
   1️⃣ Fetch Order Info (SECURE)
============================== */

$orderStmt = $conn->prepare("
SELECT o.*, ua.address, ua.city, ua.pincode, ua.phone
FROM orders o
JOIN user_addresses ua ON o.address_id = ua.id
WHERE o.id = ? AND o.user_id = ?
");

if (!$orderStmt) {
    die("Order Query Error: " . $conn->error);
}

$orderStmt->bind_param("ii", $order_id, $user_id);
$orderStmt->execute();
$order = $orderStmt->get_result()->fetch_assoc();

if (!$order) {
    die("Invalid Order.");
}

/* ==============================
   2️⃣ Cancel Order Logic
============================== */

if (isset($_POST['cancel_order'])) {

    if ($order['order_status'] == 'initiated' || $order['order_status'] == 'placed') {

        $cancelStmt = $conn->prepare("
            UPDATE orders 
            SET order_status = 'cancelled'
            WHERE id = ? AND user_id = ?
        ");
        $cancelStmt->bind_param("ii", $order_id, $user_id);
        $cancelStmt->execute();

        header("Location: view-order.php?id=" . $order_id);
        exit;
    }
}

/* ==============================
   3️⃣ Fetch Order Items
============================== */

$itemStmt = $conn->prepare(" SELECT 
    oi.quantity,
    oi.price,
    p.id AS product_id,
    p.name,
    p.description,
    pi.image
FROM order_items oi
JOIN products p ON oi.product_id = p.id
LEFT JOIN product_images pi ON p.id = pi.product_id
WHERE oi.order_id = ?
GROUP BY p.id
");

$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$items = $itemStmt->get_result();

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

<?php
// ✅ load header (BASE_URL etc)
 require_once __DIR__ . '/../includes/header.php'; ?>
    
<div class="container my-5">

    <!-- Order Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h4>Order - <?= $order['id'] ?></h4>
                <p class="mb-1 text-muted">
                    Placed on: <?= date("d M Y", strtotime($order['created_at'])) ?>
                </p>
                <p class="mb-0">
                    Payment: <?= strtoupper($order['payment_method']) ?>
                </p>
            </div>

            <div>
                <span class="badge 
                    <?php
                        if ($order['order_status'] == 'cancelled') echo 'bg-danger';
                        elseif ($order['order_status'] == 'delivered') echo 'bg-success';
                        else echo 'bg-warning';
                    ?>">
                    <?= ucfirst($order['order_status']) ?>
                </span>
            </div>

        </div>
    </div>

    <!-- Shipping Address -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Shipping Address</h5>
            <p class="mb-1"><?= htmlspecialchars($order['address']) ?></p>
            <p class="mb-1"><?= htmlspecialchars($order['city']) ?> - <?= $order['pincode'] ?></p>
            <p class="mb-0">Phone: <?= $order['phone'] ?></p>
        </div>
    </div>

    <!-- Products Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-4">Ordered Products</h5>

            <?php 
            $grandTotal = 0;
            while ($item = $items->fetch_assoc()):
                $subtotal = $item['price'] * $item['quantity'];
                $grandTotal += $subtotal;
            ?>

            <a href="product-details.php?id=<?= $item['product_id'] ?>" class="text-decoration-none text-dark">

                <div class="row align-items-center border-bottom pb-3 mb-3">

                    <div class="col-md-2 col-4">
                        <img src="../<?= htmlspecialchars($item['image']) ?>" 
                             class="img-fluid rounded">
                    </div>

                    <div class="col-md-6 col-8">
                        <h6><?= htmlspecialchars($item['name']) ?></h6>
                        <small class="text-muted">
                            Qty: <?= $item['quantity'] ?>
                        </small>
                        <br>
                        <small class="text-muted">
                            ₹<?= $item['price'] ?> each
                        </small>
                    </div>

                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <strong>₹<?= $subtotal ?></strong>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>
    </div>

    <!-- Order Summary -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span>₹<?= $grandTotal ?></span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Shipping</span>
                <span>₹50</span>
            </div>

            <hr>

            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Total</span>
                <span>₹<?= $grandTotal + 50 ?></span>
            </div>

        </div>
    </div>

    <!-- Cancel Button -->
    <?php if ($order['order_status'] == 'initiated' || $order['order_status'] == 'placed'): ?>
        <form method="POST">
            <button type="submit" 
                    name="cancel_order" 
                    class="btn btn-danger">
                Cancel Order
            </button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>