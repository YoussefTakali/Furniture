<?php
require_once '../app/models/Product.php';

class ProductCrud {
    private $product;
    private $role;

    public function __construct($pdo, $role) {
        $this->product = new Product($pdo);
        $this->role = $role; // Store the user's role
    }

    private function checkAdmin() {
        if ($this->role !== 'admin') {
            throw new Exception("Access denied. Admins only.");
        }
    }

    public function getProducts() {
        $stmt = $this->product->getPDO()->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price, $imagePath) {
        $stmt = $this->product->getPDO()->prepare("INSERT INTO products (product_name, description, price, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $imagePath]);
    }
    public function editProduct($id, $name, $description, $price) {
        $this->checkAdmin(); // Check if the user is admin
        $stmt = $this->product->getPDO()->prepare("UPDATE products SET product_name = ?, description = ?, price = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $id]);
    }

    public function deleteProduct($id) {
        $this->checkAdmin(); // Check if the user is admin
        $stmt = $this->product->getPDO()->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
