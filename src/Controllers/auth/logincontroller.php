<?php
require_once "../connectdb.php";

$conn = connectDatabase();

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} 

// Lấy dữ liệu từ form
$sdt = $_POST['sdt'] ?? '';
$password = $_POST['password'] ?? '';

// Truy vấn kiểm tra tài khoản dựa trên số điện thoại
$sql = "SELECT * FROM accounts WHERE phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sdt);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // So sánh mật khẩu đã hash
    if (password_verify($password, $row['password'])) {
        // Đăng nhập thành công
        $_SESSION['name'] = $row['name']; // hoặc $_SESSION['user_id'] = $row['id'];

        header("Location: ../pages/homepage.html");
        exit();
    } else {
        // Sai mật khẩu
        echo "<script>alert('Sai mật khẩu!'); window.location.href = 'login.html';</script>";
    }
} else {
    // Không tìm thấy tài khoản
    echo "<script>alert('Tài khoản không tồn tại!'); window.location.href = 'login.html';</script>";
}

$stmt->close();
$conn->close();
?>
