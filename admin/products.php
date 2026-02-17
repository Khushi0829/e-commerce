<?php
require "../config/db.php";

$result = mysqli_query($conn, "SELECT * FROM products");
?>


<div class="products-grid">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">
            <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
            <h4><?= $row['name'] ?></h4>
            <p>₹<?= $row['price'] ?></p>
        </div>
    <?php } ?>
</div>
