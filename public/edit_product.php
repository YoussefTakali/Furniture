<?php
session_start();
require_once '../config/database.php';
require_once '../app/controllers/ProductCrud.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

$productCrud = new ProductCrud($pdo, $_SESSION['role']);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $products = $productCrud->getProducts();
    $product = array_filter($products, fn($p) => $p['id'] == $id);
    $product = reset($product); // Get the product details

    if (!$product) {
        die("Invalid product ID");
    }

    // Handle form submission for editing the product
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        if ($productCrud->editProduct($id, $name, $description, $price)) {
            header("Location: products.php?message=Product+updated+successfully");
            exit();
        } else {
            echo "Failed to update product.";
        }
    }
} else {
    die("Invalid product ID");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/editproduct.css"> <!-- Adjust the path if necessary -->

    <title>Edit Product</title>
</head>
<body>
<div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="./users.php">Manage Users</a></li>
            <li><a href="./products.php">Manage Products</a></li>
            <li><a href="./orders.php">Manage Orders</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="editproduct">
    <h1>Edit Product</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($product['description']); ?></textarea><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" required step="0.01"><br>

        <input type="submit" value="Update Product">
    </form>
</div>

</body>
</html>
