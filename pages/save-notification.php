<?php

session_start();
require_once __DIR__. '/../config/db.php';

$user_id = $_SESSION['user_id'];

$email = isset($_POST['email_notify']) ? 1 : 0;
$sms = isset($_POST['sms_notify']) ? 1 : 0;
$whatsapp = isset($_POST['whatsapp_notify']) ? 1 : 0;
$order = isset($_POST['order_updates']) ? 1 : 0;
$promo = isset($_POST['promotions']) ? 1 : 0;


// Check if record exists

$stmt = $conn->prepare("SELECT id FROM notification_preferences WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){
    // update

    $stmt= $conn->prepare(
        "UPDATE notification_preferences
        SET email_notify=?, sms_notify=?, whatsapp_notify=?, order_updates=?, promotions=? 
        WHERE user_id=?"
        );
         $stmt->bind_param("iiiiii", $email, $sms, $whatsapp, $order, $promo, $user_id);
         
} else{
    // Insert
    $stmt = $conn->prepare("INSERT INTO notification_preferences 
        (user_id, email_notify, sms_notify, whatsapp_notify, order_updates, promotions) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiii", $user_id, $email, $sms, $whatsapp, $order, $promo);
}

$stmt->execute();

header("Location: notification-settings.php?success=1");
exit;
