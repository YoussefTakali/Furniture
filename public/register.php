<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../app/controllers/AuthController.php';
$authController = new AuthController($pdo);
$authController->register();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/register.css"> <!-- Adjust the path as needed -->
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <label for="username">Username</label>
    <input type="text" name="username" placeholder="Enter Username" required />

    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Enter Email" required />

    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Enter Password" required />

    <label for="profile_picture">Profile Picture</label>
    <input type="file" name="profile_picture" accept="image/*" required />

    <button type="submit" class="login-btn">Register</button>
    <div class="links">
        <p><a href="login.php">Already have an account? Login here.</a></p>
    </div>
</form>

</body>
</html>

</body>
</html>
