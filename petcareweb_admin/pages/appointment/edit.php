<?php
// petcareweb_admin/pages/appointment/edit.php
// This file is used to edit an appointment in the admin panel  

require_once("../../../pages/connect.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_POST['staff_id'];
    $service_id = $_POST['service_id'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    try {
        // Update staff_id in accounts table
        $stmt = $conn->prepare("UPDATE accounts SET staff_id = ? WHERE user_id = (SELECT user_id FROM bookings WHERE booking_id = ?)");
        $stmt->bind_param("ii", $staff_id, $id);
        $stmt->execute();

        // Update bookings table
        $stmt = $conn->prepare("UPDATE bookings SET booking_date = ?, status = ? WHERE booking_id = ?");
        $stmt->bind_param("ssi", $booking_date, $status, $id);
        $stmt->execute();

        // Update booking_details table
        $stmt = $conn->prepare("UPDATE booking_details SET service_id = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $service_id, $id);
        $stmt->execute();

        $success = "Cập nhật lịch hẹn thành công!";
    } catch(Exception $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

// Fetch appointment details
$sql = "SELECT 
    b.booking_id,
    b.booking_date,
    b.status,
    b.total_price,
    b.created_at,
    a.name AS customer_name,
    a.email,
    a.phone,
    s.staff_id,
    s.name AS staff_name,
    sv.service_id,
    sv.name AS service_name,
    sv.price
    FROM bookings b
    INNER JOIN accounts a ON b.user_id = a.user_id
    LEFT JOIN booking_details bd ON b.booking_id = bd.booking_id
    LEFT JOIN services sv ON bd.service_id = sv.service_id
    LEFT JOIN staff s ON s.staff_id = a.staff_id
    WHERE b.booking_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    header("Location: management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật lịch hẹn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/admin-common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <?php include('../../header.php'); include('../../sidebar.php'); ?>
    
    <main class="admin-main">
        <div class="admin-main__container">
            <div class="admin-main__header">
                <h2 class="admin-main__title">Cập nhật lịch hẹn</h2>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="admin-form">
                <div class="admin-form__group">
                    <label>Khách hàng</label>
                    <input type="text" value="<?= htmlspecialchars($booking['customer_name']) ?>" readonly class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label>Nhân viên</label>
                    <select name="staff_id" class="admin-form__input" required>
                        <option value="">Chọn nhân viên</option>
                        <?php
                        // Get all staff members from staff table
                        $staffQuery = "SELECT staff_id, name FROM staff ORDER BY name";
                        $staffs = $conn->query($staffQuery);
                        
                        while($staff = $staffs->fetch_assoc()):
                            $selected = ($staff['staff_id'] == $booking['staff_id']) ? 'selected' : '';
                        ?>
                            <option value="<?= $staff['staff_id'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($staff['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="admin-form__group">
                    <label>Dịch vụ</label>
                    <select name="service_id" class="admin-form__input" required>
                        <?php
                        $services = $conn->query("SELECT service_id, name, price FROM services");
                        while($service = $services->fetch_assoc()):
                        ?>
                            <option value="<?= $service['service_id'] ?>"
                                <?= ($service['service_id'] == $booking['service_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($service['name']) ?> (<?= number_format($service['price']) ?>đ)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="admin-form__group">
                    <label>Ngày hẹn</label>
                    <input type="datetime-local" name="booking_date" 
                           value="<?= date('Y-m-d\TH:i', strtotime($booking['booking_date'])) ?>" 
                           class="admin-form__input" required>
                </div>

                <div class="admin-form__group">
                    <label>Trạng thái</label>
                    <select name="status" class="admin-form__input" required>
                        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="processing" <?= $booking['status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="btn btn--primary">Cập nhật</button>
                    <a href="management.php" class="btn btn--secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>