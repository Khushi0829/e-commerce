
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
        <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/master.css">
</head>

<body>

<?php
 include "../config/db.php";


 if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $category = $_POST['category'];

      $productQuery = mysqli_query($conn,
        "INSERT INTO products (category_id, name, price, description)
         VALUES ('$category', '$name', '$price', '$desc')"
    );

    // Check for query error
      if (!$productQuery) {
        die("Product insert failed: " . mysqli_error($conn));
    }

    $product_id = mysqli_insert_id($conn);

        if ($product_id <= 0) {
        die("Product ID not generated");
    }


     // 2️⃣ Create product folder
        $uploadDir = "../assets/uploads/products/" . $product_id . "/";
        $dbDir     = "assets/uploads/products/" . $product_id . "/";
    
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }



    $isPrimary = 1;

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp) {

      if (empty($tmp)) continue;

        $imgName = time() . "_" . basename($_FILES['images']['name'][$key]);
        // $dbPath = "assets/uploads/products/" . $imgName;
        //  $serverPath = "../" . $dbPath;
         $serverPath = $uploadDir . $imgName;   // for move_uploaded_file
         $dbPath     = $dbDir . $imgName;       // path stored in DB

              

        if (move_uploaded_file($tmp,$serverPath)){

            $imgQuery = mysqli_query($conn,
            "INSERT INTO product_images (product_id, image, is_primary)
            VALUES ('$product_id', '$dbPath', '$isPrimary')"                  
            );

        if (!$imgQuery) {
                die("Image insert failed: " . mysqli_error($conn));
            }

             $isPrimary = 0;
        };
    }


    echo "Product added successfully";
 }
?>

<div class="add-product-form">
    <h2>Products</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required><br><br>
        <input type="number" name="price" placeholder="Price" required><br><br>
        
        <textarea name="description" placeholder="Description"></textarea><br><br>
        
        <select name="category">
            <option value="">Select Category</option>

            <?php 
             $catQuery =mysqli_query($conn, "SELECT id, name FROM categories");

             while ($cat = mysqli_fetch_assoc($catQuery)){
                echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
             }
            ?>
        </select><br><br>
     
        <input type="file" name="images[]"  required multiple>

        <button class="product-btn" type="submit" name="submit">Add Product</button>
    </form>
</div>

</body>
</html>












<!-- <form action="save-product.php" method = "POST" enctype= 
"multipart/form-data"> <br>

<input type="text" name="name" placeholder="Product Name" required> <br>

<input type="number" name="price" placeholder="Price" required> <br>

<input type="file" name="images[]" multiple accept="image/*" required>  <br>

<button type="submit"> Add Product</button>
</form> -->