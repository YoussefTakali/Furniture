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
    $productCrud->deleteProduct($id);
    header("Location: products.php?message=Product+deleted+successfully");
    exit();
} else {
    die("Invalid product ID");
}
