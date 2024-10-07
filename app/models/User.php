<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password, $profile_picture) {
        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();
    
        if ($emailExists > 0) {
            return false; // Email already in use
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';
    
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role, profile_picture) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword, $role, $profile_picture]);
    }
    

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return false; 
    }
    public function getAllUsers() {
        try {
            $query = $this->pdo->prepare("SELECT * FROM users");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any database errors
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function addUser($username, $email, $password, $role) {
        $query = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Hashing password
        $query->bindParam(':role', $role);
        return $query->execute();
    }

    public function editUser($id, $username, $email, $role) {
        $query = $this->pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':role', $role);
        return $query->execute();
    }

    public function deleteUser($id) {
        $query = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam(':id', $id);
        return $query->execute();
    }
}
?>
