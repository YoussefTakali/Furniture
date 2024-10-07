<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../config/database.php';
require_once '../app/controllers/UserCrud.php';

// Check if the user ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userCrud = new UserCrud($pdo);

    // Call deleteUser method and check the result
    if ($userCrud->deleteUser($id)) {
        // Redirect back to users.php after successful deletion
        header("Location: users.php?message=User+deleted+successfully");
        exit();
    } else {
        // Handle the failure case, you can redirect or show a message
        header("Location: users.php?message=Failed+to+delete+user");
        exit();
    }
} else {
    // Redirect if no user ID was provided
    header("Location: users.php?message=Invalid+user+ID");
    exit();
}
?>
