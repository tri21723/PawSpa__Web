<?php
namespace App\Models;

use PDO;
class Booking {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserBookings($userId, $status = 'all', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
    
        $sql = "SELECT 
                    b.booking_id, b.booking_date, b.status, b.total_price, b.created_at,
                    o.order_code, s.name AS service_name
                FROM bookings b
                JOIN orders o ON b.order_id = o.order_id
                JOIN booking_details bdt ON b.booking_id = bdt.booking_id
                JOIN services s ON bdt.service_id = s.service_id
                WHERE b.user_id = :userId";
    
        // Nếu có lọc theo trạng thái
        if ($status !== 'all') {
            $sql .= " AND b.status = :status"; // Lưu ý: cần b.status
        }
    
        // Sắp xếp và phân trang
        $sql .= " ORDER BY b.created_at DESC LIMIT :limit OFFSET :offset";
    
        // Chuẩn bị câu truy vấn
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    
        // Gán giá trị nếu có điều kiện lọc theo status
        if ($status !== 'all') {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }
    
        // Thực thi và trả kết quả
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalUserBookings($userId, $status = 'all') {
        $params = ['userId' => $userId];
    
        $sql = "SELECT COUNT(*) as total FROM bookings WHERE user_id = :userId";
    
        if ($status !== 'all') {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
}
?>