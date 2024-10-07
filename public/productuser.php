<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Log errors to a file

// Ensure the user is logged in

// Include necessary files
require_once '../config/database.php';
require_once '../app/controllers/ProductCrud.php';

try {
    // Create an instance of ProductCrud
    $productCrud = new ProductCrud($pdo, 'user'); // Pass any role
    // Fetch all products
    $products = $productCrud->getProducts();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products List</title>
    <link rel="stylesheet" href="./css/productuser.css"> <!-- Adjust the path if necessary -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script>
        // Array to hold the selected products
        let cart = [];

        // Function to add a product to the cart
        function addToCart(product, quantity = 1) {
            if (quantity <= 0) {
                alert("Quantity must be greater than zero.");
                return;
            }

            const existingProduct = cart.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.quantity += quantity; // Increase quantity if already in cart
            } else {
                cart.push({ ...product, quantity });
            }
            alert(`${product.product_name} added to cart!`);
        }

        // Function to update cart display
        function updateCartDisplay() {
            const cartBody = document.getElementById('cart-body');
            cartBody.innerHTML = ''; // Clear existing cart items

            cart.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.product_name}</td>
                    <td>$${item.price}</td>
                    <td>
                        <button onclick="decreaseQuantity(${item.id})">-</button>
                        ${item.quantity}
                        <button onclick="increaseQuantity(${item.id})">+</button>
                    </td>
                    <td><button onclick="removeFromCart(${item.id})">Remove</button></td>
                `;
                cartBody.appendChild(row);
            });
        }

        // Function to increase quantity
        function increaseQuantity(productId) {
            const product = cart.find(item => item.id === productId);
            if (product) {
                product.quantity += 1; // Increase quantity
                updateCartDisplay();
            }
        }

        // Function to decrease quantity
        function decreaseQuantity(productId) {
            const product = cart.find(item => item.id === productId);
            if (product) {
                product.quantity -= 1; // Decrease quantity
                if (product.quantity <= 0) {
                    removeFromCart(productId); // Remove product if quantity is zero
                } else {
                    updateCartDisplay();
                }
            }
        }

        // Function to remove a product from the cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId); // Filter out the removed product
            updateCartDisplay();
        }

        // Function to place the order
        function placeOrder() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    fetch('place_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ products: cart })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.message === "Login please.") {
            alert(data.message); // Display alert if user needs to log in
            window.location.href = 'login.php'; // Redirect to login page
        } else if (data.success) {
            alert("Order placed successfully!");
            cart = []; // Clear the cart after placing the order
            updateCartDisplay(); // Clear cart display
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while placing the order");
    });
}


        // Modal functions
        function openModal() {
            document.getElementById("cartModal").style.display = "block";
            updateCartDisplay(); // Update cart display when opening the modal
        }

        function closeModal() {
            document.getElementById("cartModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("cartModal")) {
                closeModal();
            }
        }
        // Open the upload modal
function openUploadModal() {
    document.getElementById('uploadModal').style.display = 'block';
}

// Close the upload modal
function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById('uploadModal')) {
        closeUploadModal();
    }
}

    </script>
</head>
<body>
<p id="logo">Fur<span id="s3">niture</span></p>
            <nav class="navbar">
                <ul class="navbar-menu">
                    <li><a href="./landing.php"> Home</a></li>
                    <li><a href="./landing.php#about">About</a></li>
                    <li><a href="./landing.php#services">Services</a></li>
                    <li><a href="./landing.php#item-gallery"> Categories</a></li>
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
            <button class="upload-btn" onclick="openUploadModal()">Customize Your Own Design</button>
    <h1 class="title-shop">SHOP</h1>
    <button class="view-cart-button" onclick="openModal()">
    <i class="fas fa-shopping-cart"></i> <!-- Cart icon -->
    <span class="cart-count">3</span> <!-- Optional: to show item count -->
</button>    <main class="main bd-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $index => $product): ?>
                <article class="card">
                    <div class="card__img">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/180" alt="No image available">
                        <?php endif; ?>
                    </div>
                    <div class="card__name">
                        <p><?= htmlspecialchars($product['product_name']); ?></p>
                    </div>
                    <div class="card__precis">
                        <a href="" class="card__icon"><ion-icon name="heart-outline"></ion-icon></a>
                        <div>
                            <span class="card__preci card__preci--before">$<?= htmlspecialchars($product['price']); ?></span>
                            <span class="card__preci card__preci--now">$<?= htmlspecialchars($product['price']); ?></span>
                        </div>
                        <a href="javascript:void(0);" class="card__icon" onclick="addToCart({ id: <?= $product['id']; ?>, product_name: '<?= htmlspecialchars($product['product_name']); ?>', price: <?= $product['price']; ?> })">
                            <ion-icon name="cart-outline"></ion-icon>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </main>

    <!-- Modal for Cart -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Your Cart</h2>
            <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    <!-- Cart items will be displayed here -->
                </tbody>
            </table>
            <button onclick="placeOrder()">Place Order</button>
        </div>
    </div>
<!-- Modal for Uploading Images & Description -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUploadModal()">&times;</span>
        <h2>Upload Images & Description</h2>
        <form id="uploadForm" method="POST" enctype="multipart/form-data" action="upload_images.php">
        <input type="hidden" name="product_id" value="<?= $product['id']; ?>"> <!-- Pass the product ID here -->
            <label for="productDescription">Product Description:</label>
            <textarea name="description" id="productDescription" rows="4" placeholder="Enter product description" required></textarea>

            <label for="productImages">Select Images:</label>
            <input type="file" id="productImages" name="images[]" multiple required>

            <button type="submit" class="submit-upload-btn">Submit</button>
        </form>
    </div>
</div>

    <footer>
        <a href="https://github.com/bedimcode">CR : Bedimcode</a> 
    </footer>
</body>
</html>
