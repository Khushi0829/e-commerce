<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

// // ✅ load header (BASE_URL etc)
// require_once __DIR__ . '/../includes/header.php';

// header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(["login_required" => true]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
// $product_id = (int) $data['product_id'];

if (!$data) {
    $product_id = (int) ($_POST['product_id'] ?? 0);
} else {
    $product_id = (int) ($data['product_id'] ?? 0);
}


if ($product_id === 0) {
    echo json_encode(["error" => "Invalid product id"]);
    exit;
}


// check if already in wishlist

$check = $conn->prepare(
    "SELECT id FROM wishlist WHERE user_id = ? AND product_id =?"
);
$check -> bind_param("ii", $user_id, $product_id);
$check -> execute();
$res = $check -> get_result();

if($res -> num_rows > 0){
    // Remove from wishlist

    $del = $conn-> prepare( "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $del ->bind_param("ii", $user_id, $product_id);
    $del -> execute();

    echo json_encode (["added" => false]);
} else{
    // Add to Wishlist

    $ins = $conn -> prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
    $ins -> bind_param("ii", $user_id , $product_id);
    $ins-> execute();

    echo json_encode (["added" => true ]);
}

