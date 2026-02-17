
<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/e-commerce/config/config.php";
require_once ROOT_PATH . "/config/db.php";

// ✅ Admin header, not website header
require_once ADMIN_PATH . "/includes/header.php";

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Style CSS -->

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/master.css">
</head>
<body>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/e-commerce/config/config.php";
require_once ADMIN_PATH . "/includes/header.php";

$totalProducts = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM products"))[0];
$totalCategories = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM categories"))[0];
?>

<h2>Dashboard</h2>

<div class="row">
    <div class="col-md-3">
        <div class="card p-3 bg-primary text-white">
            Products: <?= $totalProducts ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-success text-white">
            Categories: <?= $totalCategories ?>
        </div>
    </div>
</div>


    <!-- Bootstrap JavaScript Libraries -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>


    <!-- script js -->
    <script src="assets/js/script.js"> </script>
</body>
</html>