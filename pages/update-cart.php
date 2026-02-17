
<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "login_required" => true]);
    exit;
}


$user_id = (int)$_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$product_id = (int) ($data['product_id'] ?? 0);
$action = $data['action'];

if ($product_id == 0) {
    echo json_encode(["success" => false]);
    exit;
}


// check if product exists in cart

$check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$res = $check->get_result();





if ($action === "increase"){
     $stmt = $conn -> prepare("UPDATE cart SET quantity = quantity +1  WHERE user_id = ? AND product_id = ?");
     $stmt->bind_param("ii", $user_id, $product_id);
     $stmt->execute();
}

if ($action === "decrease"){
     $stmt = $conn -> prepare("UPDATE cart SET quantity = quantity -1 WHERE user_id = ? AND product_id = ?");
     $stmt->bind_param("ii", $user_id, $product_id);
     $stmt->execute();

    //  Remove item if qty =0
     $stmt = $conn->prepare ("DELETE FROM cart WHERE user_id = ? AND product_id =? AND quantity <= 0");
     $stmt->bind_param("ii", $user_id, $product_id);
     $stmt->execute();
}

// get updated qty
$stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");

$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();


// calculate total
$totalRes = $conn->prepare("
    SELECT SUM(c.quantity * p.price) AS total
    FROM cart c
    JOIN products p ON p.id = c.product_id 
    WHERE c.user_id = ?
");

$totalRes->bind_param("i", $user_id);
$totalRes->execute();
$total = $totalRes->get_result()->fetch_assoc()['total'] ?? 0;  

// Response to JSON

$shipping = 50;
$grandTotal = $total + $shipping;

echo json_encode([
    "success"  => true,
    "quantity" => $row['quantity'] ?? 0,
    "removed"  => $row ? false : true,
    "subtotal"  => $total,
    "shipping"  => $shipping,
    "grandTotal"=> $grandTotal
]);