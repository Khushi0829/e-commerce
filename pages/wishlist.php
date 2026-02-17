<?php

session_start();
require_once __DIR__ . '/../config/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>


<body>

<?php
// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/../includes/header.php';
?>

<?php 
 if (!isset($_SESSION['user_id'])){
     include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
    }?>

 <?php
     
     $user_id = $_SESSION['user_id'];

     $stmt = $conn->prepare(
        " SELECT 
        p.id,
        p.name,
        p.price,
        pi.image
        FROM wishlist w
        JOIN products p ON p.id = w.product_id
        LEFT JOIN product_images pi 
        ON pi.product_id = p.id AND pi.is_primary = 1
    WHERE w.user_id = ?
    ");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
 ?>


    <div class="wishlist-container ">
        <h3 class="text-center fw-bold mb-4 mt-4">My Wishlist <i class="fa fa-heart text-danger" aria-hidden="true"></i></h3>

        <?php if($result->num_rows ===0) : ?>
        <p class="text-center text-muted">Your wishlist is empty.</p>

        <?php else : ?>

        <div class="wish-items" data-aos="fade-up">
            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="wish-card card shadow-sm border-0 rounded-4">

                    <img src="../<?=  $row['image'] ?>" class=" p-3 img-fluid">

                    <div class="card-body d-flex flex-column align-items-center justify-content-end">

                        <h5 class="fw-semibold text-dark mb-1">
                            <?= htmlspecialchars($row['name']) ?>
                        </h5>

                        <p class="fw-bold text-danger mb-3">₹
                            <?= $row['price'] ?>
                        </p>

                        <div class=" d-flex flex-wrap gap-2">

                            <!-- Move to cart -->
                            <form action="add-to-cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button class="move-cart-btn">Move to <i class="fa-solid fa-cart-shopping"></i></button>
                            </form>

                            <!-- Remove -->
                            <button class="remove-wishlist" data-id="<?= $row['id'] ?>">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>

            <?php endif; ?>
        </div>
    </div>

        <script>
            document.querySelectorAll('.remove-wishlist').forEach(btn => {
                btn.addEventListener('click', () => {
                    fetch('wishlist-toggle.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ product_id: btn.dataset.id })
                    })
                        .then(res => res.json())
                        .then(() => location.reload());
                });
            });
        </script>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- AOS JS -->
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

        <!-- Custom JS -->
        <script src="../assets/js/script.js"></script>
</body>

</html>
