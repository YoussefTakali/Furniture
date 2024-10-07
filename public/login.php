<?php
session_start(); 
require_once '../app/controllers/AuthController.php';
$authController = new AuthController($pdo);
$authController->login();
$username = '';
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
}


if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ./dashboard.php'); // Redirect to admin dashboard
        exit();
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: ./landing.php'); // Redirect to user landing page
        exit();
    } else {
        header('Location: error.php'); // Redirect to error page for unknown roles
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css"/> 
    <title>Login</title>
   
</head>
<body>
    <div id="particles-js" class="snow"></div>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Enter Username" required value="<?php echo htmlspecialchars($username); ?>" />

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter Password" required />

                <button type="submit" class="login-btn">Login</button>
                <div class="links">
                    <!--<a href="#">Forgot password?</a>-->
                    <a href="register.php">Don't have an account? Register here.</a>
                </div>
            </form>
   

    
</body>
</html>
