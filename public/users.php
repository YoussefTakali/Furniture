<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You do not have permission to access this page.");
}
// Include necessary files
require_once '../config/database.php';
require_once '../app/controllers/UserCrud.php';

try {
    // Instantiate the UserCrud class
    $userCrud = new UserCrud($pdo);

    // Fetch all users
    $users = $userCrud->getUsers();

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        .boarduser{
            position:absolute;
            top:10%;
            left: 20%;
            width:70%
        }
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Light gray background */
        }

        /* Title */
        h1 {
            text-align: center;
            color: #333; /* Darker text for contrast */
            margin: 20px 0; /* Margin around title */
        }
        .sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar ul {
    padding-left: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar a {
    color: #ecf0f1;
    text-decoration: none;
    padding: 10px;
    display: block;
    border-radius: 4px;
    transition: background 0.3s;
}

.sidebar a:hover {
    background-color: #34495e;
}

        /* Message Styles */
        p.message {
            color: #28a745; /* Green color for success messages */
            text-align: center;
        }

        /* Add User Button Styles */
        .add-user-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #e5d8af; /* Main button color */
            color: #333; /* Dark text for button */
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px; /* Space below button */
        }

        /* Table Styles */
        table {
            margin: 0 auto; /* Center the table */
            width: 80%; /* Table width */
            border-collapse: collapse; /* Collapse borders */
            background-color: white; /* White background for the table */
        }

        th, td {
            border: 1px solid #ccc; /* Light gray border */
            padding: 10px; /* Padding for cells */
            text-align: center; /* Centered text */
        }

        th {
            background-color: #e5d8af; /* Header background color */
            color: #333; /* Darker text for headers */
        }

        /* Action Button Styles */
        .action-btn {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white; /* White text */
            margin: 0 5px; /* Space between buttons */
        }

        .edit-btn {
            background-color: #28a745; /* Green for edit */
        }

        .delete-btn {
            background-color: #dc3545; /* Red for delete */
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            table {
                width: 100%; /* Full width on smaller screens */
            }
        }
    </style>
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
    <div class='boarduser'>
    <h1>All Users</h1>

    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?= htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="add_user.php" class="add-user-btn">Add User</a>
    </div>

    <?php if (!empty($users)): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_user.php?id=<?= $user['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">No users found.</p>
    <?php endif; ?>
    </div>
</body>
</html>
