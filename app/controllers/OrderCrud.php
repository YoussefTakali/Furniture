<?php
require_once '../app/models/Order.php';
require_once '../config/database.php';
class OrderCrud {
    private $order;
    private $role;
    private $orderModel;
    public function __construct($pdo, $role) {
        $this->order = new Order($pdo);
        $this->role = $role; // Store the user's role
        $this->orderModel = new Order($pdo); // Initialize the Order model
    }

    private function checkAdmin() {
        if ($this->role !== 'admin') {
            throw new Exception("Access denied. Admins only.");
        }
    }




    public function deleteOrder($id) {
        $this->checkAdmin(); // Check if the user is admin
        $stmt = $this->order->getPDO()->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function createOrder($userId, $products, $status, $note) {
        return $this->orderModel->createOrder($userId, $products, $status, $note);
    }

    
    public function getOrders() {
        return $this->order->getOrders(); // Use the new method in the model
    }
    public function getOrdersByUserId($userId) {
        return $this->order->getOrdersByUserId($userId);
    }
    public function updateOrderStatus($id, $status) {
        return $this->order->updateStatus($id, $status);
    }
    
}
