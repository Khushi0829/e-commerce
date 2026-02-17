<?php
require_once __DIR__ . '/../config/config.php';
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Headers</title> -->
    
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- AOS CSS -->
    <!-- <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"> -->

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body> -->
    <header>
        <nav class="navbar navbar-expand-lg " id="navbar">
            <div class="container-fluid">

                <a class="navbar-brand" href="#">
                    <img src="<?= BASE_URL ?>/assets/images/logo/Untitled-design(6).png" alt="" class="img-fluid" />
                </a>

                <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- COLLAPSE -->
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <!-- SEARCH -->
                    <form class="d-flex navbar-search relative-class me-5 ">
                        <i class="search-icon fa-solid fa-magnifying-glass"></i>
                        <input class="form-control me-sm-2" type="text"
                            placeholder="Search for Products,  Brand and more" />
                        <button class="search-btn" type="submit" data-aos="fade-up" data-aos-delay="0">
                            Search
                        </button>
                    </form>

                    <ul class="navbar-nav align-items-lg-center">

                        <!-- LINKS -->

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= BASE_URL ?>/index.php" aria-current="page">Home <span
                                    class="visually-hidden">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Profile
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <div class="d-flex">
                                    <a class="dropdown-item" href="<?= BASE_URL ?>/auth/register.php"> New Customer?</a>
                                    <a href="<?= BASE_URL ?>/auth/register.php">Sign up</a>
                                </div>
                                <hr>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/user/profile.php"><i
                                        class="fa-solid fa-circle-user"></i> My Profile</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/pages/orders.php"><i
                                        class="fa-solid fa-bag-shopping"></i> Orders</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/pages/wishlist.php"><i
                                        class="fa-regular fa-heart"></i> Wishlist</a>
                                <a class="dropdown-item" href="#"><i class="fa-solid fa-gift"></i> Rewards</a>
                                <a class="dropdown-item" href="#"><i class="fa-solid fa-tags"></i> Gift Cards</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/pages/products.php" aria-current="page">Products
                                <span class="visually-hidden">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/pages/cart.php" aria-current="page"><i
                                    class="fa-solid fa-cart-shopping"></i><span
                                    class="visually-hidden">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/pages/wishlist.php" aria-current="page"><i
                                    class="fa fa-heart" aria-hidden="true"></i>
                                <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li>
                            <div class="dropdown ms-3 dropdown-dots">
                                <button class="btn border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical" style="font-size:20px;"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item"
                                            href="<?= BASE_URL ?>/pages/notification-settings.php">Notification
                                            Preferences</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/customer-care/contact.php">24x7
                                            Customer Care</a></li>
                                    <li><a class="dropdown-item" href="#">Advertise</a></li>
                                    <!-- <li><a class="dropdown-item" href="#">Download App</a></li> -->
                                </ul>
                            </div>
                        </li>

                    </ul>




                </div>
        </nav>
    </header>

    
        <!-- Bootstrap JS -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

        <!-- AOS JS -->
        <!-- <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script> -->

        <!-- Custom JS -->
        <!-- <script src="../assets/js/script.js"></script>
</body>

</html> -->