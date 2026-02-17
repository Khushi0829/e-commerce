<?php
require_once ROOT_PATH . "/config/db.php";
require_once ADMIN_PATH . "/auth.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->
<div class="col-2 bg-dark text-white min-vh-100 p-3">
    <h4>Admin Panel</h4>
    <hr>
    <a href="<?= ADMIN_URL ?>/index.php" class="text-white d-block mb-2">Dashboard</a>
    <a href="<?= ADMIN_URL ?>/categories/index.php" class="text-white d-block mb-2">Categories</a>
    <a href="<?= ADMIN_URL ?>/products/index.php" class="text-white d-block mb-2">Products</a>
    <a href="<?= ADMIN_URL ?>/logout.php" class="text-danger d-block mt-3">Logout</a>
</div>

<!-- Main Content -->
<div class="col-10 p-4">
