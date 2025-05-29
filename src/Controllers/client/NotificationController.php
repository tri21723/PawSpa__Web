<?php
namespace App\Controllers\Client;

use App\Models\Notification;
use App\Models\User;
use PDOException;

class NotificationController
{
    private $notificationModel;
    private $userModel;
    private $db;

    public function __construct()
    {
        try {
            global $container;
            $this->db = $container->db;
            $this->notificationModel = new Notification($this->db);
            $this->userModel = new User($this->db);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            die("Database connection failed");
        }
    }

    public function index()
    {
        try {
            $userId = 2; // Set default user ID to 1
            $user = $this->userModel->getUserById($userId);
            
            // Get notifications with pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 10;

            // Get notifications
            $notifications = $this->notificationModel->getBookingNotifications($userId, $page, $perPage);
            $totalNotifications = $this->notificationModel->getTotalBookings($userId);
            $totalPages = max(1, ceil($totalNotifications / $perPage));

            render_view('client/notifications/notifications', [
                'user' => $user,
                'notifications' => $notifications,
                'page' => $page,
                'totalPages' => $totalPages,
                'title' => 'Thông Báo - PawSpa'
            ], 'client');

        } catch (\Exception $e) {
            error_log($e->getMessage());
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }
}