<?php
require_once("../../../pages/connect.php");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug database connection
error_log("Database connection status: " . ($conn->ping() ? 'connected' : 'failed'));

// Test services query
$test = $conn->query("SELECT COUNT(*) as count FROM services");
if ($test) {
    $row = $test->fetch_assoc();
    error_log("Number of services in database: " . $row['count']);
} else {
    error_log("Error querying services: " . $conn->error);
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // Get and validate all form data first
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $staff_id = filter_var($_POST['staff_id'] ?? 0, FILTER_VALIDATE_INT);
        $service_id = filter_var($_POST['service_id'] ?? 0, FILTER_VALIDATE_INT);
        $booking_date = trim($_POST['booking_date'] ?? '');

        // Validate all required fields
        if (empty($name) || empty($email) || empty($phone) || empty($booking_date)) {
            throw new Exception("Vui lòng điền đầy đủ thông tin khách hàng");
        }

        if (!$service_id || $service_id <= 0) {
            throw new Exception("Vui lòng chọn dịch vụ");
        }

        if (!$staff_id || $staff_id <= 0) {
            throw new Exception("Vui lòng chọn nhân viên");
        }

        // Get service price
        $stmt = $conn->prepare("SELECT price FROM services WHERE service_id = ?");
        if (!$stmt) {
            throw new Exception("Lỗi truy vấn dịch vụ");
        }
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        
        if (!$service) {
            throw new Exception("Không tìm thấy thông tin dịch vụ");
        }
        $price = $service['price'];
        $stmt->close();

        // Create or get user
        $stmt = $conn->prepare("SELECT user_id FROM accounts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];
        } else {
            // Create new user
            $stmt = $conn->prepare("INSERT INTO accounts (name, email, phone, role) VALUES (?, ?, ?, 'customer')");
            $stmt->bind_param("sss", $name, $email, $phone);
            $stmt->execute();
            $user_id = $conn->insert_id;
        }

        // Create booking
        $status = 'pending';
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, booking_date, status, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $user_id, $booking_date, $status, $price);
        $stmt->execute();
        $booking_id = $conn->insert_id;

        // Create booking details with explicit values
        $stmt = $conn->prepare("INSERT INTO booking_details (booking_id, service_id, quantity, price) VALUES (?, ?, ?, ?)");
        $quantity = 1;
        $stmt->bind_param("iiid", $booking_id, $service_id, $quantity, $price);
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm chi tiết đặt lịch: " . $stmt->error);
        }

        // Update staff assignment
        $stmt = $conn->prepare("UPDATE accounts SET staff_id = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $staff_id, $user_id);
        $stmt->execute();

        $conn->commit();
        header("Location: management.php?success=create");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $error = $e->getMessage();
        error_log("Booking error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm lịch hẹn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS - Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <!-- Icon - Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/admin-common.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <!-- Header & Sidebar nếu có, include vào đây -->
    <?php
    include('../../header.php');
    include('../../sidebar.php');
    ?>

    <!-- Main content -->
    <main class="admin-main">
        <div class="admin-main__container">
            <div class="admin-main__header">
                <h2 class="admin-main__title">Thêm lịch hẹn</h2>
                <!-- Start: Breadcrumb -->
                <nav class="breadcrumb">
                    <a href="../../dashboard.php" class="breadcrumb__link">Trang chủ</a>
                    <span class="breadcrumb__separator">/</span>
                    <a href="./management.php" class="breadcrumb__link">Quản lý lịch hẹn</a>
                    <span class="breadcrumb__separator">/</span>
                    <span class="breadcrumb__link--active">Thêm lịch hẹn</span>
                </nav>
                <!-- End: Breadcrumb -->
            </div>
            <?php if ($error): ?>
                <div class="alert alert--danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <section class="admin-form-wrapper">
                <form class="admin-form" method="POST" action="">
                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="name">Họ và tên khách hàng</label>
                            <input type="text" id="name" name="name" class="admin-form__input" 
                                   value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                                   placeholder="Nhập tên khách hàng..." required>
                        </div>
                    </div>

                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="admin-form__input" 
                                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                   placeholder="Nhập email khách hàng..." required>
                        </div>
                        <div class="admin-form__group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="admin-form__input" 
                                   value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"
                                   placeholder="Nhập số điện thoại..." required>
                        </div>
                    </div>

                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label>Nhân viên thực hiện</label>
                            <select name="staff_id" class="admin-form__input" required>
                                <option value="">-- Chọn nhân viên --</option>
                                <?php
                                $staffQuery = "SELECT staff_id, name FROM staff ORDER BY name";
                                $staffs = $conn->query($staffQuery);
                                if ($staffs && $staffs->num_rows > 0):
                                    while($staff = $staffs->fetch_assoc()):
                                        $selected = (isset($_POST['staff_id']) && $_POST['staff_id'] == $staff['staff_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= (int)$staff['staff_id'] ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($staff['name']) ?>
                                    </option>
                                <?php 
                                    endwhile;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="admin-form__group">
                            <label>Dịch vụ</label>
                            <select name="service_id" class="admin-form__input" required>
                                <option value="">-- Chọn dịch vụ --</option>
                                <?php
                                $serviceQuery = "SELECT service_id, name, price FROM services ORDER BY name";
                                $services = $conn->query($serviceQuery);
                                
                                // Debug statement
                                error_log("Service query result: " . ($services ? $services->num_rows : 'query failed'));
                                
                                if ($services && $services->num_rows > 0):
                                    while($service = $services->fetch_assoc()):
                                        $selected = (isset($_POST['service_id']) && $_POST['service_id'] == $service['service_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= (int)$service['service_id'] ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($service['name']) ?> 
                                        (<?= number_format($service['price'], 0, ',', '.') ?>đ)
                                    </option>
                                <?php 
                                    endwhile;
                                else:
                                    error_log("No services found or query error: " . $conn->error);
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="admin-form__row">
                        <div class="admin-form__group">
                            <label for="booking_date">Ngày thực hiện</label>
                            <input type="datetime-local" id="booking_date" name="booking_date" 
                                   class="admin-form__input" required>
                        </div>
                    </div>

                    <!-- Nút hủy trong form -->
                    <div class="admin-form__actions">
                        <button type="submit" class="btn btn--primary">Lưu</button>
                        <a href="management.php" class="btn btn--secondary">Hủy</a>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#booking_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            time_24hr: true,
            locale: "vn"
        });
    </script>
    <script>
document.querySelector('.admin-form').addEventListener('submit', function(e) {
    const serviceId = document.querySelector('select[name="service_id"]').value;
    const staffId = document.querySelector('select[name="staff_id"]').value;
    
    if (!serviceId) {
        e.preventDefault();
        alert('Vui lòng chọn dịch vụ');
        return false;
    }
    
    if (!staffId) {
        e.preventDefault();
        alert('Vui lòng chọn nhân viên');
        return false;
    }
});
</script>
</body>
</html>
