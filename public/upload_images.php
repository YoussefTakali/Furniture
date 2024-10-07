<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

require_once '../config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product description
    $description = $_POST['description'];

    // Prepare statement to insert image data
    $stmt = $pdo->prepare("INSERT INTO product_images (image, description) VALUES (:image, :description)");

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        // Check if the file is uploaded
        if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
            $imageName = $_FILES['images']['name'][$key];
            $imagePath = '../uploads/' . basename($imageName);

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($tmp_name, $imagePath)) {
                // Bind parameters and execute
                $stmt->execute([
                    ':image' => $imagePath,
                    ':description' => $description,
                ]);
            } else {
                echo "Error uploading file: " . $_FILES['images']['name'][$key];
            }
        }
    }

    // Redirect back to the product page or any other page
    header('Location: productuser.php');
    exit;
}

?>
