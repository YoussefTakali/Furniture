<?php
session_start();
require_once '../config/database.php';
require_once '../app/controllers/OrderCrud.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

$orderCrud = new OrderCrud($pdo, $_SESSION['role']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if ($orderCrud->updateOrderStatus($id, $status)) {
        header("Location: orders.php?message=Order+status+updated+successfully");
        exit();
    } else {
        echo "Failed to update order status.";
    }
}
