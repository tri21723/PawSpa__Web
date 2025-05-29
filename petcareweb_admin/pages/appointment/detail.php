<?php
require_once("../../../pages/connect.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch appointment details
$sql = "SELECT 
    b.booking_id,
    b.booking_date,
    b.created_at,
    b.status,
    b.total_price,
    a.name AS customer_name,
    a.email,
    a.phone,
    s.name AS staff_name,
    sv.name AS service_name
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lịch hẹn #<?= $booking['booking_id'] ?></title>

    <!-- CSS - Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Icon - Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/admin-common.css">
</head>
<body>
    <?php include('../../header.php'); include('../../sidebar.php'); ?>

    <main class="admin-main">
        <div class="admin-main__container">
            <!-- Start: Tiêu đề & Breadcrumb -->
            <div class="admin-main__header">
                <h2 class="admin-main__title">Chi tiết lịch hẹn #<?= $booking['booking_id'] ?></h2>
                <nav class="breadcrumb">
                    <a href="/petcareweb_admin/dashboard.html" class="breadcrumb__link">Trang chủ</a>
                    <span class="breadcrumb__separator">/</span>
                    <a href="management.php" class="breadcrumb__link">Quản lý lịch hẹn</a>
                    <span class="breadcrumb__separator">/</span>
                    <span class="breadcrumb__link--active">Chi tiết lịch hẹn</span>
                </nav>
            </div>

            <!-- Start: Action Controls -->
            <div class="admin-controls appointment-controls">
                <div class="admin-controls__group">
                    <a href="edit.php?id=<?= $booking['booking_id'] ?>" class="btn btn--primary">Cập nhật</a>
                    <button type="button" class="btn btn--danger" onclick="confirmDelete(<?= $booking['booking_id'] ?>)">Xóa lịch hẹn</button>
                </div>
            </div>

            <!-- Form chi tiết -->
            <section class="admin-form-wrapper">
                <form class="admin-form">
                    <!-- Họ và tên -->
                    <div class="admin-form__group">
                        <label for="fullName">Họ và tên khách hàng</label>
                        <input type="text" id="fullName" class="admin-form__input is-readonly" 
                               value="<?= htmlspecialchars($booking['customer_name']) ?>" readonly />
                    </div>

                    <!-- Email & SĐT -->
                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="admin-form__input is-readonly" 
                                   value="<?= htmlspecialchars($booking['email']) ?>" readonly />
                        </div>
                        <div class="admin-form__group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" class="admin-form__input is-readonly" 
                                   value="<?= htmlspecialchars($booking['phone']) ?>" readonly />
                        </div>
                    </div>

                    <!-- Nhân viên & Dịch vụ -->
                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="staff">Nhân viên thực hiện</label>
                            <select id="staff" class="admin-form__input is-readonly" disabled>
                                <option selected><?= htmlspecialchars($booking['staff_name'] ?? 'Chưa phân công') ?></option>
                            </select>
                        </div>
                        <div class="admin-form__group">
                            <label for="service">Dịch vụ</label>
                            <select id="service" class="admin-form__input is-readonly" disabled>
                                <option selected><?= htmlspecialchars($booking['service_name']) ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Ngày thực hiện & Trạng thái -->
                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="datepicker">Ngày thực hiện</label>
                            <input type="text" id="datepicker" class="admin-form__input is-readonly"
                                   value="<?= date('d/m/Y H:i', strtotime($booking['booking_date'])) ?>" readonly />
                        </div>
                        <div class="admin-form__group">
                            <label>Trạng thái</label>
                            <div class="status-badge status-badge--<?= $booking['status'] ?>">
                                <?= $booking['status'] ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tổng tiền -->
                    <div class="admin-form__group">
                        <label>Tổng tiền</label>
                        <input type="text" class="admin-form__input is-readonly" 
                               value="<?= number_format($booking['total_price']) ?>đ" readonly />
                    </div>
                </form>
            </section>
        </div>
    </main>

    <!-- Modal xác nhận xóa -->
    <div class="custom-modal" id="deleteModal">
        <div class="custom-modal__overlay"></div>
        <div class="custom-modal__content">
            <h2 class="custom-modal__title">Xác nhận xóa</h2>
            <p class="custom-modal__message">
                Bạn có chắc chắn muốn xóa lịch hẹn này?
            </p>
            <div class="custom-modal__actions">
                <button class="btn btn--secondary" onclick="closeModal()">Hủy</button>
                <button class="btn btn--danger" onclick="deleteBooking(<?= $booking['booking_id'] ?>)">Xóa</button>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function deleteBooking(id) {
        window.location.href = 'delete.php?id=' + id;
    }
    </script>
</body>
</html>