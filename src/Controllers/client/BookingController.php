<?php
namespace App\Controllers\Client;

use App\Models\User;
use App\Models\Booking;

class BookingController {
    public function index() {
        // Khởi tạo kết nối database
        $db = PDO();
        
        // Lấy thông tin user đầu tiên
        $userModel = new User($db);
        $user = $userModel->findAll()[0]; // Lấy user đầu tiên
        
        // Lấy danh sách booking của user
        $bookingModel = new Booking($db);
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $bookings = $bookingModel->getUserBookings($user['user_id'], $status, $page);
        
        // Lấy tổng số trang
        $totalBookings = $bookingModel->getTotalUserBookings($user['user_id'], $status);
        $perPage = 10;
        $totalPages = ceil($totalBookings / $perPage);
        
        render_view('client/booking/booking', [
            'user' => $user,
            'bookings' => $bookings,
            'page' => $page,
            'totalPages' => $totalPages,
            'status' => $status
        ], 'client');
    }
}
?>