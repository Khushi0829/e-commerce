<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
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
require_once __DIR__ . '/../includes/header.php';

$user_id = $_SESSION['user_id'];    

// Fetch cart items
$stmt = $conn->prepare("
    SELECT c.product_id, p.name, p.price, c.quantity, pi.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE c.user_id = ?
    GROUP BY p.id
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: cart.php");
    exit;
}


$total = 0;

// Fetch User Address

$addrStmt = $conn->prepare("SELECT * FROM user_addresses WHERE user_id = ?");
$addrStmt ->bind_param("i", $user_id);
$addrStmt->execute();
$addresses = $addrStmt->get_result();


// Order Processing

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $address_id = $_POST['address_id'];
    $total_amount = $_POST['total_amount'];
    $payment_method = "COD";

    // Generate Random Coupen 
    $coupen_code = "WELCOME10";

    
    // Fetch address to calculate delivery date
    $cityStmt = $conn->prepare("SELECT city FROM user_addresses WHERE id= ? ");
    $cityStmt ->bind_param("i", $address_id);
    $cityStmt ->execute();
    $cityResult= $cityStmt->get_result() ->fetch_assoc();
    
    // Dynamic delivery time logic

    if($cityResult['city'] == "Mumbai"){
        $delivery_date = date("Y-m-d", strtotime("+2 days"));
    } else {
        $delivery_date = date("Y-m-d", strtotime("+5 days"));
    }

    // Insert into orders table

    $orderStmt = $conn->prepare("
    INSERT INTO orders (user_id, address_id, total_amount, payment_method, delivery_date, coupon_code)
    VALUES(?, ?, ?,?, ?, ?)
    ");

    if (!$orderStmt) {
    die("Prepare failed: " . $conn->error);
    }

    $orderStmt ->bind_param("iidsss", $user_id, $address_id, $total_amount, $payment_method, $delivery_date, $coupon_code);
    $orderStmt-> execute();
    $order_id = $orderStmt->insert_id;

     // Get cart items
    $cartItems = $conn->prepare(" SELECT c.product_id, c.quantity, p.price  FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ? ");
    $cartItems->bind_param("i", $user_id);
    $cartItems->execute();
    $itemsResult = $cartItems->get_result();

    while ($item = $itemsResult->fetch_assoc()) {
        $itemStmt = $conn->prepare(" INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?) ");

        $itemStmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $itemStmt->execute();
    }

    // Clear cart
    $clearCart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clearCart->bind_param("i", $user_id);
    $clearCart->execute();

    $order_success = true;

}

?>


    <div class="container my-5">
        <h2>Checkout</h2>
        
        <div class="row g-4">
             <!-- LEFT COLUMN (Address + Products) -->
                <div class="col-lg-8 col-12">

                     <!-- Delivery Address -->
                      <div class="card mb-3 shadow-sm">
                        <div class="card-body ">
                            <h5 class="card-title">Deliver To</h5>

                            <?php if ($addresses-> num_rows >0) :?>
                              <?php while ($addr =$addresses->fetch_assoc()) :?>

                                 <div class="border rounded p-2 mb-2 pay">
                                    <label>
                                        <input type="radio" name="address_id" class="address-radio" value="<?= $addr['id'] ?>" required>
                                        <strong><?= htmlspecialchars($addr['address']) ?></strong><br>
                                        <small><?= $addr['city'] ?> - <?= $addr['pincode'] ?></small><br>
                                        <small>Phone: <?= $addr['phone'] ?></small>
                                    </label>
                                 </div>

                                 <?php endwhile; ?>                

                                 <?php else: ?>
                                     <p class="text-muted">No address saved.</p>
                                    <?php endif; ?>
                                                                      
                                    <a href="add-address.php" class="btn btn-sm btn-outline-success mt-2">
                                        + Add New Address
                                    </a>
                        </div>
                      </div>

                      <!-- Products List -->
                       <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3 ">Your Products</h5>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                 <?php $subtotal = $row['price'] * $row['quantity']; ?>
                                 <?php $total += $subtotal; ?>

                                  <div class="row align-items-center border-bottom py-3">

                                     <!-- Product Image -->
                                      <div class="col-lg-2 col-sm-3 col-6">
                                        <img src="../<?= htmlspecialchars($row['image']) ?>" class="img-fluid rounded"   style="object-fit:cover;">
                                      </div>

                                        <!-- Product Info -->

                                        <div class="col-lg-7 col-sm-6 col-6">
                                            <h6 class="mb-1"><?= htmlspecialchars($row['name']) ?></h6>
                                            <small class="text-muted">Qty: <?= $row['quantity'] ?></small><br>
                                            <small class="text-muted">Price: ₹<?= $row['price'] ?></small>
                                        </div>

                                        <!-- Product Total -->
                                         <div class="col-lg-3 col-sm-3 col-12 text-end">
                                            <strong>₹<?= $subtotal ?></strong>

                                            <form action="add-to-cart.php" method="POST" class="mt-4 mb-0">
                                                <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                                <button type="submit" class="move-cart-btn">
                                                    Move to <i class="fa-solid fa-cart-shopping"></i>
                                                </button>
                                            </form>

                                         </div>

                                  </div>

                                   <?php endwhile; ?>
                        </div>
                       </div>
                </div>

                <!-- RIGHT COLUMN (ORDER SUMMARY) -->

                <div class="col-lg-4 col-12">
                    <div class="summary ">
                        <div  data-aos="fade-up" data-aos-delay="200">
                            <h3 class="card-title mb-3 ">Order Summary</h3>
                            
                            <div class="d-flex justify-content-between mb-2 summary-row">
                                 <span>Subtotal</span>
                                 <span>₹<?= $total ?></span>
                            </div>

                            <div class="d-flex justify-content-between mb-2 summary-row">
                                 <span>Shipping</span>
                                 <span>₹50</span>
                            </div>

                            <hr>

                             <div class="d-flex justify-content-between fw-bold fs-5 summary-row">
                                <span>Total</span>
                                <span>₹<?= $total + 50 ?></span>
                             </div>

                             <form method="POST" id="orderForm" class="mt-3">
                                <input type="hidden" name="address_id" id="address_id">

                                <input type="hidden" name="total_amount" value="<?= $total + 50 ?>">

                                <button class="search-btn checkout-btn">
                                    Place Order
                                </button>
                             </form>

                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!-- Success Modal -->

    <div class="modal fade" id = "SuccessModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🎉 Order Placed Successfully!</h5>
                </div>

                <div class="modal-body">
                    <p><strong>Delivery Date:</strong> <?= $delivery_date ?? '' ?></p>
                    <p><strong>Total Amount:</strong> ₹<?= $total_amount ?? '' ?></p>
                    <p><strong>Payment Method:</strong> Cash on Delivery</p>
                    <p><strong>Gift Coupon:</strong> <?= $coupon_code ?? '' ?></p>
                </div>

                 <div class="modal-footer">
                    <a href="orders.php" class="btn btn-success">View Orders</a>
                 </div>
            </div>
        </div>
    </div>


    <?php include "../includes/footer.php" ?>

    <?php if (!empty($order_success)) : ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var myModal = new bootstrap.Modal(document.getElementById('SuccessModal'));
    myModal.show();
});
</script>
<?php endif; ?>


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

<script>
document.getElementById("orderForm").addEventListener("submit", function(e) {
    const selectedAddress = document.querySelector('input[name="address_id"]:checked');

    if (!selectedAddress) {
        e.preventDefault();
        alert("⚠️ Please select a delivery address before placing order.");
        return;
    }

    // Put selected address into hidden input
    document.getElementById("address_id").value = selectedAddress.value;
});
</script>

    <script src="../assets/js/script.js"></script>

</body>
</html>