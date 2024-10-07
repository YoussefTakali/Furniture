<?php
session_start(); // Start the session

// Check if the user is logged in and has admin role
// You might want to include additional checks if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/landing.css"/> 
    <title>Landing Page</title>
</head>
<body>
    <main>
        <section id="hero">
            <p id="logo">Fur<span id="s3">niture</span></p>
            <nav class="navbar">
                <ul class="navbar-menu">
                    <li><a href="#home"> Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#item-gallery"> Categories</a></li>
                    <li><a href="./productuser.php"> Products</a></li>
                    <li class="login">
                        <a href="<?php echo isset($_SESSION['username']) ? './logout.php' : './login.php'; ?>">
                            <?php 
                                // Check if user is logged in
                                if (isset($_SESSION['username'])) {
                                    // Display username if logged in
                                    echo htmlspecialchars($_SESSION['username']);
                                    
                                    // Display profile picture if available
                                    if (!empty($_SESSION['profile_picture'])) {
                                        echo '<img id="profile" src="../uploads/' . htmlspecialchars($_SESSION['profile_picture']) . '" alt="Profile Picture">';
                                    }
                                } else {
                                    // Show "Login" if not logged in
                                    echo 'Login';
                                }
                            ?>
                        </a>
                    </li>
                </ul>
                <?php if ($_SESSION['role'] == 'admin') echo '<a id="ad" class="button round-button" href="./dashboard.php"><i class="fas fa-user-shield"></i></a>'; ?>
                </nav>
            <img src="./images/stain.png" alt="Description of image" id ='im2'>
            <img src="./images/image.png" alt="Description of image" id='im1'>
            <h1>Where Comfort<br> Meets Style -<span> Unwind<br> in Elegance</span></h1>
            <h6>craftin timeless comfort, our sofas blend luxury with functionality<br>Elevate your space with our impeccable designs, marrying style and <br>relaxation seamlessly</h6>
            <img src="./images/furniture.jpg" id ='im3'>
            <p id='firstp'>180+<br><span id='s1'>New Arrival<br>Products</span></p>
            <p id='p2'>The Unique Design Of Home <br>Decor, Office Furniture, Interior <br>Furnishings</p>
        </section>
    </main>
    <section id="about">
        <img src="./images/aboutus.jpg" alt="Description of image" id ='im4'>
        <div id='ab'>
            <h2>About Us</h2>
            <p id="aboutp">
                Welcome to our furniture store!<br>
                We specialize in high-quality, stylish pieces that<br> enhance your living space.
                Our collection features <br> a variety of designs, from modern to classic<br>, ensuring something for everyone.
                Committed to<br> sustainability, we prioritize eco-friendly materials <br>and ethical sourcing.
                Thank you for choosing us to <br>help create your dream home!
            </p>
        </div>
    </section>

    <section id="services">
        <div class="grid-section">
            <div class="grid-item">
                <h3>What We <br> Offer For You</h3>
                <img src="./images/grid1.jpg" alt="Description of image" id ='im5'>
                <p id="g1">Interior Design Consultation</p>
            </div>
            <div class="grid-item">
                <img src="./images/blue.jpg" alt="Description of image" id ='im6'>
                <p id="g1">Custom Your Own Furniture Design</p>
                <img src="./images/grid2.jpg" alt="Description of image" id ='im7'>
                <p id="g1">Furniture Assembly</p>
            </div>
            <div class="grid-item">
                <img src="./images/grid2.jpg" alt="Description of image" id ='im8'>
                <p id="g1">Furniture Restoration and Repair</p>
            </div>
        </div>
    </section>
    <section id="item-gallery">
        <h2>Our Categories</h2>
    <div class="item-grid">
        <div class="item-box">
            <img src="./images/category1.jpg" alt="Item 1">
            <p>Chairs</p>
        </div>
        <div class="item-box">
            <img src="./images/category2.jpg" alt="Item 2">
            <p>Armoire</p>
        </div>
        <div class="item-box">
            <img src="./images/category3.jpg" alt="Item 3">
            <p>sallon</p>
        </div>
    </div>
</section>
 

    <footer>
    <div class="footer-grid">
        <div class="footer-content">
            <h4 id='links'>links</h4>
            <ul class="footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
        <div class="social-media">
        <h4>Follow Us!</h4>
            <a href="#" aria-label="Facebook"><img src="facebook-icon.png" alt="Facebook"></a>
            <a href="#" aria-label="Twitter"><img src="twitter-icon.png" alt="Twitter"></a>
            <a href="#" aria-label="Instagram"><img src="instagram-icon.png" alt="Instagram"></a>
            <a href="#" aria-label="LinkedIn"><img src="linkedin-icon.png" alt="LinkedIn"></a>
        </div>
        <div class="map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.27991421256!2d-74.25987654473902!3d40.69767006885615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c250baf1b3a5df%3A0x6cda3d3ffef3a88a!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1632810238456!5m2!1sen!2sin" 
                width="auto" 
                height="250px" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
    <p>&copy; 2024 Your Furniture Store. All rights reserved.</p>
</footer>

</body>
</html>
