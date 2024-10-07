<?php
session_start(); // Start the session

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not admin
    exit(); // Terminate the script
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/dhashboard.css"> <!-- Link to the CSS file -->
</head>
<body>
    <!-- Sidebar -->
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

    <!-- Main content -->
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="admin-info">
                <p>Welcome, Admin</p>
            </div>
        </header>

        <section id="users" class="dashboard-section">
            <h2>Manage Users</h2>
            <p>View and manage all registered users on the platform.</p>
            <a href="users.php" class="btn">Go to Users Management</a>
        </section>

        <section id="products" class="dashboard-section">
            <h2>Manage Products</h2>
            <p>Add, edit, or remove products available in the store.</p>
            <a href="products.php" class="btn">Go to Products Management</a>
        </section>

        <section id="orders" class="dashboard-section">
            <h2>Manage Orders</h2>
            <p>Review and manage all orders placed by users.</p>
            <a href="orders.php" class="btn">Go to Orders Management</a>
        </section>
    </div>
</body>
</html>
