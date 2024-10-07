<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../config/database.php';
require_once '../app/controllers/UserCrud.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    $userCrud = new UserCrud($pdo);
    // Call addUser method
    if ($userCrud->addUser($username, $email, $password, $role)) {
        // Redirect back to users.php after successful addition
        header("Location: users.php?message=User+added+successfully");
        exit();
    } else {
        // Handle the failure case
        echo "Failed to add user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/adduser.css"> <!-- Adjust the path if necessary -->

    <title>Add User</title>
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
    <div class='adduser'>
    <h1>Add User</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br>

        <input type="submit" value="Add User">
    </form>
</div>
</body>
</html>
