<?php

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "ecommerce_db";

// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn -> connect_error){
//     die ("database connection failed: " .$conn -> connect_error);
// }

require_once __DIR__ . '/config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}
?>