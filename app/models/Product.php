<?php
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPDO() {
        return $this->pdo;
    }
    
}
