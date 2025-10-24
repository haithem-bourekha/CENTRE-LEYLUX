<?php
// config.php - اتصال داخلي عبر Railway Proxy

$servername = "crossover.proxy.rlwy.net";  // ← من نافذة Connect
$port       = 27752;                       // ← من نافذة Connect
$username   = "root";
$password   = "yKvfZEQRwPwPfDBSSNvECPqvtJAfTkjn";  // ← من نافذة Connect
$dbname     = "railway";

// إعدادات الاتصال
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    http_response_code(500);
    exit("فشل الاتصال بقاعدة البيانات.");
}
?>