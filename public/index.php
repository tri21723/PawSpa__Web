<?php
// Define the root directory
define('ROOT_DIR', dirname(__DIR__));
define('VIEW_DIR', ROOT_DIR . '/src/Views');

// Require autoload và lib.php trước
require_once ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/src/utils/lib.php';

// Cấu hình BASE_URL cho XAMPP
define('BASE_URL', 'http://localhost/PawSpa__Web/public');

// Kết nối database
try {
    $conn = new PDO("mysql:host=localhost;dbname=petcareweb_db", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Make connection available globally
    global $container;
    $container = new stdClass();
    $container->db = $conn;
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Không thể kết nối database");
}

// Tạo Router instance
$router = new \Bramus\Router\Router();

// Define routes
require_once ROOT_DIR . '/src/Routes/client.php';
require_once ROOT_DIR . '/src/Routes/admin.php';
require_once ROOT_DIR . '/src/Routes/web.php';

// Set 404
require_once ROOT_DIR . '/src/Routes/error.php';

// Run it!
$router->run();
