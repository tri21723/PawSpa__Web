<?php
// Kết nối database
require_once "../connectdb.php";


$conn = connectDatabase();
// Lấy dữ liệu từ form
$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Kiểm tra mật khẩu khớp nhau
if ($password !== $confirm_password) {
    die("Mật khẩu không khớp.");
}

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Chèn dữ liệu vào bảng người dùng
$sql = "INSERT INTO accounts (`name`, email, `password`, phone) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $fullname, $email, $hashed_password, $phone);

if ($stmt->execute()) {
    header("Location: ../../Views/auth/loginView.php");
} else {
    echo "Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
