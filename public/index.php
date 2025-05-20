<?php
// Define the root directory
define('ROOT_DIR', dirname(__DIR__));
define('VIEW_DIR', ROOT_DIR . '/src/views');

// Require autoload và lib.php trước
require_once ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/src/utils/lib.php';

// Cấu hình BASE_URL cho XAMPP
define('BASE_URL', 'http://localhost/PawSpa__Web/public');

// Kết nối database
try {
    $conn = new PDO("mysql:host=localhost;dbname=petcareweb_db", 'root', '');
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
