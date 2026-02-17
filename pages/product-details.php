<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

if(!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = (int) $_GET['id'];

$cartQty= 0;

if (isset($_SESSION['user_id'])){
    $q = $conn->prepare("SELECT quantity FROM cart WHERE user_id=? AND product_id=?");
    $q ->bind_param("ii", $_SESSION['user_id'], $product_id);
    $q->execute();
    $r =$q->get_result()->fetch_assoc();
    if ($r) $cartQty = $r['quantity'];
}


//Product details query

$stmt = $conn->prepare("
    SELECT p.*, c.name AS category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ?
    ");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: products.php");
    exit;
}

// Review Query

$reviewQuery = $conn->prepare("
    SELECT COUNT(*) AS total_reviews, AVG(rating) AS avg_rating 
    FROM product_reviews 
    WHERE product_id = ?
");
$reviewQuery->bind_param("i", $product_id);
$reviewQuery->execute();
$reviewData = $reviewQuery->get_result()->fetch_assoc();

$totalReviews = $reviewData['total_reviews'];
$avgRating = round($reviewData['avg_rating'], 1);



// Product Atrributes

$attrQuery = $conn->query("
    SELECT attr_name, attr_value 
    FROM product_attributes 
    WHERE product_id = $product_id
");


// Images

$images = $conn -> query(
        "SELECT image FROM product_images 
    WHERE product_id = $product_id
    ORDER BY is_primary DESC"
)
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($product['name']) ?></title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    
<?php

// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/../includes/header.php';
?>

 <div class="container mt-5">

    <div class="row g-5 align-items-start">

          <!-- left Gallery -->
          <div class="col-lg-7 d-flex gap-3">
              <!-- Thumbnails -->
               
              <div class="d-flex flex-column gap-2">

                <?php               
                mysqli_data_seek($images, 0);
                while ($img = mysqli_fetch_assoc($images)) :
                ?>
                
                <img id ="mainImage" src = "../<?= $img['image'] ?>" class="img-thumbnail thumb"
                onclick="changeImage(this.src)">

                   <?php endwhile; ?>
              </div>
                
              <!-- Main Image -->

            <?php
             mysqli_data_seek($images, 0);
             $main = $images->fetch_assoc();
            ?>

             <img id="mainImage" src="../<?= $main['image'] ?>" class="img-fluid rounded main-product">
          </div>

          <!-- Right- product Info -->
          <div class="col-lg-5">

            <small class="text-uppercase text-muted">
                <?= htmlspecialchars($product['category_name'] ?? ' ') ?>
            </small>

             <h2 class="fw-bold"><?= htmlspecialchars($product['name']) ?></h2>

             <!-- Rating -->
              <div class="mb-2">
                <?php if ($totalReviews >0): ?>

                    <?php 
                    $stars = round($avg_rating);
                    for ($i = 1; $i <= 5; $i++){
                        echo $i <= $stars ? "⭐" : "☆";
                    }
                        ?>
                        <small class="text-muted">
                            (<?= $totalReviews ?> reviews, <?= $avgRating ?>/5)
                        </small>

                        <?php else: ?>
                            
                            <small class="text-muted">No reviews yet</small>
                            <?php endif; ?>
              </div>

              <h4 class="fw-bold">
                ₹<?= $product['price'] ?>
                <del class="text-muted fs-6">₹<?= $product['price'] + 500 ?></del>
                <span class="badge bg-success">Discount Prize</span>
              </h4>
              
              <!-- Description -->
               <p class="text-muted mt-3">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
               </p>

                     <!-- Quantity (REUSING cart logic -->
               <div class="d-flex align-items-center gap-3 mb-4">
        

               <?php
               $isInCart = false;

                if (isset($_SESSION['user_id'])) {
                        $uid = $_SESSION['user_id'];
                        $pid = $product_id;
                        $checkCart = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
                        $checkCart->bind_param("ii", $uid, $pid);
                        $checkCart->execute();
                        $res = $checkCart->get_result();
                        if ($res->num_rows > 0) {
                                     $isInCart = true; 
                        }
               }
               ?>
             <?php if ($isInCart): ?>
                <!-- GO TO CART BUTTON -->
                 <a href="cart.php" class="search-btn checkout-btn text-decoration-none">
                    Go to Cart
                 </a>

                 <?php else: ?>
                    <!-- ADD TO CART BUTTON -->
                  <form action="add-to-cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <input type="hidden" name="qty" id="qtyInput" value="1">
                    <button class="search-btn " style="height:36px">
                      Add to Cart
                    </button>
                  </form>
                <?php endif; ?>

                <!-- Wishlist btn--- -->
                 <form action="wishlist-toggle.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <input type="hidden" name="qty" id="qtyInput" value="1">
                    <button type="button" class="btn btn-outline-danger" data-product-id="<?= $product_id ?>" >
                     <i class="fa fa-heart"></i>
                    </button>
                 </form>
                   
               </div>

                <!-- Features -->

                <?php if ($attrQuery->num_rows > 0): ?>
                    <div class="mt-3">
                        <h6 class="fw-bold">Product Details:</h6>
                        <ul class="list-unstyled">
                            <?php while ($attr = $attrQuery->fetch_assoc()): ?>
                                <li>
                                    <strong><?= htmlspecialchars($attr['attr_name']) ?>:</strong>
                                    <?= htmlspecialchars($attr['attr_value']) ?>
                                </li>
                                <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php endif; ?>



          </div>
          
    </div>

 </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
        
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
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener("click", () => {

            fetch('../pages/wishlist-toggle.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    product_id: btn.dataset.id,
                    action: btn.dataset.action
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;

                // update qty text
                document.getElementById("qty-" + btn.dataset.id).innerText =
                    "Qty: " + data.quantity;
            });
        });
    });
});
</script>


    <script src="../assets/js/script.js"></script>


</body>
</html>
