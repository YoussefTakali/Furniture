<?php
require_once '../config/database.php';
require_once '../app/models/User.php';

class AuthController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Handle file upload
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                $fileName = $_FILES['profile_picture']['name'];
                $fileSize = $_FILES['profile_picture']['size'];
                $fileType = $_FILES['profile_picture']['type'];
    
                // Define the upload path
                $uploadPath = '../uploads/' . basename($fileName);
    
                // Move the file to the upload directory
                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    // Now we can register the user
                    if ($this->user->register($username, $email, $password, $fileName)) {
                        header("Location: /project/public/login.php");
                        exit();
                    } else {
                        echo "Registration failed.";
                    }
                } else {
                    echo "File upload failed.";
                }
            } else {
                echo "No file uploaded or upload error.";
            }
        }
    }
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = $this->user->login($username, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_picture'] = $user['profile_picture']; // Store the profile picture
    
                if (isset($_POST['remember_me'])) {
                    setcookie('username', $username, time() + (86400 * 30), "/");
                }
    
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid credentials.";
            }
        }
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
