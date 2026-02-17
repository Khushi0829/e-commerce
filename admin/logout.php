<?php
session_start();
session_destroy();
header("Location: " . ADMIN_URL . "/login.php");
exit;
