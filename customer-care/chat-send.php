


<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["reply" => "Please login to chat."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$message = strtolower(trim($data['message'] ?? ''));

$user_id = $_SESSION['user_id'] ?? 0;


// ✅ Default reply
$reply = "Sorry 🤖 I didn't understand. Please contact support.";

// ✅ Smart replies
if (strpos($message, "hi") !== false || strpos($message, "hello") !== false) {
    $reply = "👋 Hello! How can I help you today?";
}
elseif (strpos($message, "order") !== false) {
    $reply = "📦 You can track your order in 'My Orders' section.";
}
elseif (strpos($message, "return") !== false || strpos($message, "refund") !== false) {
    $reply = "🔄 Our return policy allows returns within 7 days.";
}
elseif (strpos($message, "payment") !== false) {
    $reply = "💳 Please check your payment method or try again.";
}
elseif (strpos($message, "contact") !== false || strpos($message, "support") !== false) {
    $reply = "📞 You can contact support via email or phone.";
}
elseif (strpos($message, "price") !== false) {
    $reply = "💰 Please check the product page for latest prices.";
}

// ✅ Save USER message
$stmt = $conn->prepare("INSERT INTO chat_messages (user_id, sender, message) VALUES (?, ?, ?)");
$sender = "user";
$stmt->bind_param("iss", $user_id, $sender, $message);
$stmt->execute();

// ✅ Save BOT reply
$stmt = $conn->prepare("INSERT INTO chat_messages (user_id, sender, message) VALUES (?, ?, ?)");
$sender = "bot";
$stmt->bind_param("iss", $user_id, $sender, $reply);
$stmt->execute();

echo json_encode(["reply" => $reply]);
