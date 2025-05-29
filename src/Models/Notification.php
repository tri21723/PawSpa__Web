<?php
namespace App\Models;

use PDO;

class Notification
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getBookingNotifications($userId, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT 
                b.booking_id,
                b.status,
                b.created_at,
                b.total_price,
                b.user_id,
                s.name as service_name,
                a.name as customer_name
                FROM bookings b
                LEFT JOIN booking_details bd ON b.booking_id = bd.booking_id
                LEFT JOIN services s ON bd.service_id = s.service_id
                LEFT JOIN accounts a ON b.user_id = a.user_id
                WHERE b.user_id = :user_id
                ORDER BY b.created_at DESC 
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalBookings($userId)
    {
        $sql = "SELECT COUNT(*) FROM bookings WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
?>