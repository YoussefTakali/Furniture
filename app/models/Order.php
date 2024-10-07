<?php


    class Order {
        private $pdo;
    
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        public function getPDO() {
            return $this->pdo;
        }
        public function createOrder($userId, $products, $status, $note) {            // Insert order details into the orders table (assuming you have one)
            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, status) VALUES (:user_id, :status)");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':status', $orderStatus);
            $stmt->execute();
            
            // Get the last inserted order ID
            $orderId = $this->pdo->lastInsertId();
    
            // Call addOrderItem to insert items
            $this->addOrderItem($orderId, $products);
        }
    
        public function addOrderItem($orderId, $products) {
            foreach ($products as $product) {
                $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
                $stmt->bindParam(':order_id', $orderId);
                $stmt->bindParam(':product_id', $product['id']);
                $stmt->bindParam(':quantity', $product['quantity']);
    
                // Execute the statement and check for errors
                if (!$stmt->execute()) {
                    throw new Exception("Failed to add order item: " . implode(", ", $stmt->errorInfo()));
                }
            }
        }

    public function getOrders() {
        // Fixed the typo here
        $stmt = $this->pdo->prepare("SELECT * FROM orders"); // Corrected operator
        $stmt->execute(); // Execute the statement to fetch results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrdersByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
    public function deleteOrder($id) {
        $this->checkAdmin(); // Check if the user is admin
        $stmt = $this->order->getPDO()->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
