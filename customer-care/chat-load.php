<?php


session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');


if (!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'] ?? 0;

$stmt = $conn->prepare("SELECT sender, message FROM chat_messages WHERE user_id=? ORDER BY id ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);