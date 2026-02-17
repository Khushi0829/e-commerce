<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];
$address_id = $_POST['address_id'];
$payment_method = $_POST['payment_method'];
$total_amount = $_POST['total_amount'];

if ($payment_method == "COD"){
    $stmt =$conn->prepare("INSERT INTO orders (user_id, address_id, total_amount, payment_method, payment_status, order_status)
    VALUES (?, ?, ?, ?,'pending', 'placed')");
    $stmt->bind_param("iids", $user_id, $address_id, $total_amount, $payment_method);
    $stmt->execute();

    $order_id =$conn->insert_id;

    header("Location: order-success.php?order_id=".$order_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

</body>
</html>