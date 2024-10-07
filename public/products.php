<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and has admin privileges
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

// Include necessary files
require_once '../config/database.php';
require_once '../app/controllers/ProductCrud.php';

try {
    // Pass the role to ProductCrud
    $productCrud = new ProductCrud($pdo, $_SESSION['role']);
    // Fetch all products
    $products = $productCrud->getProducts();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/product.css"> <!-- Adjust the path if necessary -->
    <title>Products List</title>
</head>
<body>
<div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="./users.php">Manage Users</a></li>
            <li><a href="./products.php">Manage Products</a></li>
            <li><a href="./orders.php">Manage Orders</a></li>
            <li><a href="./landing.php">User's View</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="prod">
    <h1 style="text-align: center; color: #333;">All Products</h1> <!-- Centered title with color -->

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="add_product.php" class="btn">Add Product</a> <!-- Using a class for styling -->
    </div>

    <?php if (!empty($products)): ?>
        <table style="width: 100%; border-collapse: collapse; background-color: #fff;"> <!-- White background for the table -->
            <thead>
                <tr>
                    <th style="background-color: #e5d8af; color: #333;">Product Name</th>
                    <th style="background-color: #e5d8af; color: #333;">Description</th>
                    <th style="background-color: #e5d8af; color: #333;">Price</th>
                    <th style="background-color: #e5d8af; color: #333;">Image</th>
                    <th style="background-color: #e5d8af; color: #333;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td><?= htmlspecialchars($product['price']); ?></td>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>" style="width: 100px; height: auto;">
                            <?php else: ?>
                                No image available
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id']; ?>" class="action-btn edit-btn">Edit</a> | 
                            <a href="delete_product.php?id=<?= $product['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">No products found.</p>
    <?php endif; ?>
</div>
<div class="prod">
    <h1 style="text-align: center; color: #333;">All Products</h1> <!-- Centered title with color -->

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="add_product.php" class="btn">Add Product</a> <!-- Using a class for styling -->
    </div>

    <?php if (!empty($products)): ?>
        <table style="width: 100%; border-collapse: collapse; background-color: #fff;"> <!-- White background for the table -->
            <thead>
                <tr>
                    <th style="background-color: #e5d8af; color: #333;">Product Name</th>
                    <th style="background-color: #e5d8af; color: #333;">Description</th>
                    <th style="background-color: #e5d8af; color: #333;">Price</th>
                    <th style="background-color: #e5d8af; color: #333;">Image</th>
                    <th style="background-color: #e5d8af; color: #333;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td><?= htmlspecialchars($product['price']); ?></td>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>" style="width: 100px; height: auto;">
                            <?php else: ?>
                                No image available
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id']; ?>" class="action-btn edit-btn">Edit</a> | 
                            <a href="delete_product.php?id=<?= $product['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">No products found.</p>
    <?php endif; ?>
</div>


</body>
</html>
