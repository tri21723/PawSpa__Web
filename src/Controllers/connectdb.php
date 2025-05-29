<?php
function connectDatabase() {
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petcareweb_db"; // Tên database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
return $conn;
}
?>
