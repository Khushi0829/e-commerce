

<?php

session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/../includes/header.php';


// wishlist code

$wishlistIds = [];

if (isset($_SESSION['user_id'])) {
    $w = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
    $w->bind_param("i", $_SESSION['user_id']);
    $w->execute();
    $res = $w->get_result();

    while ($r = $res->fetch_assoc()) {
        $wishlistIds[] =(int) $r['product_id'];
    }
}


// $products = mysqli_query($conn,
//     "SELECT * FROM products ORDER BY id DESC"
// );

// ✅ BUILD DYNAMIC FILTER + SORT QUERY
$sql = "SELECT * FROM products WHERE 1";

// FILTER: Category

if(!empty($_GET['category'])){
    $category =(int) $_GET['category'];
    $sql .= " AND category_id = $category";
}

// FILTER: Price

if(!empty($_GET['min_price'])){
    $min_price =(float) $_GET['min_price'];
    $sql .= " AND price >= $min_price";
}

if(!empty($_GET['max_price'])){
    $max_price = (float) $_GET['max_price'];
    $sql .= " AND price <= $max_price";
}


// SORT 
if (!empty ($_GET['sort'])){
    switch($_GET['sort']){
        case "price_asc":
            $sql .= " ORDER BY price ASC";
            break;
        case "price_desc":
            $sql .= " ORDER BY price DESC";
            break;
        case "name_asc":
            $sql .= " ORDER BY name ASC";
            break;
        case "latest":
            $sql .= " ORDER BY id DESC";
            break;

        default:
          $sql .= " ORDER BY id DESC";

    }
} else{
    $sql .= " ORDER BY id DESC";
}

// EXECUTE QUERY

$products = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

 <!-- FILTER & SORT BAR -->

 <div class="filter d-flex justify-content-center gap-2 mt-4">
    
    <!-- Sort -->
    <form method="GET" >
        <!-- keep filter values while sorting -->
         <input type="hidden" name="category" value="<?= $_GET['category'] ?? '' ?>">
         <input type="hidden" name="min_price" value="<?= $_GET['min_price'] ?? '' ?>">
         <input type="hidden" name="max_price" value="<?= $_GET['max_price'] ?? '' ?>">

         <div class="sort-box">
            <select name="sort"  class="form-select sort-select" onchange="this.form.submit()">
            <option value="">Sort</option>
            <option value="latest" <?= ($_GET['sort'] ?? '') == 'latest' ? 'selected' : '' ?>>Latest</option>
            <option value="price_asc" <?= ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Price: Low → High</option>
            <option value="price_desc" <?= ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Price: High → Low</option>
            <option value="name_asc" <?= ($_GET['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Name A → Z</option>
          </select>
         </div>

    </form>
     <!-- FILTER -->
    <button class="search-btn" data-bs-toggle="modal" data-bs-target="#filterModal">
        <span>Filter <i class="fa fa-sliders" aria-hidden="true" style="font-size:13px"></i></span>
    </button>
 </div>

    <div class="container-fluid product-slider">

        <?php 
        while ($row = mysqli_fetch_assoc($products)) { 
        ?>

        <div class="product-card " data-aos="fade-up">

         <div>
            <button type="button" class="wishlist-btn border-0" data-product-id="<?= $row['id'] ?> " data-bs-toggle="tooltip" data-bs-placement="top"  title="Add to Wishlist">
                        <?php if (in_array((int)$row['id'], $wishlistIds, true)): ?>
                            <i class="fa-solid fa-heart text-danger" style="font-size:20px;"></i>
                            <?php else: ?>
                                <i class="fa-regular fa-heart" style="font-size:20px;"></i>
                                <?php endif; ?>
            </button>
         </div>

            <?php
            $imgQuery = mysqli_query(
            $conn,
            "SELECT image FROM product_images WHERE product_id={$row['id']} LIMIT 1"
            );

            $img = mysqli_fetch_assoc($imgQuery);
        
            $imagePath = isset($img['image'])   
            ? "../" . $img['image']
            : "../assets/img/no-image.png";
            ?>

            <a href="product-details.php?id=<?= $row['id'] ?>">
                <img src="<?= $imagePath ?>" class="img-fluid" alt="<?= $row['name'] ?>">

                    <div class="">
                         <h4>
                            <?= $row['name'] ?>
                         </h4>
                         <p>₹
                            <?= $row['price'] ?>
                         </p>

                    </div>

                    <div class=" text-center">

                       <div>
                         <!-- <form method="POST" action="add-to-cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn border-0" > 
                                <i class="fa-solid fa-cart-shopping" style="font-size:20px;"></i>
                            </button>
                         </form> -->
                       </div>

                       
                    </div>


            </a>

           
        </div>

        <?php } ?>
    </div>

     <!-- FILTER MODAL -->
      
     <div class="modal" id="filterModal">
        <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                <form method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Products</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                         <!-- CATEGORY FILTER (Dynamic from DB) -->
                         <label class="mb-1">Category</label>
                         <select name="category" id="" class="form-select mb-3">
                            <option value="">All Categories</option>
                            <?php 
                            $catQuery = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
                            while ($cat = mysqli_fetch_assoc($catQuery)){
                                $selected = ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '';
                                echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                            }
                            ?>
                         </select>

                         <!-- PRICE FILTER -->
                          <label class="mb-1">Price Range</label>
                          <div class="d-flex gap-2"> 

                            <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?= $_GET['min_price'] ?? '' ?>">
                            <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?= $_GET['max_price'] ?? '' ?>">

                          </div>

                           <!-- Keep sort while filtering -->
                            <input type="hidden" name="sort" value="<?= $_GET['sort'] ?? '' ?>">
                    </div>

                    <div class="modal-footer">
                        <a href="products.php" class="btn btn-secondary">Reset</a>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                </form>
             </div>
        </div>
     </div>

    <?php include "../includes/footer.php" ?>

     <!-- Bootstrap JavaScript Libraries -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
     </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>

    <script src="../assets/js/script.js"></script>

</body>

</html>