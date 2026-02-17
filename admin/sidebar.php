
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

        <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Style CSS -->

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/master.css">

</head>
<body>
    <div class="col-2 bg-dark text-white vh-100 p-3">
    <h4>Admin Panel</h4>
    <hr>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="/admin/index.php" class="nav-link text-white">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="/admin/categories/list.php" class="nav-link text-white">Categories</a>
        </li>
        <li class="nav-item">
            <a href="/admin/products/list.php" class="nav-link text-white">Products</a>
        </li>
        <li class="nav-item">
            <a href="/admin/users/list.php" class="nav-link text-white">Users</a>
        </li>
        <li class="nav-item">
            <a href="/admin/orders/list.php" class="nav-link text-white">Orders</a>
        </li>
        <li class="nav-item">
            <a href="/admin/logout.php" class="nav-link text-danger">Logout</a>
        </li>
    </ul>
</div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <!-- script js -->
    <script src="assets/js/script.js"> </script>
</body>
</html>