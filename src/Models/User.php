<?php

namespace App\models;

use PDO;

class User {

    private PDO $db; // kết nối database
    private $table = 'users'; // tên bảng trong database

    public $username;
    public $password;
    public $email;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}