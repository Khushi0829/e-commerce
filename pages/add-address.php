<?php
session_start();
require_once "../config/db.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <!-- bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
    <?php 
 if (!isset($_SESSION['user_id'])): ?>

<section class="login-cart">
    <div class="container-fluid">
        <div class="row g-4 d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="login-card text-center">
                    <h5>Login Required</h5>
                    <p>Please log in to view your cart <br> and Wishlist.</p>
                    <a href="<?= BASE_URL ?>/auth/login.php?redirect=<?= BASE_URL ?>/pages/cart.php"
                        class="login-cart-btn">Login Now</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login-img relative-class">
                    <img src="<?= BASE_URL ?>/assets/images/ce93a1e6-bc57-4b9e-af58-483d97ee47b3.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        INSERT INTO user_addresses (user_id, address, city, pincode, phone)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issss", $user_id, $address, $city, $pincode, $phone);
    $stmt->execute();

    header("Location: checkout.php");
    exit;
}
?>


<form method="POST" class="container my-5">
    <h3>Add Address</h3>
      <textarea name="address" class="form-control mb-2" required></textarea>
      <input type="text" name="city" class="form-control mb-2" placeholder="City" required>
      <input type="text" name="pincode" class="form-control mb-2" placeholder="Pincode" required>
      <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" required>

      <button class="btn btn-dark">Save Address</button>

</form>




    <?php include "../includes/footer.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>


    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            // offset: 120          // triggers slightly before visible
        });
    </script>

    <!-- Custom JS -->

    <script src="../assets/js/script.js"></script>
</body>
</html>

