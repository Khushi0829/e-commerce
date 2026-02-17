<?php if (!isset($_SESSION['user_id'])): ?>

<section id="loginSection" class="login-cart">
    <div class="container-fluid">
        <div class="row g-4 d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="login-card text-center">
                    <h5>Login Required</h5>
                    <p>Please log in to view your cart <br> and Wishlist.</p>
                    <a href="<?= BASE_URL ?>/auth/login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                        class="login-cart-btn">Login Now</a>
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

<?php endif; ?>
