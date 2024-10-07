<?php
require_once '../config/database.php';
require_once '../app/models/User.php';

class UserCrud {
    private $user;
    public function __construct($pdo) {
        $this->user = new User($pdo);
    }
    public function deleteOrder($id) {
        $this->checkAdmin(); // Check if the user is admin

        // Call the deleteOrder method from OrderCrud
        if ($this->orderCrud->deleteOrder($id)) {
            echo "Order deleted successfully.";
        } else {
            echo "Failed to delete order.";
        }
    }
    private function checkAdmin() {
        if ($this->role !== 'admin') {
            throw new Exception("Access denied. Admins only.");
        }
    }
public function getUsers() {
    return $this->user->getAllUsers();
}

public function addUser($username, $email, $password, $role) {
    return $this->user->addUser($username, $email, $password, $role);
}

public function editUser($id, $username, $email, $role) {
    return $this->user->editUser($id, $username, $email, $role);
}

public function deleteUser($id) {
    return $this->user->deleteUser($id);
}
}
?>