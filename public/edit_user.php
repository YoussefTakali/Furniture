<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../config/database.php';
require_once '../app/controllers/UserCrud.php';

// Check if the user ID is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $userCrud = new UserCrud($pdo);
    
    // Fetch all users
    $users = $userCrud->getUsers();
    // Find the user by ID
    $user = array_filter($users, fn($u) => $u['id'] == $id);
    $user = reset($user); // Get the user details

    // Check if user was found
    if (!$user) {
        die("Invalid user ID");
    }
} else {
    header("Location: users.php?message=Invalid+user+ID");
    exit();
}

// Handle form submission for editing the user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Call the editUser method
    if ($userCrud->editUser($id, $username, $email, $role)) {
        // Redirect back to users.php after successful update
        header("Location: users.php?message=User+updated+successfully");
        exit();
    } else {
        echo "Failed to update user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/edituser.css"> <!-- Adjust the path if necessary -->

    <title>Edit User</title>
</head>
<body>
<div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="./users.php">Manage Users</a></li>
            <li><a href="./products.php">Manage Products</a></li>
            <li><a href="./orders.php">Manage Orders</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
    <div class='edituser'>
    <h1>Edit User</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select><br>

        <input type="submit" value="Update User">
    </form>
</div>
</body>
</html>
