<?php

namespace App\models;

use PDO;

class User {

    private PDO $db; // kết nối database
    private string $table = 'accounts'; // tên bảng trong database

    // các trường khớp với bảng accounts
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $role;
    public $avatar_url;
    public $created_at;
    public $updated_at;
    public $staff_id;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Lấy tất cả dữ liệu
    public function findAll() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Có thể bổ sung thêm các hàm tiện ích khác nếu cần
}