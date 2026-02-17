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
    <title>User cart</title>

    <!-- bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    
</head>

 <?php 
  if (!isset($_SESSION['user_id'])){
     include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
    }
 ?>



<?php
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT 
        cart.id AS cart_id,
        cart.product_id,
        products.name,
        products.price,
        product_images.image,
        cart.quantity
    FROM cart
    JOIN products ON cart.product_id = products.id
    LEFT JOIN product_images 
    ON products.id = product_images.product_id 
    AND product_images.is_primary = 1
    WHERE cart.user_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>



<body style="background: #fff4f4">



    <div class="container-fluid cart-page">
        <h2>My Cart</h2>

        <?php $total = 0; ?>
        <?php if ($result->num_rows === 0): ?>
            <!-- EMPTY CART UI -->
             <div class="empty-cart" >
                <h2 >Your cart is empty 🛒</h2>
                <center>
                    <button class="search-btn py-1" >
                        <a href="products.php" class="shop-btn">Shop Now</a>
                    </button>
                </center>
            </div>

        <?php else: ?>
            <div class="row g-4">
                <div class="col-lg-8 col-12">
                    <div class="cart-wrapper" data-aos="fade-up" data-aos-delay="100">
                    
                     <?php while ($row = $result->fetch_assoc()): ?>
                     <?php $subtotal = $row['price'] * $row['quantity']; ?>
                     <?php $total += $subtotal; ?>

                     <div class="cart-item" id="cart-item-<?= $row['product_id'] ?>">
                        <img src="../<?= htmlspecialchars($row['image']) ?>" width="120">
                        <div class="cart-info">
                            <h4>
                                <?= htmlspecialchars($row['name']) ?>
                            </h4>
                            <p>Price: ₹
                                <?= $row['price'] ?>
                            </p>

                            <div class="qty">
                                <button class="qty-btn" data-id="<?= $row['product_id'] ?>"
                                    data-action="decrease">-</button>

                                <span id="qty-<?= $row['product_id'] ?>">
                                    Qty:
                                    <?= $row['quantity'] ?>
                                </span>

                                <button class="qty-btn" data-id="<?= $row['product_id'] ?>"
                                    data-action="increase">+</button>
                            </div>
                        </div>
                     </div>

                     <?php endwhile; ?>

                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="summary" data-aos="fade-up" data-aos-delay="200">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">₹
                                <?= $total ?>
                            </span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span id="cart-shipping">₹50</span>
                        </div>
                        
                        <hr>
                        
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="cart-total"> ₹
                                <?= $total + 50 ?>
                            </span>
                        </div>
                        
                        <button class="checkout-btn search-btn">
                            <a href="checkout.php">Proceed to Checkout</a>
                        </button>
                    </div>
                </div>
                
            </div>

    </div>

    <?php include "../includes/footer.php"; ?>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: false,         // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>

    <!-- Custom JS -->

    <script src="../assets/js/script.js"></script>

</body>

</html>

<?php endif; ?>