
<?php
require_once "../config/db.php";


$id = $_GET['id'];
$cat = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));

    $stmt = $conn->prepare("UPDATE categories SET name=?, slug=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $slug, $id);
    $stmt->execute();

    header("Location: categories.php");
}
?>


<form method="POST">
    <input type="text" name="name" value="<?= $cat['name'] ?>" required>
    <button name="update">Update</button>
</form>