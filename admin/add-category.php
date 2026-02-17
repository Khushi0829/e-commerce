<?php
require_once "../config/db.php";

if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);

    // slug generate
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));

    $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $slug);
    $stmt->execute();

    header("Location: categories.php");
    exit;
}
?>

<h2>Add Category</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Category Name" required>
    <button type="submit" name="submit">Add Category</button>
</form>
