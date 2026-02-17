<?php
session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

 // ✅ load header (BASE_URL etc)
 require_once __DIR__ . '/../includes/header.php';
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
 if (!isset($_SESSION['user_id'])){
     include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
    } ?>


    <?php 
    $user_id = $_SESSION['user_id'];
    
    // ✅ Fetch orders
    $orderStmt = $conn->prepare(" SELECT
    o.id AS order_id,
    o.total_amount,
    o.delivery_date,
    o.order_status,
    ua.address,
    ua.city,
    oi.quantity,
    oi.price,
    p.name,
    pi.image
    FROM orders o
    JOIN user_addresses ua ON o.address_id = ua.id
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE o.user_id = ? 
    ORDER BY o.created_at DESC
    ");
    $orderStmt->bind_param("i", $user_id);
    $orderStmt->execute();
    $orders = $orderStmt->get_result();
        ?>

    <!-- <div class="container-fluid cart-page mt-5 mb-5 h-100">
        <h2>You have no orders yet!!</h2>
    </div> -->

    <div class="container my-5">
        <h2>My Orders</h2>

        <?php if ($orders->num_rows > 0): ?>
        <?php while ($order = $orders->fetch_assoc()): ?>

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center g-2">
                    <!-- Product Image -->
                    <div class="col-lg-2 col-sm-2 col-4">
                        <img src="../<?= htmlspecialchars($order['image']) ?>" class="img-fluid rounded">
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-6 col-sm-6 col-8 ">
                        <div class="details ms-lg-3">
                            <h5 class="mb-1">
                                <?= htmlspecialchars($order['name']) ?>
                            </h5>

                            <p class="mb-1">
                                <strong>Price:</strong> ₹
                                <?= $order['price'] ?>
                            </p>

                            <p class="mb-1">
                                <strong>Expected Delivery:</strong>
                                <?= $order['delivery_date'] ?>
                            </p>

                            <p class="mb-1">
                                <strong>Shipping To:</strong>
                                <?= htmlspecialchars($order['address']) ?>,
                                <?= htmlspecialchars($order['city']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="col-lg-4 col-sm-4 text-sm-end text-lg-end mt-3 mt-lg-0">
                        <a href="view-order.php?id=<?= $order['order_id'] ?>" class="search-btn checkout-btn">
                            Order Details
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-muted">You have not placed any orders yet.</p>
        <?php endif; ?>
    </div>



    <?php include "../includes/footer.php" ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
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