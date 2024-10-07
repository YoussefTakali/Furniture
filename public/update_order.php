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
require_once '../app/models/Order.php'; // Include the Order model
require_once '../app/controllers/OrderCrud.php'; // Include the OrderCrud class

try {
    // Create an instance of OrderCrud
    $orderCrud = new OrderCrud($pdo,$_SESSION['role']); // Adjust constructor if necessary

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        // Update the order status
        if ($orderCrud->updateOrderStatus($id, $status)) {
            header("Location: orders.php"); // Redirect back to the orders page
            exit();
        } else {
            echo "Failed to update order status.";
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

