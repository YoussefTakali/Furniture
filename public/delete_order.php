<?php
session_start();
require_once '../config/database.php';
require_once '../app/controllers/OrderCrud.php';

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

// Create an instance of OrderCrud
$orderCrud = new OrderCrud($pdo,$_SESSION['role']);

// Check if an ID has been provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Call the deleteOrder method
    if ($orderCrud->deleteOrder($id)) {
        // Redirect with success message
        header("Location: orders.php?message=Order+deleted+successfully");
    } else {
        // Redirect with error message if deletion fails
        header("Location: orders.php?message=Failed+to+delete+order");
    }
    exit();
} else {
    die("Invalid order ID");
}
