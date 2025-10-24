<?php
$servername = $_ENV['MYSQLHOST'] ?? 'localhost';
$username = $_ENV['MYSQLUSER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = $_ENV['MYSQLDATABASE'] ?? 'training_system';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>