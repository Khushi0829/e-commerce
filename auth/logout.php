<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

// ✅ load header (BASE_URL etc)
// require_once __DIR__ . '/../includes/header.php';


$_SESSION = [];

session_destroy();

if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
    );
}

header ("Location: " . BASE_URL . "/index.php");
exit;
