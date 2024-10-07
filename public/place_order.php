<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Log errors to a file

// Ensure the user is logged in

// Include necessary files
require_once '../config/database.php';
require_once '../app/controllers/OrderCrud.php';
require_once '../app/models/Order.php'; // Ensure Order model is included

// Get the data from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$userId = $_SESSION['user_id'];
$products = $data['products'];

// Create an instance of OrderCrud
try {
    $orderCrud = new OrderCrud($pdo, 'user'); // Pass the required parameters

    // Create the order
    $orderId = $orderCrud->createOrder($userId, $products, 'pending', ''); // Adjust as necessary for your parameters
    $response = ['success' => true, 'message' => 'Order placed successfully', 'order_id' => $orderId];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'An error occurred while placing the order: ' . $e->getMessage()];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
