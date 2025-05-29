<?php
require_once("../../../pages/connect.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate required fields first
        if (empty($_POST['service_id'])) {
            throw new Exception("Vui lòng chọn dịch vụ");
        }
        if (empty($_POST['staff_id'])) {
            throw new Exception("Vui lòng chọn nhân viên");
        }
        if (empty($_POST['booking_date'])) {
            throw new Exception("Vui lòng chọn ngày hẹn");
        }

        $conn->begin_transaction();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $staff_id = (int)$_POST['staff_id'];
        $service_id = (int)$_POST['service_id'];
        $booking_date = $_POST['booking_date'];

        // Validate data
        if (empty($name) || empty($email) || empty($phone)) {
            throw new Exception("Vui lòng điền đầy đủ thông tin khách hàng");
        }

        if ($service_id <= 0) {
            throw new Exception("Dịch vụ không hợp lệ");
        }

        if ($staff_id <= 0) {
            throw new Exception("Nhân viên không hợp lệ");
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT user_id FROM accounts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];
        } else {
            // Create new user
            $stmt2 = $conn->prepare("INSERT INTO accounts (name, email, phone, role) VALUES (?, ?, ?, 'customer')");
            $stmt2->bind_param("sss", $name, $email, $phone);
            $stmt2->execute();
            $user_id = $conn->insert_id;
            $stmt2->close();
        }
        $stmt->close();

        // Get service price
        $stmt = $conn->prepare("SELECT price FROM services WHERE service_id = ?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $price = $service['price'] ?? 0;
        $stmt->close();

        // Create booking
        $status = 'pending';
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, booking_date, status, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $user_id, $booking_date, $status, $price);
        $stmt->execute();
        $booking_id = $conn->insert_id;
        $stmt->close();

        // Create booking details
        $stmt = $conn->prepare("INSERT INTO booking_details (booking_id, service_id, quantity, price) VALUES (?, ?, 1, ?)");
        $stmt->bind_param("iid", $booking_id, $service_id, $price);
        $stmt->execute();
        $stmt->close();

        // Update staff assignment in accounts table
        $stmt = $conn->prepare("UPDATE accounts SET staff_id = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $staff_id, $user_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        header("Location: management.php?success=create");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        header("Location: add.php?error=save&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: add.php");
    exit();
}
?>
