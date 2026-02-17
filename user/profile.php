<?php
session_start();


// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/../includes/header.php';
?>
 

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


       <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>


<?php 
 if (!isset($_SESSION['user_id'])): ?>

 <section class="login-cart">
    <div class="container-fluid">
        <div class="row g-4 d-flex justify-content-center align-items-center" >
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="login-card text-center" >
                    <h5>Login Required</h5>
                    <p>Please log in to view your Profile, cart <br> and Wishlist.</p>
                    <a href="../auth/login.php?redirect=../pages/cart.php" class="login-cart-btn">Login Now</a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="login-img relative-class">
                    <img src="<?= BASE_URL ?>/assets/images/ce93a1e6-bc57-4b9e-af58-483d97ee47b3.png" alt="">
                </div>
            </div>
        </div>
    </div>
 </section>

  

<?php else :?>

<?php
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT first_name, last_name, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
?>

  <section>
    
   <div class="container profile-page mt-5">
    <h2 class="profile-title" data-aos="fade-down">Welcome, <?= htmlspecialchars($user['first_name']) ?> 👋</h2>

     <div class="profile-card"  data-aos="zoom-in">
         <div class="profile-avatar">
             <i class="fa-solid fa-user"></i>
         </div>

        <div class="profile-info">
            <h4><?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?></h4>
            <p><?= htmlspecialchars($user['email']) ?></p>
            <span>Member since <?= date("F Y", strtotime($user['created_at'])) ?></span>
        </div>

        <div class="profile-actions">
            <a href="edit-profile.php" class="btn btn-outline-primary">
                <i class="fa-solid fa-pen"></i> Edit
            </a> 

             <a href="<?=BASE_URL?>/pages/add-address.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-location-dot"></i> Address
            </a>

            <a href="<?= BASE_URL ?>/auth/logout.php"
            onclick="return confirm('Are you sure you want to log out?')"
            class="btn btn-outline-danger">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
     </div>


    

     <div class="row g-4 justify-content-center align-items-lg-center mt-4">

        <div class="col-lg-3 col-sm-6 col-6" data-aos="fade-up">
              <!-- All Order Here  -->
              <div class="info-box">
                <a href="<?= BASE_URL?>/pages/orders.php">
                    <i class="fa-solid fa-box"></i>
                <h5>My Orders</h5>
                <p>Track & manage your orders</p></a>
              </div>
             <!-- No orders therefore Start shopping Now -->
        </div>
        
        <div class="col-lg-3 col-sm-6 col-6"data-aos="fade-up" data-aos-delay="200">
            <!-- Help Center Info -->

            <div class="info-box">
                <a href="<?= BASE_URL ?>/customer-care/contact.php">
                    <i class="fa-solid fa-headset"></i>
                    <h5>Help Center</h5>
                    <p>Need help? We’re here</p>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="100">
              <!-- All Wishlist Items -->

             <div class="info-box">
                <a href="<?= BASE_URL?>/pages/wishlist.php">
                    <i class="fa-solid fa-heart"></i>
                    <h5>Wishlist</h5>
                    <p>Your saved products</p>
                </a>
            </div>
        </div>


         <div class="col-lg-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="300">
            <div class="info-box">
                <i class="fa-solid fa-shield-halved"></i>
                <h5>Security</h5>
                <p>Password & privacy</p>
            </div>
        </div>
    </div>
    
   </div>
  </section>

    <?php include "../includes/footer.php" ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

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

<?php endif; ?>