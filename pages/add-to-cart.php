<?php

session_start();
// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> -->

             <!-- Bootstrap CSS v5.2.1 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" /> -->

    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->

    <!-- AOS CSS -->
    <!-- <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css"> -->
<!-- </head>
<body>

     // ✅ load header (BASE_URL etc)
 require_once __DIR__ . '/../includes/header.php';



 if (!isset($_SESSION['user_id'])){
    include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
 } ?> -->


    <?php 
$user_id    = $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];

// ✅ Check if product already exists in cart
$check = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    // ✅ Insert only if not exists
    $stmt = $conn->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (?, ?, 1)
    ");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
} else {
    // Optional: increase quantity
    $update = $conn->prepare("
        UPDATE cart 
        SET quantity = quantity + 1
        WHERE user_id = ? AND product_id = ?
    ");
    $update->bind_param("ii", $user_id, $product_id);
    $update->execute();
}

// Remove from wishlist

$del = $conn->prepare(
    "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?"
);
$del->bind_param("ii", $user_id, $product_id);
$del->execute();


// Redirect BEFORE any output
header("Location: cart.php");
exit;
?>

</body>
</html>