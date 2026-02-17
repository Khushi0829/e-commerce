<?php
require "../config/db.php";

if (isset($_POST['reset'])) {
    $email = $_POST['email'];

    $newPass = rand(100000,999999);
    $hash = password_hash($newPass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $stmt->bind_param("ss", $hash, $email);
    $stmt->execute();

    echo "New password: " . $newPass;
}
?>
