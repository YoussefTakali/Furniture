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
require_once '../app/controllers/OrderCrud.php';

try {
    // Pass the role to OrderCrud
    $orderCrud = new OrderCrud($pdo, $_SESSION['role']);
    // Fetch all orders
    $orders = $orderCrud->getOrders();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders List</title>
    <link rel="stylesheet" href="./css/order.css"> <!-- Link to your CSS file -->
</head>
<body>
    <!-- Navbar Section -->
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
    <div class="orders">
        <h1 style="text-align: center; color: #333;">All Orders</h1>

        <?php if (!empty($orders)): ?>
            <table style="width: 100%; border-collapse: collapse; background-color: #fff;">
                <thead>
                    <tr>
                        <th style="background-color: #e5d8af; color: #333;">Order ID</th>
                        <th style="background-color: #e5d8af; color: #333;">User ID</th>
                        <th style="background-color: #e5d8af; color: #333;">Status</th>
                        <th style="background-color: #e5d8af; color: #333;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']); ?></td>
                            <td><?= htmlspecialchars($order['user_id']); ?></td>
                            <td><?= htmlspecialchars($order['status'] ?? 'Pending'); ?></td>
                            <td>
                                <form method="POST" action="update_order.php">
                                    <input type="hidden" name="id" value="<?= $order['id']; ?>">
                                    <select name="status">
                                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="canceled" <?= $order['status'] === 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                    </select>
                                    <input type="submit" value="Update Status" class="btn">
                                </form>
                                <a href="delete_order.php?id=<?= $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="action-btn delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
