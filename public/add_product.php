<?php
session_start();

require_once '../config/database.php';
require_once '../app/controllers/ProductCrud.php';



// Ensure the user is logged in and has admin privileges
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

$productCrud = new ProductCrud($pdo, $_SESSION['role']);

// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    $targetDir = "../uploads/"; // Directory to save uploaded images
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . uniqid() . '.' . $imageFileType; // Create a unique filename

    // Check if the file is an image
    if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
        die("File is not an image.");
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Call the addProduct method with the image path
        if ($productCrud->addProduct($name, $description, $price, $targetFile)) {
            header("Location: products.php?message=Product+added+successfully");
            exit();
        } else {
            echo "Failed to add product.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="./css/addproduct.css"> <!-- Adjust the path if necessary -->

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
    <div class='addproduct'>
    <h1>Add Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required step="0.01"><br>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <input type="submit" value="Add Product">
    </form>
</div>
</body>
</html>
