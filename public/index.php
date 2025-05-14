<?php

// Define the root directory
define('ROOT_DIR', dirname(__DIR__));
define('VIEW_DIR', ROOT_DIR . '/src/views');

require_once ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/src/utils/lib.php';

define('BASE_URL', 'http://localhost:8080');

// Conect to database
$servername = 'localhost';
$username = 'root';
$dbname = 'petcareweb_db';
$password = '';



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
require_once ROOT_DIR . '/src/Routes/admin.php';
require_once ROOT_DIR . '/src/Routes/client.php';

// Set 404 Not Found
require_once ROOT_DIR . '/src/Routes/error.php';

// Run it!
$router->run();
