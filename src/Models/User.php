<?php

namespace App\Models;

use PDO;

class User
{
    private $db;

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

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả dữ liệu
    public function findAll()
    {
        $query = "SELECT * FROM accounts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId)
    {
        $sql = "SELECT 
                user_id,
                name,
                email,
                phone,
                role,
                avatar_url
                FROM accounts 
                WHERE user_id = :userId";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Có thể bổ sung thêm các hàm tiện ích khác nếu cần
}